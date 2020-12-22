<?php

namespace App\Controller;

use App\Entity\Inscriptionacad;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Modaliteenseignement;
use App\Entity\Preinscription;
use App\Form\InscriptionacadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/inscriptionacad")
 */
class InscriptionacadController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="inscriptionacad_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index() {
        $inscriptionacads = $this->getDoctrine()
                ->getRepository(Inscriptionacad::class)
                ->findAll();

        return $inscriptionacads;
    }

    /**
     * @Rest\Get(path="/preinscription/{id}", name="inscriptionacad_by_preinscription")
     * @Rest\View(StatusCode = 200)
     */
    public function findByPreinscription(Preinscription $preinscription) {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository(Classe::class)->findOneBy(['idniveau' => $preinscription->getIdniveau(),
            'idfiliere' => $preinscription->getIdfiliere(), 'idanneeacad' => $preinscription->getIdanneeacad()]);
        if (!$classe) {
            throw $this->createNotFoundException("Classe introuvable pour la preinscription selectionnée");
        }
        $inscriptionacads = $em->createQuery("select ia from App\Entity\Inscriptionacad ia, "
                        . "App\Entity\Etudiant et where ia.idclasse=?1 and ia.idetudiant=et and et.cni=?2 ")
                ->setParameter(1, $classe)
                ->setParameter(2, $preinscription->getCni())
                ->getResult();


        return count($inscriptionacads) ? $inscriptionacads[0] : array('id' => null);
    }

    /**
     * @Rest\Get(path="/mes-inscriptions/", name="mes_inscriptionacad_index")
     * @Rest\View(StatusCode = 200)
     */
    public function getInscriptionEtudiantConnecte(): array {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->createQuery('select ia from App\Entity\Inscriptionacad ia, '
                        . 'App\Entity\Classe c, App\Entity\Anneeacad aa where '
                        . 'ia.idclasse=c and c.idanneeacad=aa and ia.idetudiant=?1 and ia.etat=?2 '
                        . 'order by aa.id DESC')
                ->setParameter(1, EtudiantController::getEtudiantConnecte($this))
                ->setParameter(2, 'V')
                ->getResult();
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Post(Path="/create", name="inscriptionacad_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): Inscriptionacad {
        $inscriptionacad = new Inscriptionacad();
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacad);
        $form->submit(Utils::serializeRequestContent($request));

        $inscriptionacad->setDateinscacad(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $requestData = json_decode($request->getContent());
        if (!isset($requestData->preinscirptionId)) {
            throw $this->createNotFoundException("Préinscription correspondante introuvable...");
        }
        $preinscriptionId = $requestData->preinscirptionId;
        $preinscription = $entityManager->getRepository(Preinscription::class)
                ->find($preinscriptionId);
        $inscriptionacad->setPassage($preinscription->getPassage());
        $inscriptionacad->setIdfosuser($this->getUser());
        $inscriptionacad->setEtat("I");

        $etudiant = $entityManager->getRepository(Etudiant::class)
                ->findOneByCni($preinscription->getCni());
        if (!$etudiant) {
            throw $this->createNotFoundException("Etudiant introuvable...");
        }
        $inscriptionacad->setIdetudiant($etudiant);

        $classe = $entityManager->getRepository(Classe::class)
                ->findOneBy(['idfiliere' => $preinscription->getIdfiliere(),
            'idniveau' => $preinscription->getidniveau(),
            'idanneeacad' => $preinscription->getIdanneeacad()]);
        if (!$classe) {
            throw $this->createNotFoundException("Aucune classe trouvée pour effectuer l'inscription...");
        }

        $inscriptionacad->setIdclasse($classe);

        //set default modalité enseignement à presentiel
        $modaliteEnseignementPresentiel = $entityManager
                ->getRepository("App\Entity\Modaliteenseignement")
                ->findOneByCodemodaliteenseignement('PRES');
        if (!$modaliteEnseignementPresentiel) {
            throw $this->createNotFoundException("Modalité enseignement presentiel introuvable...");
        }
        $inscriptionacad->setIdmodaliteenseignement($modaliteEnseignementPresentiel);
        // si paiement déja effectué, prendre le paiement selectioné
        // si paiement non effectué, selectionner touch comme moyen de paiement
        if ($preinscription->getPaiementConfirme()) {
            $inscriptionacad->setMontantinscriptionacad($preinscription->getMontant());
        } else {
            //find moyen paiement TouchPay
            $modepaiement = $entityManager->getRepository("App\Entity\Modepaiement")
                    ->findOneByCodemodepaiement("TP");
            if (!$modepaiement) {
                throw $this->createNotFoundException("Mode de paiement TouchPay introuvable...");
            }
            $inscriptionacad->setIdmodepaiement($modepaiement);
        }

        //find non boursier et le definir
        $typeBourseNonBoursier = $entityManager->getRepository("App\Entity\Bourse")
                ->findOneByCodebourse("NB");
        if (!$typeBourseNonBoursier) {
            throw $this->createNotFoundException("Type de bourse introuvable pour Non Boursier");
        }
        $inscriptionacad->setIdbourse($typeBourseNonBoursier);

        $entityManager->persist($inscriptionacad);
        $entityManager->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscriptionacad_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_AFFICHAGE")
     */
    public function show(Inscriptionacad $inscriptionacad): Inscriptionacad {
        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="inscriptionacad_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad {
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacad);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="inscriptionacad_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_CLONE")
     */
    public function cloner(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacadNew = new Inscriptionacad();
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacadNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionacadNew);

        $em->flush();

        return $inscriptionacadNew;
    }

    /**
     * @Rest\Delete("/{id}", name="inscriptionacad_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_DELETE")
     */
    public function delete(Inscriptionacad $inscriptionacad): Inscriptionacad {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($inscriptionacad);
        $entityManager->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Post("/delete-selection/", name="inscriptionacad_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $inscriptionacads = Utils::getObjectFromRequest($request);
        if (!count($inscriptionacads)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($inscriptionacads as $inscriptionacad) {
            $inscriptionacad = $entityManager->getRepository(Inscriptionacad::class)->find($inscriptionacad->id);
            $entityManager->remove($inscriptionacad);
        }
        $entityManager->flush();

        return $inscriptionacads;
    }

}
