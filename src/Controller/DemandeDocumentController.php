<?php

namespace App\Controller;

use App\Entity\DemandeDocument;
use App\Form\DemandeDocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/demandedocument")
 */
class DemandeDocumentController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="demande_document_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_LISTE")
     */
    public function index(): array
    {
        $demandeDocuments = $this->getDoctrine()
            ->getRepository(DemandeDocument::class)
            ->findAll();

        return count($demandeDocuments)?$demandeDocuments:[];
    }

    /**
     * @Rest\Post(Path="/create", name="demande_document_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_NOUVEAU")
     */
    public function create(Request $request): DemandeDocument    {
        $demandeDocument = new DemandeDocument();
        $form = $this->createForm(DemandeDocumentType::class, $demandeDocument);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($demandeDocument);
        $entityManager->flush();

        return $demandeDocument;
    }

    /**
     * @Rest\Get(path="/{id}", name="demande_document_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_AFFICHAGE")
     */
    public function show(DemandeDocument $demandeDocument): DemandeDocument    {
        return $demandeDocument;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="demande_document_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_EDITION")
     */
    public function edit(Request $request, DemandeDocument $demandeDocument): DemandeDocument    {
        $form = $this->createForm(DemandeDocumentType::class, $demandeDocument);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $demandeDocument;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="demande_document_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_CLONE")
     */
    public function cloner(Request $request, DemandeDocument $demandeDocument):  DemandeDocument {
        $em=$this->getDoctrine()->getManager();
        $demandeDocumentNew=new DemandeDocument();
        $form = $this->createForm(DemandeDocumentType::class, $demandeDocumentNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($demandeDocumentNew);

        $em->flush();

        return $demandeDocumentNew;
    }

    /**
     * @Rest\Delete("/{id}", name="demande_document_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_SUPPRESSION")
     */
    public function delete(DemandeDocument $demandeDocument): DemandeDocument    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($demandeDocument);
        $entityManager->flush();

        return $demandeDocument;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="demande_document_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $demandeDocuments = Utils::getObjectFromRequest($request);
        if (!count($demandeDocuments)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($demandeDocuments as $demandeDocument) {
            $demandeDocument = $entityManager->getRepository(DemandeDocument::class)->find($demandeDocument->id);
            $entityManager->remove($demandeDocument);
        }
        $entityManager->flush();

        return $demandeDocuments;
    }
}
