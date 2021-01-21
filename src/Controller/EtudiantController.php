<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Inscriptionacad;
use App\Form\EtudiantType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/etudiant")
 */
class EtudiantController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="etudiant_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ETUDIANT_LISTE")
     */
    public function index(): array {
        $etudiants = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->findAll();

        return count($etudiants) ? $etudiants : [];
    }

    /**
     * @Rest\Get(path="/search/{numeroInterne}", name="etudiant_search")
     * @Rest\View(statusCode = 200)
     */
    public function searchByNumeroDossier(Request $request, $numeroInterne, EntityManagerInterface $entityManager) {

        $query = "
            SELECT et
            FROM App\Entity\Etudiant et
            WHERE et IN (
                SELECT DISTINCT etu
                FROM App\Entity\Inscriptionacad ia
                JOIN ia.idetudiant etu
                JOIN ia.idclasse classe
                JOIN classe.idanneeacad anneeacad
                WHERE anneeacad = (:lastAnneeEnCours)
                    AND etu.numinterne LIKE :numeroInterneTerm
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
            ->setParameter('numeroInterneTerm', $numeroInterne . '%')
            ->setParameter('lastAnneeEnCours', $lastAnneeEnCours)
            ->getResult();

    }

    /**
     * @Rest\Get(path="/statistique-globale/", name="etudiant_statistique_globale")
     * @Rest\View(StatusCode = 200)
     */
    public function findGlobalStatistiqueByEtudiant(): array {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $nombreInscription = 0;
        $nombreClasseRedoublee = 0;
        $nombrePassageConditionnel = 0;
        $nombreUeNonValidee = 0;
        $nombreUeValidee = 0;
        $nombrePreinscriptionActive = 0;

        return [
            'nombreInscription' => $nombreInscription,
            'nombreClasseRedoublee' => $nombreClasseRedoublee,
            'nombrePassageConditionnel' => $nombrePassageConditionnel,
            'nombreUeNonValidee' => $nombreUeNonValidee,
            'nombreUeValidee' => $nombreUeValidee,
            'nombrePreinscriptionActive' => $nombrePreinscriptionActive,
        ];
    }

    /**
     * @Rest\Get(path="/statistique-parcours/{id}", name="etudiant_statistique_globale")
     * @Rest\View(StatusCode = 200)
     */
    public function findStatistiqueParcoursByEtudiant(Inscriptionacad $inscriptionacad): array {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $nombreUeInscrite = 0;
        $totalCreditInscrit = 0;
        $totalCreditCapitalise = 0;
        $nombreUeNonValidee = 0;
        $nombreUeValidee = 0;
        $nombreUeAnterieureReprise = 0;

        return [
            'nombreUeInscrite' => $nombreUeInscrite,
            'totalCreditInscrit' => $totalCreditInscrit,
            'totalCreditCapitalise' => $totalCreditCapitalise,
            'nombreUeNonValidee' => $nombreUeNonValidee,
            'nombreUeValidee' => $nombreUeValidee,
            'nombreUeAnterieureReprise' => $nombreUeAnterieureReprise,
        ];
    }

    /**
     * @Rest\Post(Path="/create", name="etudiant_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_NOUVEAU")
     */
    public function create(Request $request): Etudiant {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etudiant);
        $entityManager->flush();

        return $etudiant;
    }

    /**
     * @Rest\Post(Path="/public/create-primoentrant/", name="etudiant_primoentrant_new")
     * @Rest\View(StatusCode=200)
     */
    public function createPrimoEntrant(Request $request): Etudiant {
        $etudiant = new Etudiant();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));
        $reqData = Utils::getObjectFromRequest($request);
        if (isset($reqData->datenaiss)) {
            $etudiant->setDatenaiss(new \DateTime($reqData->datenaiss));
        }
        $preinscriptionActifs = $em
                ->createQuery('select p from App\Entity\Preinscription p '
                        . 'where p.datenotif<=?1 and p.datedelai>=?2 '
                        . 'and p.cni=?3 and p.estinscrit=?4')
                ->setParameter(1, new \DateTime())
                ->setParameter(2, new \DateTime())
                ->setParameter(3, $etudiant->getCni())
                ->setParameter(4, false)
                ->getResult();
        if (!count($preinscriptionActifs)) {
            // si aucune préinscription actif, vérifier si l'étudiant a une préinscription en suspens
            $preinscriptionInactifs = $em
                    ->createQuery('select p from App\Entity\Preinscription p '
                            . 'where p.cni=?3 and p.estinscrit=?4')
                    ->setParameter(3, $etudiant->getCni())
                    ->setParameter(4, false)
                    ->getResult();
            if (count($preinscriptionInactifs)) {
                throw $this->createAccessDeniedException("Votre campagne d'inscription n'est pas encore ouverte, merci de patienter !");
            }
            throw $this->createNotFoundException("Nous n'avons pas pu vous authentifier, si vous pensez qu'il s'agit d'une erreur,"
                    . " merci de vous rapprocher de la DSOS de l'université de Thiès.");
        }
        $preinscription = $preinscriptionActifs[0];
        $etudiant->setNuminterne($this->genererNumInterne($preinscription));

        //generer mail univ    si ça n'existe pas

        $mail = \App\Ldap\LdapManager::getInstance()->addPrimoEntrant($etudiant, $preinscription, $this);
        $etudiant->setEmailUniv($mail);
        $etudiant->setNotifmail(0);

        $em->persist($etudiant);
        $em->flush();

        return $etudiant;
    }

    /**
     * @Rest\Post(Path="/upload-photo/{id}", name="etudiant_photo_upload")
     * @Rest\View(StatusCode=200)
     */
    public function uploadPhoto(Request $request, Etudiant $etudiant, \App\Utils\FileUploader $uploader): Etudiant {
        $host = $request->getHttpHost();
        $scheme = $request->getScheme();
        $data = Utils::getObjectFromRequest($request);
        $fileName = $data->filename;
        file_put_contents($fileName, base64_decode($data->photo));
        $file = new \Symfony\Component\HttpFoundation\File\File($fileName);
        $authorizedExtensions = ['jpeg', 'jpg', 'png'];
        if (!in_array($file->guessExtension(), $authorizedExtensions)) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('Fichier non pris en charge');
        }
        $newFileName = $uploader->setTargetDirectory('etudiant_photo_directory')->upload($file, $etudiant->getNuminterne(), $etudiant->getPhoto()); // old fileName
        $etudiant->setPhotoLink("$scheme://$host/" . $uploader->getTargetDirectory() . $newFileName);
        $etudiant->setPhoto($newFileName);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $etudiant;
    }

    /**
     * @Rest\Get(path="/{id}", name="etudiant_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_AFFICHAGE")
     */
    public function show(Etudiant $etudiant): Etudiant {
        return $etudiant;
    }

    /**
     * @Rest\Get(path="/public/{id}/show-generated-fields", name="etudiant_display_generated_fields",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function showGeneratedFields(Etudiant $etudiant): array {
        return ['numinterne' => $etudiant->getNuminterne(), 'emailUniv' => $etudiant->getEmailUniv(), 'email' => $etudiant->getEmail()];
    }

    /**
     * @Rest\Get(path="/situation-matrimoniale/", name="situation_matrimoniale_list")
     * @Rest\View(StatusCode=200)
     */
    public function getSituationMatrimonialeValues() {
        return [
            ["value" => 'C', "label" => 'Célibataire'],
            ["value" => 'M', "label" => 'Marié (e)'],
            ["value" => 'D', "label" => 'Divorcé (e)'],
            ["value" => 'V', "label" => 'Veuf (ve)']
        ];
    }

    /**
     * @Rest\Get(path="/handicap/", name="handicap_list")
     * @Rest\View(StatusCode=200)
     */
    public function getHandicapValues() {
        return [
            ["value" => 'Oui', "label" => 'Oui'],
            ["value" => 'Non', "label" => 'Non']
        ];
    }

    /**
     * @Rest\Get(path="/orphelin/", name="orphelin_list")
     * @Rest\View(StatusCode=200)
     */
    public function getOrphelinValues() {
        return [
            ["value" => 'Oui', "label" => 'Oui'],
            ["value" => 'Non', "label" => 'Non']
        ];
    }

    /**
     * @Rest\Get(path="/type-handicap/", name="type_handicap_list")
     * @Rest\View(StatusCode=200)
     */
    public function getTypeHandicapValues() {
        return [
            ["value" => 'Handicap mental (ou déficience intellectuelle)', "label" => 'Handicap mental (ou déficience intellectuelle'],
            ["value" => 'Handicap auditif', "label" => 'Handicap auditif'],
            ["value" => 'Handicap visuel', "label" => "Handicap visuel"],
            ["value" => 'Handicap moteur', "label" => "Handicap moteur"],
            ["value" => 'Autisme et Troubles Envahissants du Développement', "label" => 'Autisme et Troubles Envahissants du Développement'],
            ["value" => 'Handicap Psychique', "label" => 'Handicap Psychique'],
            ["value" => 'Plurihandicap', "label" => 'Plurihandicap'],
            ["value" => 'Polyhandicap', "label" => 'Polyhandicap'],
            ["value" => 'Traumatismes crâniens', "label" => 'Traumatismes crâniens'],
            ["value" => 'Maladies dégénératives', "label" => 'Maladies dégénératives'],
            ["value" => 'Troubles dys', "label" => 'Troubles dys']
        ];
    }

    /**
     * @Rest\Get(path="/cni/{cni}", name="etudiant_by_cni")
     * @Rest\View(StatusCode=200)
     */
    public function findByCni($cni): Etudiant {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository(Etudiant::class)->findOneByCni($cni);
        if (!$etudiant) {
            throw $this->createNotFoundException("Etudiant introuvable avec le cni :" . $cni);
        }
        return $etudiant;
    }

    /**
     * @Rest\Get(path="/mon-compte/", name="etudiant_mon_compte")
     * @Rest\View(StatusCode=200)
     */
    public function getMonCompteEtudiant(): Etudiant {
        return EtudiantController::getEtudiantConnecte($this);
    }

    /**
     * @Rest\Get(path="/find-by-email/{emailUniv}", name="find_user_email")
     * @Rest\View(StatusCode=200)
     */
    public function findUserByEmail($emailUniv) {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->createQuery('select fs from App\Entity\FosUser fs '
                        . 'where fs.username =?1')
                ->setParameter(1, $emailUniv)
                ->getSingleResult()
        ;

        return $etudiant;
    }
    /**
     * @Rest\Get(path="/send-by-email/{id}", name="send_email")
     * @Rest\View(StatusCode=200)
     */
    public function sendEmail(Etudiant $etudiant,  \Swift_Mailer $mailer) {
        $message = (new \Swift_Message('Message'))
                ->setFrom($etudiant->getEmailUniv())
                ->setTo(Utils::$senderEmail)
                ->setCc($etudiant->getEmail())
                 ->setBody(
                         '',
                         'text/htlm'
                
        );
       $mailer->send($message);
       return $etudiant;
       
    }


    /*
     * $em->createQuery("select ia from App\Entity\Inscriptionacad ia, "
      . "App\Entity\Etudiant et where ia.idclasse=?1 and ia.idetudiant=et and et.cni=?2 ")
      ->setParameter(1, $classe)
      ->setParameter(2, $preinscription->getCni())
      ->getResult();
     */

    public static function getEtudiantConnecte($controller) {
        $etudiants = $controller->getDoctrine()->getManager()->createQuery('select et from App\Entity\Etudiant et '
                        . 'where et.emailUniv=?1')
                ->setParameter(1, $controller->getUser()->getEmail())
                ->getResult();
        if (count($etudiants) < 1) {
            throw new \Exception("Votre compte n'est rattaché à aucun étudiant.", 401, null);
        }
        return $etudiants[0];
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="etudiant_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, Etudiant $etudiant): Etudiant {
        $oldEmail = $etudiant->getEmail();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));
        //find
        if ($etudiant->getAdPays()->getAlpha2() != 'SN') {
            $senegal = $em->getRepository(\App\Entity\Pays::class)->findOneByAlpha2('SN');
            $etudiant->setAdpays($senegal);
        }
        if ($etudiant->getHandicap() == 'Non') {
            $etudiant->setTypeHandicap(null);
            $etudiant->setDescriptionHandicap(null);
        }

        if ($etudiant->getOrphelin() == 'Non') {
            $etudiant->setTypeOrphelin(null);
        }
        if ($oldEmail != $etudiant->getEmail()) {
            $etudiant->setEmailPersoUpdated(true);
        }

        $em->flush();

        return $etudiant;
    }

    /**
     * @Rest\Put(path="/update-infos/", name="etudiant_auto_update")
     * @Rest\View(StatusCode=200)
     */
    public function updateInfosByEtudiant(Request $request): Etudiant {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $oldMail = $etudiant->getEmail();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));

        if ($oldEmail != $etudiant->getEmail()) {
            $etudiant->setEmailPersoUpdated(true);
        }

        $this->getDoctrine()->getManager()->flush();

        return $etudiant;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="etudiant_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_CLONE")
     */
    public function cloner(Request $request, Etudiant $etudiant): Etudiant {
        $em = $this->getDoctrine()->getManager();
        $etudiantNew = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiantNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($etudiantNew);

        $em->flush();

        return $etudiantNew;
    }

    /**
     * @Rest\Delete("/{id}", name="etudiant_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_DELETE")
     */
    public function delete(Etudiant $etudiant): Etudiant {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($etudiant);
        $entityManager->flush();

        return $etudiant;
    }

    /**
     * @Rest\Post("/delete-selection/", name="etudiant_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiants = Utils::getObjectFromRequest($request);
        if (!count($etudiants)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($etudiants as $etudiant) {
            $etudiant = $entityManager->getRepository(Etudiant::class)->find($etudiant->id);
            $entityManager->remove($etudiant);
        }
        $entityManager->flush();

        return $etudiants;
    }

    /**
     * fonction qui permet de recuperer le dernier numero d'inscription academique
     * et le met à 5 chiffres si non existe
     */
    public static function genererNumInterne(\App\Entity\Preinscription $preinscription) {
        $numeroOrdreInscription = $preinscription->getIdanneeacad()->getNbreInscrits();


        $numeroOrdreInscription++;
        switch (strlen('' . $numeroOrdreInscription)) {
            case 1:
                $numeroOrdreInscription = '0000' . $numeroOrdreInscription;
                break;
            case 2:
                $numeroOrdreInscription = '000' . $numeroOrdreInscription;
                break;
            case 3:
                $numeroOrdreInscription = '00' . $numeroOrdreInscription;
                break;
            case 4:
                $numeroOrdreInscription = '0' . $numeroOrdreInscription;
                break;
        }


        $annee = $preinscription->getIdanneeacad()->getCodeanneeacad();
        $numInterne = substr($annee, -2) . '' . $preinscription->getIdfiliere()->getCodenum() . '' . $numeroOrdreInscription;
        return $numInterne;
    }

}
