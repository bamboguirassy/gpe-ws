<?php

namespace App\Controller;

use App\Entity\EtatDemandeDocument;
use App\Form\EtatDemandeDocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/etatdemandedocument")
 */
class EtatDemandeDocumentController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="etat_demande_document_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $etatDemandeDocuments = $this->getDoctrine()
            ->getRepository(EtatDemandeDocument::class)
            ->findAll();

        return count($etatDemandeDocuments)?$etatDemandeDocuments:[];
    }
    
    public static function getEtatInitial($cntrl) {
        $em = $cntrl->getDoctrine()->getManager();
        $etatInitial = $em->getRepository(EtatDemandeDocument::class)
                ->findOneByCode('EEA');
        if(!$etatInitial) {
            throw new Exception("L'état en attente d'approbation est introuvale...");
        }
        return $etatInitial;
    }

    /**
     * @Rest\Post(Path="/create", name="etat_demande_document_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_NOUVEAU")
     */
    public function create(Request $request): EtatDemandeDocument    {
        $etatDemandeDocument = new EtatDemandeDocument();
        $form = $this->createForm(EtatDemandeDocumentType::class, $etatDemandeDocument);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etatDemandeDocument);
        $entityManager->flush();

        return $etatDemandeDocument;
    }

    /**
     * @Rest\Get(path="/{id}", name="etat_demande_document_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_AFFICHAGE")
     */
    public function show(EtatDemandeDocument $etatDemandeDocument): EtatDemandeDocument    {
        return $etatDemandeDocument;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="etat_demande_document_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_EDITION")
     */
    public function edit(Request $request, EtatDemandeDocument $etatDemandeDocument): EtatDemandeDocument    {
        $form = $this->createForm(EtatDemandeDocumentType::class, $etatDemandeDocument);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $etatDemandeDocument;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="etat_demande_document_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_CLONE")
     */
    public function cloner(Request $request, EtatDemandeDocument $etatDemandeDocument):  EtatDemandeDocument {
        $em=$this->getDoctrine()->getManager();
        $etatDemandeDocumentNew=new EtatDemandeDocument();
        $form = $this->createForm(EtatDemandeDocumentType::class, $etatDemandeDocumentNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($etatDemandeDocumentNew);

        $em->flush();

        return $etatDemandeDocumentNew;
    }

    /**
     * @Rest\Delete("/{id}", name="etat_demande_document_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_SUPPRESSION")
     */
    public function delete(EtatDemandeDocument $etatDemandeDocument): EtatDemandeDocument    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($etatDemandeDocument);
        $entityManager->flush();

        return $etatDemandeDocument;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="etat_demande_document_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATDEMANDEDOCUMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $etatDemandeDocuments = Utils::getObjectFromRequest($request);
        if (!count($etatDemandeDocuments)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($etatDemandeDocuments as $etatDemandeDocument) {
            $etatDemandeDocument = $entityManager->getRepository(EtatDemandeDocument::class)->find($etatDemandeDocument->id);
            $entityManager->remove($etatDemandeDocument);
        }
        $entityManager->flush();

        return $etatDemandeDocuments;
    }
}
