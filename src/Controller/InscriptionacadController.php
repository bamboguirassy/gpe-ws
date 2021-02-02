<?php

namespace App\Controller;

use App\Entity\Inscriptionacad;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Modaliteenseignement;
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
     * @Rest\Get(path="/en-cours/etudiant/{id}", name="find_inscription_acad_en_cours")
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
     * @Rest\Get(path="/classe/{id}", name="inscriptionacad_by_classe")
     * @Rest\View(StatusCode = 200)
     */
    public function findByClasse(\App\Entity\Classe $classe) {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->getRepository('App\Entity\Inscriptionacad')
                ->findBy(['idclasse' => $classe]);
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Get(path="/inscriptions/{id}/etudiant", name="inscriptionacad_etudiabt")
     * @Rest\View(StatusCode = 200)
     */
    public function getInscriptionEtudiant(Etudiant $etudiant): array {
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

        // if etudiant est beneficiere des services de croust
        if ($inscriptionacad->getIdregimeinscription()->getCoderegimeinscription() == 'RNNP' || $inscriptionacad->getIdregimeinscription()->getCoderegimeinscription() == 'RPNP') {
            $inscriptionacad->setCroust(true);
        }

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

        // if etudiant sénégalais mettre croust à true
        if ($inscriptionacad->getIdetudiant()->getNationalite()->getAlpha2() == 'SN') {
            $inscriptionacad->setCroust(true);
        }

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
     * @Rest\Put(path="/{id}/confirm-prepaid-inscription", name="prepaid_inscription_confirm",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function confirmPrepaidInscription(Inscriptionacad $inscriptionacad, \Swift_Mailer $mailer) {
        $em = $this->getDoctrine()->getManager();
        $preinscriptions = $em->getRepository(Preinscription::class)
                ->findBy([
            'idfiliere' => $inscriptionacad->getIdClasse()->getIdfiliere(),
            'idniveau' => $inscriptionacad->getIdClasse()->getIdniveau(),
            'idanneeacad' => $inscriptionacad->getIdClasse()->getIdanneeacad(),
            'cni' => $inscriptionacad->getIdetudiant()->getCni()
        ]);

        if (count($preinscriptions)) {
            if (count($preinscriptions) > 1) {
                throw $this->createAccessDeniedException("Un problème a été detecté; plusieurs préinscriptions trouvées !!!");
            }
            $preinscriptions[0]->setEstinscrit(true);
            $em->flush();
            $preinscription = $preinscriptions[0];
        } else {
            throw $this->createNotFoundException("La préinscription est introuvable pour termine le processus d'inscription");
        }

        // Envoyer un email de confirmation

        $message = (new \Swift_Message('Confirmation Préinscription'))
                ->setFrom(Utils::$senderEmail)
                ->setTo($preinscription->getEmail())
                ->setBody(
                $this->renderView(
                        'emails/preinscription/confirmation-notification.html.twig', ['preinscription' => $preinscription]
                ), 'text/html'
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

    /**
     * @Rest\Post("/public/pin", name="payment_instant_notification")
     * @Rest\View(StatusCode=200)
     */
    public function paymentInstantNotification(Request $request, \Swift_Mailer $mailer) {
        $em = $this->getDoctrine()->getManager();
        $paymentMode = $request->get('payment_mode');
        $paidSum = $request->get('paid_sum');
        $paidAmount = $request->get('paid_amount');
        $paymentToken = $request->get('payment_token');
        $paymentStatus = $request->get('payment_status');
        $commandNumber = $request->get('command_number');
        $paymentValidationDate = $request->get('payment_validation_date');
        $inscriptionacad = $em->getRepository(Inscriptionacad::class)->find($commandNumber);
        if (!$inscriptionacad) {
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
            throw $this->createNotFoundException("Inscription acad introuvable !!!");
        }
        $informationPaiementInscription = new InformationPaiementInscription();
        $informationPaiementInscription->setNumeroTransaction($paymentToken);
        $informationPaiementInscription->setOperateur($paymentMode);
        $informationPaiementInscription->setMontant($paidAmount);
//        $informationPaiementInscription->setDate((new \DateTime())->setTimestamp($paymentValidationDate));
        $informationPaiementInscription->setDate(new \DateTime());
        $informationPaiementInscription->setInscriptionacad($inscriptionacad);
        if ($paymentStatus == 200) {
            $informationPaiementInscription->setStatus('Confirmé');
            $preinscriptions = $em->getRepository(Preinscription::class)
                    ->findBy([
                'cni' => $inscriptionacad->getIdetudiant()->getCni(),
                'idfiliere' => $inscriptionacad->getIdclasse()->getIdfiliere(),
                'idanneeacad' => $inscriptionacad->getIdclasse()->getIdanneeacad(),
                'idniveau' => $inscriptionacad->getIdclasse()->getIdniveau(),
                'estinscrit' => FALSE]);
            if ($preinscriptions) {
                $preinscriptions[0]->setEstinscrit(TRUE);
            }
            $message = (new \Swift_Message('Confirmation paiement frais inscription administrative - Université de Thiès'))
                    ->setFrom(Utils::$senderEmail, 'SPET GPE')
                    ->setTo($inscriptionacad->getIdetudiant()->getEmailuniv())
                    ->setBcc(Utils::$adminMail)
                    ->setBody(
                    "Bonjour, "
                    . "Le paiement initié pour votre inscription académique est confirmé. A très bientôt !"
                    , 'text/html'
            );
            $mailer->send($message);
        } else if ($paymentStatus == 420) {
            $informationPaiementInscription->setStatus('Annulé');
        } else {
            throw $this->createNotFoundException("Erreur de la transaction");
        }

        $em->persist($informationPaiementInscription);
        $em->flush();

        return $informationPaiementInscription;
    }

}
