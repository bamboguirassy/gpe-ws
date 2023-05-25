<?php

namespace App\Controller;

use App\Entity\Inscriptionacad;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Anneeacad;
use App\Entity\Niveau;
use App\Entity\Filiere;
use App\Entity\Modaliteenseignement;
use App\Entity\PaiementFraisEncadrement;
use App\Entity\Preinscription;
use App\Entity\InformationPaiementInscription;
use App\Form\InscriptionacadType;
use Doctrine\ORM\EntityManagerInterface;
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
class InscriptionacadController extends AbstractController
{

    /**
     * @Rest\Get(path="/", name="inscriptionacad_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTION ACADEMIQUE_LISTE")
     */
    public function index()
    {
        $inscriptionacads = $this->getDoctrine()
            ->getRepository(Inscriptionacad::class)
            ->findAll();

        return $inscriptionacads;
    }

    /**
     * @Rest\Get(path="/en-cours/etudiant/{id}", name="find_inscription_acad_en_cours")
     * @Rest\View(StatusCode = 200)
     */
    public function findEncoursByEtudiant(Etudiant $etudiant, EntityManagerInterface $entityManager)
    {
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
            ->getResult();

        $inscritionacads = $entityManager
            ->createQuery($query)
            ->setParameter('etudiant', $etudiant)
            ->setParameter('lastAnneeEnCours', $lastAnneeEnCours)
            ->setMaxResults(1)
            ->getResult();

        return count($inscritionacads) ? $inscritionacads[0] : NULL;
    }

    /**
     * Uniquement réservé à l'etudiant connecté
     * @Rest\Get(path="/{id}/find", name="inscriptionacad_show_etudiant",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @param Inscriptionacad $inscriptionacad
     * @return Inscriptionacad
     */
    public function find(Inscriptionacad $inscriptionacad): Inscriptionacad
    {
        /** @var Etudiant $connectedEtudiant */
        $connectedEtudiant = EtudiantController::getEtudiantConnecte($this);
        if ($connectedEtudiant->getEmailUniv() == $this->getUser()->getEmail())
            return $inscriptionacad;

        throw $this->createAccessDeniedException("Vous n'avez pas le droit d'accéder à ce contenu.");
    }

    /**
     * @Rest\Get(path="/preinscription/{id}", name="inscriptionacad_by_preinscription")
     * @Rest\View(StatusCode = 200)
     */
    public function findByPreinscription(Preinscription $preinscription)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository(Classe::class)->findOneBy([
            'idniveau' => $preinscription->getIdniveau(),
            'idfiliere' => $preinscription->getIdfiliere(), 'idanneeacad' => $preinscription->getIdanneeacad()
        ]);
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
     * @Rest\Post(path="/inscriptionacad-filiere/", name="inscriptionacad_by_filiere", requirements={"id"="\d+"})
     * @Rest\View(StatusCode = 200, serializerEnableMaxDepthChecks=true)
     * @IsGranted("ROLE_INSCRIPTION ACADEMIQUE_LISTE")
     */
    public function findByFiliere(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $redData = Utils::serializeRequestContent($request);
        $idanneAcad = $redData['idanneAcad'];
        $idfiliere = $redData['idfiliere'];
        $idniveau = $redData['idniveau'];


        $anneAcad = $em->getRepository(Anneeacad::class)->find($idanneAcad);
        $niveau = $em->getRepository(Niveau::class)->find($idniveau);
        //throw $this->createNotFoundException($niveau->getId());

        //reccuperation classe
        $classes = $em->getRepository(Classe::class)
            ->findBy(array('idfiliere' => $idfiliere, 'idniveau' => $niveau, 'idanneeacad' => $anneAcad));

        //reccuperation classe
        $inscriptionacads = null;
        //test si classe exist
        if (count($classes) > 0) {

            //reccuperer preinscription classe
            $inscriptionacads = $em->createQuery("select ia from "
                . "\App\Entity\Inscriptionacad ia where ia.idclasse in (?1)")
                ->setParameter(1, $classes)
                ->getResult();
            //formatter date
            //            foreach ($inscriptionacads as $inscriptionacad) {
            //                $inscriptionacad->setDateinscacad(AppManager::formatDateTime($inscriptionacad->getDateinscacad()));
            //            }
        }
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Get(path="/classe/{id}", name="inscriptionacad_by_classe")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTION ACADEMIQUE_LISTE")
     */
    public function findByClasse(\App\Entity\Classe $classe)
    {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->getRepository('App\Entity\Inscriptionacad')
            ->findBy(['idclasse' => $classe]);
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * Récuperer la liste des inscriptionacads validée par classe avec 
     * seulement quelques champs
     * @Rest\Get(path="/classe/{id}/validated-simple", name="inscriptionacad_validated_by_classe_simple", requirements={"id"="\d+"})
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTION ACADEMIQUE_LISTE")
     */
    public function findValidatedByClasseSimple(\App\Entity\Classe $classe)
    {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->createQuery('select ia.id as inscription_id,et.prenometudiant as prenom,
         et.nometudiant as nom, 
         et.lieunaiss as lieu_naissance,
         et.teletudiant as telephone, et.email, et.cni as cni_or_passport,et.numinterne as numero_carte_etudiant,  et.genre as sexe,
          ia.typeRegimePaiement as type_regime_paiement, nat.nationalite   '
            . 'from App\Entity\Inscriptionacad ia join ia.idetudiant et
             join et.nationalite nat where ia.idclasse=?1 and ia.etat=?2')
            ->setParameter(1, $classe)
            ->setParameter(2, "V")
            ->getResult();
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Get(path="/inscriptions/{id}/etudiant", name="inscriptionacad_etudiant")
     * @Rest\View(StatusCode = 200)
     */
    public function getInscriptionEtudiant(Etudiant $etudiant): array
    {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->createQuery('select ia from App\Entity\Inscriptionacad ia, '
            . 'App\Entity\Classe c, App\Entity\Anneeacad aa where '
            . 'ia.idclasse=c and c.idanneeacad=aa and ia.idetudiant=?1 '
            . 'order by aa.id DESC')
            ->setParameter(1, $etudiant)
            ->getResult();
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Get(path="/inscriptions-payant/{id}/etudiant", name="inscriptionacad_etudiant_payant")
     * @Rest\View(StatusCode = 200)
     */
    public function getInscriptionPayantEtudiant(Etudiant $etudiant, EntityManagerInterface $entityManager): array
    {
        $inscriptionacads = $entityManager->createQuery('
            SELECT ia
            FROM App\Entity\Inscriptionacad ia
            JOIN ia.idetudiant et
            JOIN ia.idregimeinscription r
            WHERE et = :etudiant
                AND r.coderegimeinscription IN (:regimes)
        ')->setParameters([
            'etudiant' => $etudiant,
            'regimes' => ['RNP', 'RPP']
        ])->getResult();
        $result = [];
        foreach ($inscriptionacads as $inscriptionacad) {
            $bindedPaiementFraisEncadrements = $entityManager
                ->getRepository(PaiementFraisEncadrement::class)
                ->findByInscriptionacad($inscriptionacad);

            $result[] = [
                'inscriptionacad' => $inscriptionacad,
                'paiementFraisEncadrements' => $bindedPaiementFraisEncadrements
            ];
        }

        return $result;
    }

    /**
     * @Rest\Post(Path="/create", name="inscriptionacad_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): Inscriptionacad
    {
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
            ->findOneBy([
                'idfiliere' => $preinscription->getIdfiliere(),
                'idniveau' => $preinscription->getidniveau(),
                'idanneeacad' => $preinscription->getIdanneeacad()
            ]);
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
            //find moyen paiement Campusen
            $modepaiement = $entityManager->getRepository("App\Entity\Modepaiement")
                ->findOneByCodemodepaiement("CAMPUSEN");
            if (!$modepaiement) {
                throw $this->createNotFoundException("Mode de paiement Campusen introuvable...");
            }
            $inscriptionacad->setIdmodepaiement($modepaiement);
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

        // if etudiant sénégalais mettre croust à true
        if ($inscriptionacad->getIdetudiant()->getNationalite()->getAlpha2() == 'SN') {
            $inscriptionacad->setCroust(true);
        }

        $entityManager->persist($inscriptionacad);
        $entityManager->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscriptionacad_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTION ACADEMIQUE_AFFICHAGE")
     */
    public function show(Inscriptionacad $inscriptionacad): Inscriptionacad
    {
        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="inscriptionacad_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad
    {
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacad);
        $form->submit(Utils::serializeRequestContent($request));

        // if etudiant sénégalais mettre croust à true
        /* if ($inscriptionacad->getIdetudiant()->getNationalite()->getAlpha2() == 'SN') {
          $inscriptionacad->setCroust(true);
          } */

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="inscriptionacad_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_CLONE")
     */
    public function cloner(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad
    {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacadNew = new Inscriptionacad();
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacadNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionacadNew);

        $em->flush();

        return $inscriptionacadNew;
    }

    /**
     * @Rest\Put(path="/{id}/confirm-prepaid-inscription", name="prepaid_inscription_confirm",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function confirmPrepaidInscription(\App\Entity\InscriptionTemporaire $inscriptionTemporaire, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $preinscriptions = $em->getRepository(Preinscription::class)
            ->findBy([
                'idfiliere' => $inscriptionTemporaire->getIdclasse()->getIdfiliere(),
                'idniveau' => $inscriptionTemporaire->getIdClasse()->getIdniveau(),
                'idanneeacad' => $inscriptionTemporaire->getIdClasse()->getIdanneeacad(),
                'cni' => $inscriptionTemporaire->getIdetudiant()->getCni()
            ]);

        if (count($preinscriptions)) {
            if (count($preinscriptions) > 1) {
                throw $this->createAccessDeniedException("Un problème a été detecté; plusieurs préinscriptions trouvées !!!");
            }
            $preinscriptions[0]->setEstinscrit(true);
            $inscriptionacad = $this->createInscriptionAcadFromTemp($inscriptionTemporaire);
            $em->persist($inscriptionacad);
            $em->remove($inscriptionTemporaire);
            $em->flush();
            $filiere = $inscriptionacad->getIdclasse()->getIdfiliere();
            if ($filiere->getIdentite()) {
                $departement = $filiere->getIdentite();
                if ($filiere->getIdentite()->getIdentiteparent()) {
                    $etablissement = $filiere->getIdentite()->getIdentiteparent();
                } else {
                    $etablissement = $filiere->getIdentite();
                }
            }
            $optionLabel = '';
            if ($inscriptionacad->getIdspecialite()) {
                if ($inscriptionacad->getIdspecialite()->getCodespecialite() != 'TC') {
                    $optionLabel = $inscriptionacad->getIdspecialite()->getLibellespecialite();
                } else {
                    $optionLabel = 'Néant';
                }
            }
            if ($inscriptionacad->getPassage() == 'P') {
                $passage = "Passant";
            } else if ($inscriptionacad->getPassage() == 'C') {
                $passage = "Conditionnel";
            } else {
                $passage = "Redoublant";
            }
            $message = (new \Swift_Message("[Notif inscription] -"
                . " Inscription en {$inscriptionacad->getIdclasse()->getCodeclasse()}"))
                ->setFrom(Utils::$senderEmail, 'SPET GPE')
                ->setTo($inscriptionacad->getIdetudiant()->getEmailuniv())
                ->setBcc('dsos@univ-thies.sn')
                ->setBody(
                    "Bonjour <strong>{$inscriptionacad->getIdetudiant()->getPrenometudiant()} {$inscriptionacad->getIdetudiant()->getNometudiant()}</strong>. <br> "
                        . "Vous venez d'effectuer votre inscription en  <strong>{$inscriptionacad->getIdclasse()->getLibelleclasse()}</strong> pour l'année universitaire <strong>{$inscriptionacad->getIdclasse()->getIdanneeacad()->getLibelleanneeacad()}</strong>. <br>
                    Etablissement: <strong>{$etablissement->getLibelleentite()}</strong><br>
                    Département: <strong>{$departement->getLibelleentite()}</strong><br>
                    Filiere: <strong>{$filiere->getLibellefiliere()}</strong><br>
                    Option: <strong>{$optionLabel}</strong><br>
                    Année universitaire: <strong>{$inscriptionacad->getIdclasse()->getIdanneeacad()->getLibelleanneeacad()}</strong><br>
                    Niveau: <strong>{$inscriptionacad->getIdclasse()->getIdniveau()->getLibelleniveau()}</strong><br>
                    Situation passage: <strong>{$passage}</strong><br>
                    Date de paiement: Aucune<br>
                    Montant: Prépayé<br>
                    Numéro Transaction: <strong>{$inscriptionacad->getNumquittance()}</strong><br>
                    <br><br>
                    <u>Informations personnelles :</u> <br>
                    <strong>{$inscriptionacad->getIdetudiant()->getPrenometudiant()} {$inscriptionacad->getIdetudiant()->getNometudiant()}</strong> <br>
                    Né(e) le <strong>{$inscriptionacad->getIdetudiant()->getDatenaiss()->format('d/m/Y')}</strong> à <strong>{$inscriptionacad->getIdetudiant()->getLieunaiss()}</strong> <br>
                    Nationalité: <strong>{$inscriptionacad->getIdetudiant()->getNationalite()->getNationalite()}</strong><br>
                    INE: <strong>{$inscriptionacad->getIdetudiant()->getIne()}</strong><br>
                    Numéro CNI/Passport: <strong>{$inscriptionacad->getIdetudiant()->getCni()}</strong><br><br>
                    Votre inscription est bien enregistrée. <br>
                    Si il y'a des informations incorrectes que vous pouvez corriger, nous vous demandons de les corriger. <br>
                    Si il y'a des informations erronées que vous n'êtes pas habilitées à corriger, veuillez contacter la DSOS (dsos@univ-thies.sn) pour demander la rectification. <br>
                    <br><br>
                    Dans votre dossier étudiant, vous devez charger dans la partie documents, les documents qui sont exigés pour que votre inscription soit validée. 
                    <br><br>
                    Bien cordialement.",
                    'text/html'
                );
            $mailer->send($message);
            $preinscription = $preinscriptions[0];
        } else {
            throw $this->createNotFoundException("La préinscription est introuvable pour terminer le processus d'inscription");
        }

        // Envoyer un email de confirmation

        $message = (new \Swift_Message('Confirmation Préinscription'))
            ->setFrom(Utils::$senderEmail)
            ->setTo($preinscription->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/preinscription/confirmation-notification.html.twig',
                    ['preinscription' => $preinscription]
                ),
                'text/html'
            );
        $i = 0;
        $isMailSent = $mailer->send($message);
        while (!$isMailSent) {
            $isMailSent = $mailer->send($message);
            $i++;
            if ($i == 5 && !$isMailSent) {
                throw $this->createAccessDeniedException("Impossible d'envoyer le mail de confirmation, des erreurs sont survenue après 5 tentatives au mail " . $preinscription->getEmail());
            }
        }

        return $preinscription;
    }

    /**
     * @Rest\Delete("/{id}", name="inscriptionacad_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_DELETE")
     */
    public function delete(Inscriptionacad $inscriptionacad): Inscriptionacad
    {
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
    public function deleteMultiple(Request $request): array
    {
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

    /**
     * @Rest\Post("/public/pin", name="payment_instant_notification")
     * @Rest\View(StatusCode=200)
     */
    public function paymentInstantNotification(Request $request, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $paymentMode = $request->get('payment_mode');
        $paidSum = $request->get('paid_sum');
        $paidAmount = $request->get('paid_amount');
        $paymentToken = $request->get('payment_token');
        $paymentStatus = $request->get('payment_status');
        $commandNumber = $request->get('command_number');
        $paymentValidationDate = $request->get('payment_validation_date');
        $inscriptionTemporaire = $em->getRepository(\App\Entity\InscriptionTemporaire::class)->find($commandNumber);
        /*if (!$inscriptionTemporaire) {
            $message = (new \Swift_Message('Erreur confirmation paiement - PIN' . $commandNumber))
                    ->setFrom(Utils::$senderEmail, 'SPET GPE')
                    ->setTo(Utils::$adminMail)
                    ->setBody(
                    "Bonjour Admin,"
                    . "Une erreur est survenue lors de la confirmation"
                    . " de paiement de l'inscirption académique numero {$commandNumber},"
                    . "Token de paiement : {$paymentToken} avec le statut {$paymentStatus}"
                    , 'text/html'
            );
            $mailer->send($message);
            return 0;
        }*/

        if ($paymentStatus == 200) {
            // créer inscription acad par inscription temp
            $inscriptionacad = $this->createInscriptionAcadFromTemp($inscriptionTemporaire);
            $em->persist($inscriptionacad);
            // $em->flush();
            /* */
            $informationPaiementInscription = new InformationPaiementInscription();
            $informationPaiementInscription->setNumeroTransaction($paymentToken);
            $informationPaiementInscription->setOperateur($paymentMode);
            $informationPaiementInscription->setMontant($paidAmount);
            $informationPaiementInscription->setDate((new \DateTime())->setTimestamp($paymentValidationDate));
            $informationPaiementInscription->setInscriptionacad($inscriptionacad);
            $inscriptionacad->setNumquittance($paymentToken);
            $informationPaiementInscription->setStatus('Confirmé');
            $preinscriptions = $em->getRepository(Preinscription::class)
                ->findBy([
                    'cni' => $inscriptionacad->getIdetudiant()->getCni(),
                    'idfiliere' => $inscriptionacad->getIdclasse()->getIdfiliere(),
                    'idanneeacad' => $inscriptionacad->getIdclasse()->getIdanneeacad(),
                    'idniveau' => $inscriptionacad->getIdclasse()->getIdniveau(),
                    'estinscrit' => FALSE
                ]);
            if ($preinscriptions) {
                $preinscriptions[0]->setEstinscrit(TRUE);
            }
            // $em->remove($inscriptionTemporaire);
            // find and remove all inscription temps on payment confirm => MF - 31/03/2021
            $inscriptionTemps = $em->getRepository('App\Entity\InscriptionTemporaire')
                ->findBy([
                    'idetudiant' => $inscriptionacad->getIdetudiant(),
                    'idclasse' => $inscriptionacad->getIdclasse()
                ]);
            foreach ($inscriptionTemps as $inscriptionTemp) {
                $em->remove($inscriptionTemp);
            }
            $em->persist($informationPaiementInscription);
            $em->flush();
            $filiere = $inscriptionacad->getIdclasse()->getIdfiliere();
            if ($filiere->getIdentite()) {
                $departement = $filiere->getIdentite();
                if ($filiere->getIdentite()->getIdentiteparent()) {
                    $etablissement = $filiere->getIdentite()->getIdentiteparent();
                } else {
                    $etablissement = $filiere->getIdentite();
                }
            }
            $optionLabel = '';
            if ($inscriptionacad->getIdspecialite()) {
                if ($inscriptionacad->getIdspecialite()->getCodespecialite() != 'TC') {
                    $optionLabel = $inscriptionacad->getIdspecialite()->getLibellespecialite();
                } else {
                    $optionLabel = 'Néant';
                }
            }
            if ($inscriptionacad->getPassage() == 'P') {
                $passage = "Passant";
            } else if ($inscriptionacad->getPassage() == 'C') {
                $passage = "Conditionnel";
            } else {
                $passage = "Redoublant";
            }
            $message = (new \Swift_Message("[Notif inscription] -"
                . " Inscription en {$inscriptionacad->getIdclasse()->getCodeclasse()}"))
                ->setFrom(Utils::$senderEmail, 'SPET GPE')
                ->setTo($inscriptionacad->getIdetudiant()->getEmailuniv())
                ->setBcc('dsos@univ-thies.sn')
                ->setBody(
                    "Bonjour <strong>{$inscriptionacad->getIdetudiant()->getPrenometudiant()} {$inscriptionacad->getIdetudiant()->getNometudiant()}</strong>. <br> "
                        . "Vous venez d'effectuer votre inscription en  <strong>{$inscriptionacad->getIdclasse()->getLibelleclasse()}</strong> pour l'année universitaire <strong>{$inscriptionacad->getIdclasse()->getIdanneeacad()->getLibelleanneeacad()}</strong>. <br>
                    Etablissement: <strong>{$etablissement->getLibelleentite()}</strong><br>
                    Département: <strong>{$departement->getLibelleentite()}</strong><br>
                    Filiere: <strong>{$filiere->getLibellefiliere()}</strong><br>
                    Option: <strong>{$optionLabel}</strong><br>
                    Année universitaire: <strong>{$inscriptionacad->getIdclasse()->getIdanneeacad()->getLibelleanneeacad()}</strong><br>
                    Niveau: <strong>{$inscriptionacad->getIdclasse()->getIdniveau()->getLibelleniveau()}</strong><br>
                    Situation passage: <strong>{$passage}</strong><br>
                    Date de paiement: <strong>{$informationPaiementInscription->getDate()->format('d/m/Y H:i:s')}</strong><br>
                    Montant: <strong>{$inscriptionacad->getMontantinscriptionacad()} FCFA</strong><br>
                    Numéro Transaction: <strong>{$inscriptionacad->getNumquittance()}</strong><br>
                    <br><br>
                    <u>Informations personnelles :</u> <br>
                    <strong>{$inscriptionacad->getIdetudiant()->getPrenometudiant()} {$inscriptionacad->getIdetudiant()->getNometudiant()}</strong> <br>
                    Né(e) le <strong>{$inscriptionacad->getIdetudiant()->getDatenaiss()->format('d/m/Y')}</strong> à <strong>{$inscriptionacad->getIdetudiant()->getLieunaiss()}</strong> <br>
                    Nationalité: <strong>{$inscriptionacad->getIdetudiant()->getNationalite()->getNationalite()}</strong><br>
                    INE: <strong>{$inscriptionacad->getIdetudiant()->getIne()}</strong><br>
                    Numéro CNI/Passport: <strong>{$inscriptionacad->getIdetudiant()->getCni()}</strong><br><br>
                    Votre inscription est bien enregistrée. <br>
                    Si il y'a des informations incorrectes que vous pouvez corriger, nous vous demandons de les corriger. <br>
                    Si il y'a des informations erronées que vous n'êtes pas habilitées à corriger, veuillez contacter la DSOS (dsos@univ-thies.sn) pour demander la rectification. <br>
                    <br><br>
                    Dans votre dossier étudiant, vous devez charger dans la partie documents, les documents qui sont exigés pour que votre inscription soit validée. 
                    <br><br>
                    Bien cordialement.",
                    'text/html'
                );
            $mailer->send($message);
            return 1;
        } else if ($paymentStatus == 420) {
            //  $informationPaiementInscription->setStatus('Annulé');
            /* $message = (new \Swift_Message('Erreur confirmation paiement - PIN' . $commandNumber))
                     ->setFrom(Utils::$senderEmail, 'SPET GPE')
                     ->setTo(Utils::$adminMail)
                     ->setBody(
                     "Bonjour Admin,"
                     . "Une erreur est survenue lors de la confirmation"
                     . " de paiement de l'inscription académique numero {$commandNumber},"
                     . "Token de paiement : {$paymentToken} avec le statut {$paymentStatus}"
                     , 'text/html'
             );
             $mailer->send($message);*/
            return 0;
        } else {
            //  $informationPaiementInscription->setStatus('Annulé');
            /*  $message = (new \Swift_Message('Erreur Transaction - PIN' . $commandNumber))
                      ->setFrom(Utils::$senderEmail, 'SPET GPE')
                      ->setTo(Utils::$adminMail)
                      ->setBody(
                      "Bonjour Admin,"
                      . "Une erreur est survenue lors de la confirmation"
                      . " de paiement de l'inscription académique numero {$commandNumber},"
                      . "Token de paiement : {$paymentToken} avec le statut {$paymentStatus}"
                      , 'text/html'
              );
              $mailer->send($message);*/
            return 0;
        }

        return $informationPaiementInscription;
    }

    public function createInscriptionAcadFromTemp(\App\Entity\InscriptionTemporaire $inscriptionTemporaire)
    {
        $inscriptionacad = new Inscriptionacad();
        $inscriptionacad->setCroust($inscriptionTemporaire->getCroust());
        $inscriptionacad->setDateinscacad(new \DateTime());
        $inscriptionacad->setEtat('I');
        $inscriptionacad->setIdbourse($inscriptionTemporaire->getIdbourse());
        $inscriptionacad->setIdclasse($inscriptionTemporaire->getIdclasse());
        $inscriptionacad->setIdetudiant($inscriptionTemporaire->getIdetudiant());
        $inscriptionacad->setIdfosuser($this->getUser());
        $inscriptionacad->setIdmodaliteenseignement($inscriptionTemporaire->getIdmodaliteenseignement());
        $inscriptionacad->setIdmodepaiement($inscriptionTemporaire->getIdmodepaiement());
        $inscriptionacad->setIdregimeinscription($inscriptionTemporaire->getIdregimeinscription());
        $inscriptionacad->setIdspecialite($inscriptionTemporaire->getIdspecialite());
        $inscriptionacad->setMontantinscriptionacad($inscriptionTemporaire->getMontantinscriptionacad());
        $inscriptionacad->setPassage($inscriptionTemporaire->getPassage());
        $inscriptionacad->setSource($inscriptionTemporaire->getSource());
        return $inscriptionacad;
    }
}
