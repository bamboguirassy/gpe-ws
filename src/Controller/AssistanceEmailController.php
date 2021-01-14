<?php

namespace App\Controller;

use App\Entity\AssistanceEmail;
use App\Form\AssistanceEmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/assistanceemail")
 */
class AssistanceEmailController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="assistance_email_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_LISTE")
     */
    public function index(): array
    {
        $assistanceEmails = $this->getDoctrine()
            ->getRepository(AssistanceEmail::class)
            ->findAll();

        return count($assistanceEmails)?$assistanceEmails:[];
    }
    
    /**
     * @Rest\Get(path="/per-app/{appName}", name="assistance_email_per_app")
     * @Rest\View(StatusCode = 200)
     */
    public function findAssistanceByAppName($appName): array
    {
        $assistanceEmails = $this->getDoctrine()
            ->getRepository(AssistanceEmail::class)
            ->findBy(['etat'=>1, 'destinationApp'=>$appName]);

        return count($assistanceEmails)?$assistanceEmails:[];
    }
    
    /**
     * @Rest\Post(path="/send-mail/", name="assistance_email_send")
     * @Rest\View(StatusCode = 200)
     */
    public function sendMail(Request $request, \Swift_Mailer $mailer): bool
    {
        $em = $this->getDoctrine()->getManager();
        $reqData = json_decode($request->getContent());
        if(!$reqData->typeAssistance) {
            throw $this->createNotFoundException("le champ typeAssistance est obligatoire");
        }
        $typeAssistanceId = $reqData->typeAssistance;
        $typeAssistance = $em->getRepository(AssistanceEmail::class)
                ->find($typeAssistanceId);
        if(!$typeAssistance) {
            throw $this->createNotFoundException("Le type assistance indiqué est introuvale, assurez vous de passer l'id en parametre");
        }
        if(!$reqData->message) {
            throw $this->createNotFoundException("le champ message est obligatoire");
        }
        $messageContent = $reqData->message;
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $fullMail = $messageContent."<br><br>"
                . "De: ".$etudiant->getPrenometudiant()." ".$etudiant->getNometudiant()."<br>"
                ."Numero de dossier: ".$etudiant->getNuminterne().'<br>'
                ."Mail instutitionnel: ".$etudiant->getEmailUniv();
        $message = (new \Swift_Message($typeAssistance->getTypeAssistance()))
                ->setFrom($this->getUser()->getEmail())
                ->setTo($typeAssistance->getEmail())
                ->setReplyTo($this->getUser()->getEmail())
                ->setBody(
                        $fullMail
                , 'text/html'
        );
        $isMailSent = $mailer->send($message);
        return $isMailSent;
    }

    /**
     * @Rest\Post(Path="/create", name="assistance_email_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_NOUVEAU")
     */
    public function create(Request $request): AssistanceEmail    {
        $assistanceEmail = new AssistanceEmail();
        $form = $this->createForm(AssistanceEmailType::class, $assistanceEmail);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($assistanceEmail);
        $entityManager->flush();

        return $assistanceEmail;
    }

    /**
     * @Rest\Get(path="/{id}", name="assistance_email_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_AFFICHAGE")
     */
    public function show(AssistanceEmail $assistanceEmail): AssistanceEmail    {
        return $assistanceEmail;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="assistance_email_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_EDITION")
     */
    public function edit(Request $request, AssistanceEmail $assistanceEmail): AssistanceEmail    {
        $form = $this->createForm(AssistanceEmailType::class, $assistanceEmail);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $assistanceEmail;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="assistance_email_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_CLONE")
     */
    public function cloner(Request $request, AssistanceEmail $assistanceEmail):  AssistanceEmail {
        $em=$this->getDoctrine()->getManager();
        $assistanceEmailNew=new AssistanceEmail();
        $form = $this->createForm(AssistanceEmailType::class, $assistanceEmailNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($assistanceEmailNew);

        $em->flush();

        return $assistanceEmailNew;
    }

    /**
     * @Rest\Delete("/{id}", name="assistance_email_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_SUPPRESSION")
     */
    public function delete(AssistanceEmail $assistanceEmail): AssistanceEmail    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($assistanceEmail);
        $entityManager->flush();

        return $assistanceEmail;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="assistance_email_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ASSISTANCEEMAIL_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $assistanceEmails = Utils::getObjectFromRequest($request);
        if (!count($assistanceEmails)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($assistanceEmails as $assistanceEmail) {
            $assistanceEmail = $entityManager->getRepository(AssistanceEmail::class)->find($assistanceEmail->id);
            $entityManager->remove($assistanceEmail);
        }
        $entityManager->flush();

        return $assistanceEmails;
    }
}
