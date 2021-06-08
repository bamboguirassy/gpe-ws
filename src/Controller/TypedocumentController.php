<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\FosUser;
use App\Entity\Typedocument;
use App\Form\TypedocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/typedocument")
 */
class TypedocumentController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="typedocument_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $typedocuments = $this->getDoctrine()
            ->getRepository(Typedocument::class)
            ->findAll();

        return count($typedocuments) ? $typedocuments : [];
    }

    /**
     * @Rest\Get(path="/send-query-mail/{id}/etudiant/{etudiantId}", name="typedocument_send_query_mail")
     * @Rest\View(StatusCode = 200)
     */
    public function sendMailForQuery(Request $request, Typedocument $typedocument, \Swift_Mailer $mailer, $etudiantId)
    {
        /** @var Etudiant $etudiant */
        $etudiant =
            $this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->find($etudiantId);

        $message = (new \Swift_Message('DSOS: Demande de document obligatoire'))
            ->setFrom(\App\Utils\Utils::$senderEmail)
            ->setTo($etudiant->getEmailUniv())
            ->setBody(
                $this->renderView(
                    'emails/document/query-document.html.twig', [
                        'typeDocument' => $typedocument,
                        'etudiant' => $etudiant
                    ]
                ), 'text/html'
            );
        $mailer->send($message);

        return $etudiant;
    }

    /**
     * @Rest\Post(path="/send-custom/etudiant/{id}", name="typedocument_send_query_mail_custom")
     * @Rest\View(StatusCode = 200)
     */
    public function sendCustomMail(Request $request, Etudiant $etudiant, \Swift_Mailer $mailer)
    {
        $requestData = Utils::getObjectFromRequest($request);
        $documentTitle = $requestData->title;

        $message = (new \Swift_Message('DSOS: Demande de document obligatoire'))
            ->setFrom(\App\Utils\Utils::$senderEmail)
            ->setTo($etudiant->getEmailUniv())
            ->setBody(
                $this->renderView(
                    'emails/document/query-document.html.twig', [
                        'typeDocument' => null,
                        'documentTitle' => $documentTitle,
                        'etudiant' => $etudiant
                    ]
                ), 'text/html'
            );
        $mailer->send($message);

        return $etudiant;
    }

    /**
     * @return array
     * @Rest\Get(path="/input-documents", name="input_document_type")
     * @Rest\View(statusCode = 200)
     */
    public function findInputDocuments(): array
    {
        return $this->getDoctrine()
            ->getRepository(Typedocument::class)
            ->findBy(
                ['type' => 'input'],
                ['libelletypedocument' => 'ASC']
            );
    }
    
     /**
     * @Rest\Get(path="/inscruptionacad-en-cours-by-etudiant/{id}", name="inscruptionacad_en_cours_by_etudiant")
     * @Rest\View(statusCode = 200)
     */
     public function findInscriptionacadEnCoursByEtudiant(Etudiant $etudiant) {
         $em = $this->getDoctrine()->getManager();
         $lastAnneeEnCours = $em->createQuery('SELECT a
            FROM App\Entity\Anneeacad a
            WHERE a.encours = :enCours
            ORDER BY a.id DESC')
                ->setParameter('enCours', true)
                ->setMaxResults(1)
                ->getSingleResult();
               
        $inscriptionacad = $em->createQuery('SELECT insac
            FROM App\Entity\Inscriptionacad insac 
                JOIN insac.idclasse classe
                JOIN classe.idanneeacad anneeacad
            WHERE insac.idetudiant = :etudiant
                    AND anneeacad = :lastAnneeEnCours')
                ->setParameter('etudiant', $etudiant)
                ->setParameter('lastAnneeEnCours', $lastAnneeEnCours)
                ->setMaxResults(1)
                ->getSingleResult();
        
        return $inscriptionacad ? $inscriptionacad : [];
         
    }

    /**
     * @Rest\Post(Path="/create", name="typedocument_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_NOUVEAU")
     */
    public function create(Request $request): Typedocument
    {
        $typedocument = new Typedocument();
        $form = $this->createForm(TypedocumentType::class, $typedocument);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typedocument);
        $entityManager->flush();

        return $typedocument;
    }

    /**
     * @Rest\Get(path="/{id}", name="typedocument_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_AFFICHAGE")
     */
    public function show(Typedocument $typedocument): Typedocument
    {
        return $typedocument;
    }


    /**
     * @Rest\Put(path="/{id}/edit", name="typedocument_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_EDITION")
     */
    public function edit(Request $request, Typedocument $typedocument): Typedocument
    {
        $form = $this->createForm(TypedocumentType::class, $typedocument);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $typedocument;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="typedocument_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_CLONE")
     */
    public function cloner(Request $request, Typedocument $typedocument): Typedocument
    {
        $em = $this->getDoctrine()->getManager();
        $typedocumentNew = new Typedocument();
        $form = $this->createForm(TypedocumentType::class, $typedocumentNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($typedocumentNew);

        $em->flush();

        return $typedocumentNew;
    }

    /**
     * @Rest\Delete("/{id}", name="typedocument_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_SUPPRESSION")
     */
    public function delete(Typedocument $typedocument): Typedocument
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($typedocument);
        $entityManager->flush();

        return $typedocument;
    }



    /**
     * @Rest\Post("/delete-selection/", name="typedocument_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_TYPEDOCUMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $typedocuments = Utils::getObjectFromRequest($request);
        if (!count($typedocuments)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($typedocuments as $typedocument) {
            $typedocument = $entityManager->getRepository(Typedocument::class)->find($typedocument->id);
            $entityManager->remove($typedocument);
        }
        $entityManager->flush();

        return $typedocuments;
    }
}
