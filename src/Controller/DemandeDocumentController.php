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
class DemandeDocumentController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="demande_document_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_LISTE")
     */
    public function index(): array {
        $demandeDocuments = $this->getDoctrine()
                ->getRepository(DemandeDocument::class)
                ->findAll(['date'=>'DESC']);

        return count($demandeDocuments) ? $demandeDocuments : [];
    }

    /**
     * @Rest\Get(path="/type/{type}", name="demande_document_index_by_type")
     * @Rest\View(StatusCode = 200)
     */
    public function findByType($type): array {
        if (!in_array($type, ['pedagogique', 'administrative'])) {
            throw $this->createNotFoundException('Type inconnu, doit être pedagogique ou administratif');
        }
        $demandeDocuments = $this->getDoctrine()->getManager()
                ->createQuery('select dd from App\Entity\DemandeDocument dd, '
                        . 'App\Entity\Typedocument td where dd.typedocument=td and '
                        . 'td.source=?1')
                ->setParameter(1, $type)
                ->getResult();

        return count($demandeDocuments) ? $demandeDocuments : [];
    }

    /**
     * @Rest\Get(path="/mes-demandes/", name="demande_document_by_etudiant_connecte")
     * @Rest\View(StatusCode = 200)
     */
    public function findMesDemandes(): array {
        $em = $this->getDoctrine()->getManager();
        $demandeDocuments = $em->createQuery('select dd from App\Entity\DemandeDocument dd, App\Entity\Inscriptionacad ia '
                        . 'where dd.inscriptionacad=ia and ia.idetudiant=?1 ')
                ->setParameter(1, EtudiantController::getEtudiantConnecte($this))
                ->getResult();

        return count($demandeDocuments) ? $demandeDocuments : [];
    }

    /**
     * @Rest\Post(Path="/create", name="demande_document_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): DemandeDocument {
        $entityManager = $this->getDoctrine()->getManager();
        $demandeDocument = new DemandeDocument();
        $form = $this->createForm(DemandeDocumentType::class, $demandeDocument);
        $form->submit(Utils::serializeRequestContent($request));
        $demandeDocument->setDate(new \DateTime());
        $intutile = "Demande de " . $demandeDocument->getTypedocument()->getLibelletypedocument() . " " . $demandeDocument->getInscriptionacad()->getIdclasse()->getCodeclasse();
        $demandeDocument->setIntitule($intutile);
        $demandeDocument->setEtatActuel(EtatDemandeDocumentController::getEtatInitial($this));
        $historique = HistoriqueEtatDemandeController::createHistoriqueFromDemande($demandeDocument, $this);

        $entityManager->persist($demandeDocument);
        $entityManager->persist($historique);

        $entityManager->flush();

        return $demandeDocument;
    }

    /**
     * @Rest\Get(path="/{id}", name="demande_document_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function show(DemandeDocument $demandeDocument): DemandeDocument {
        return $demandeDocument;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="demande_document_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, DemandeDocument $demandeDocument): DemandeDocument {
        $em = $this->getDoctrine()->getManager();
        $oldEtat = $demandeDocument->getEtatActuel();
        $form = $this->createForm(DemandeDocumentType::class, $demandeDocument);
        $form->submit(Utils::serializeRequestContent($request));
        if ($demandeDocument->getEtatActuel()->getCode() != $oldEtat->getCode()) {
            $historique = HistoriqueEtatDemandeController::createHistoriqueFromDemande($demandeDocument, $this);
            $em->persist($historique);
        }

        $em->flush();

        return $demandeDocument;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="demande_document_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_DEMANDEDOCUMENT_CLONE")
     */
    public function cloner(Request $request, DemandeDocument $demandeDocument): DemandeDocument {
        $em = $this->getDoctrine()->getManager();
        $demandeDocumentNew = new DemandeDocument();
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
    public function delete(DemandeDocument $demandeDocument): DemandeDocument {
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
