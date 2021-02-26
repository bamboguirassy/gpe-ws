<?php

namespace App\Controller;

use App\Entity\InscriptionTemporaire;
use App\Form\InscriptionTemporaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Inscriptionacad;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Modaliteenseignement;
use App\Entity\Preinscription;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/api/inscriptiontemporaire")
 */
class InscriptionTemporaireController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="inscription_temporaire_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_LISTE")
     */
    public function index(): array
    {
        $inscriptionTemporaires = $this->getDoctrine()
            ->getRepository(InscriptionTemporaire::class)
            ->findAll();

        return count($inscriptionTemporaires)?$inscriptionTemporaires:[];
    }
    
    /**
     * @Rest\Get(path="/en-cours/etudiant/{id}", name="find_inscription_temporaire_en_cours")
     * @Rest\View(StatusCode = 200)
     */
    public function findEncoursByEtudiant(Etudiant $etudiant, EntityManagerInterface $entityManager) {
        $query = "
            SELECT insac
            FROM App\Entity\Inscriptionacad insac
            WHERE insac IN (
                SELECT DISTINCT ia
                FROM App\Entity\Inscriptionacad ia
                JOIN ia.idetudiant etu
                JOIN ia.idclasse classe
                JOIN classe.idanneeacad anneeacad
                WHERE anneeacad = (:lastAnneeEnCours)
                    AND etu = :etudiant
            )
        ";

        $subQuery = '
            SELECT an
            FROM App\Entity\Anneeacad an
            WHERE an.encours = :enCours
            ORDER BY an.id DESC
        ';

        $lastAnneeEnCours = $entityManager
                ->createQuery($subQuery)
                ->setParameter('enCours', true)
                ->setMaxResults(1)
                ->getSingleResult();

        return $entityManager
                        ->createQuery($query)
                        ->setParameter('etudiant', $etudiant)
                        ->setParameter('lastAnneeEnCours', $lastAnneeEnCours)
                        ->setMaxResults(1)
                        ->getSingleResult();
    }
    
    

    /**
     * @Rest\Get(path="/preinscription/{id}", name="inscriptiontemporaire_by_preinscription")
     * @Rest\View(StatusCode = 200)
     */
    public function findByPreinscription(Preinscription $preinscription) {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository(Classe::class)->findOneBy(['idniveau' => $preinscription->getIdniveau(),
            'idfiliere' => $preinscription->getIdfiliere(), 'idanneeacad' => $preinscription->getIdanneeacad()]);
        if (!$classe) {
            throw $this->createNotFoundException("Classe introuvable pour la preinscription selectionnée");
        }
        $inscriptionTemporaires = $em->createQuery("select it from App\Entity\InscriptionTemporaire it, "
                        . "App\Entity\Etudiant et where it.idclasse=?1 and it.idetudiant=et and et.cni=?2 ")
                ->setParameter(1, $classe)
                ->setParameter(2, $preinscription->getCni())
                ->getResult();


        return count($inscriptionTemporaires) ? $inscriptionTemporaires[0] : array('id' => null);
    }

    /**
     * @Rest\Post(Path="/create", name="inscription_temporaire_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): InscriptionTemporaire    {
        $inscriptionTemporaire = new InscriptionTemporaire();
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaire);
        $form->submit(Utils::serializeRequestContent($request));
        
        $entityManager = $this->getDoctrine()->getManager();

        $requestData = json_decode($request->getContent());
        if (!isset($requestData->preinscirptionId)) {
            throw $this->createNotFoundException("Préinscription correspondante introuvable...");
        }
        $preinscriptionId = $requestData->preinscirptionId;
        $preinscription = $entityManager->getRepository(Preinscription::class)
                ->find($preinscriptionId);
        $inscriptionTemporaire->setPassage($preinscription->getPassage());

        $etudiant = $entityManager->getRepository(Etudiant::class)
                ->findOneByCni($preinscription->getCni());
        if (!$etudiant) {
            throw $this->createNotFoundException("Etudiant introuvable...");
        }
        $inscriptionTemporaire->setIdetudiant($etudiant);

        $classe = $entityManager->getRepository(Classe::class)
                ->findOneBy(['idfiliere' => $preinscription->getIdfiliere(),
            'idniveau' => $preinscription->getidniveau(),
            'idanneeacad' => $preinscription->getIdanneeacad()]);
        if (!$classe) {
            throw $this->createNotFoundException("Aucune classe trouvée pour effectuer l'inscription...");
        }

        $inscriptionTemporaire->setIdclasse($classe);

        //set default modalité enseignement à presentiel
        $modaliteEnseignementPresentiel = $entityManager
                ->getRepository("App\Entity\Modaliteenseignement")
                ->findOneByCodemodaliteenseignement('PRES');
        if (!$modaliteEnseignementPresentiel) {
            throw $this->createNotFoundException("Modalité enseignement presentiel introuvable...");
        }
        $inscriptionTemporaire->setIdmodaliteenseignement($modaliteEnseignementPresentiel);
        // si paiement déja effectué, prendre le paiement selectioné
        // si paiement non effectué, selectionner touch comme moyen de paiement
        if ($preinscription->getPaiementConfirme()) {
            $inscriptionTemporaire->setMontantinscriptionacad($preinscription->getMontant());
            //find moyen paiement Campusen
            $modepaiement = $entityManager->getRepository("App\Entity\Modepaiement")
                    ->findOneByCodemodepaiement("CAMPUSEN");
            if (!$modepaiement) {
                throw $this->createNotFoundException("Mode de paiement Campusen introuvable...");
            }
            $inscriptionTemporaire->setIdmodepaiement($modepaiement);
        } else {
            //find moyen paiement TouchPay
            $modepaiement = $entityManager->getRepository("App\Entity\Modepaiement")
                    ->findOneByCodemodepaiement("TP");
            if (!$modepaiement) {
                throw $this->createNotFoundException("Mode de paiement TouchPay introuvable...");
            }
            $inscriptionTemporaire->setIdmodepaiement($modepaiement);
        }

        //find non boursier et le definir
        $typeBourseNonBoursier = $entityManager->getRepository("App\Entity\Bourse")
                ->findOneByCodebourse("NB");
        if (!$typeBourseNonBoursier) {
            throw $this->createNotFoundException("Type de bourse introuvable pour Non Boursier");
        }
        $inscriptionTemporaire->setIdbourse($typeBourseNonBoursier);

        // if etudiant sénégalais mettre croust à true
        if ($inscriptionTemporaire->getIdetudiant()->getNationalite()->getAlpha2() == 'SN') {
            $inscriptionTemporaire->setCroust(true);
        }

        $entityManager->persist($inscriptionTemporaire);
        $entityManager->flush();

        return $inscriptionTemporaire;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscription_temporaire_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_AFFICHAGE")
     */
    public function show(InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        return $inscriptionTemporaire;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="inscription_temporaire_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaire);
        $form->submit(Utils::serializeRequestContent($request));
        
        // if etudiant sénégalais mettre croust à true
        if ($inscriptionTemporaire->getIdetudiant()->getNationalite()->getAlpha2() == 'SN') {
            $inscriptionTemporaire->setCroust(true);
        }

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionTemporaire;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="inscription_temporaire_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_CLONE")
     */
    public function cloner(Request $request, InscriptionTemporaire $inscriptionTemporaire):  InscriptionTemporaire {
        $em=$this->getDoctrine()->getManager();
        $inscriptionTemporaireNew=new InscriptionTemporaire();
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaireNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionTemporaireNew);

        $em->flush();

        return $inscriptionTemporaireNew;
    }

    /**
     * @Rest\Delete("/{id}", name="inscription_temporaire_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_SUPPRESSION")
     */
    public function delete(InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($inscriptionTemporaire);
        $entityManager->flush();

        return $inscriptionTemporaire;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="inscription_temporaire_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $inscriptionTemporaires = Utils::getObjectFromRequest($request);
        if (!count($inscriptionTemporaires)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($inscriptionTemporaires as $inscriptionTemporaire) {
            $inscriptionTemporaire = $entityManager->getRepository(InscriptionTemporaire::class)->find($inscriptionTemporaire->id);
            $entityManager->remove($inscriptionTemporaire);
        }
        $entityManager->flush();

        return $inscriptionTemporaires;
    }
}
