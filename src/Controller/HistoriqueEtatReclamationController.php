<?php

namespace App\Controller;

use App\Entity\HistoriqueEtatReclamation;
use App\Form\HistoriqueEtatReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/historiqueetatreclamation")
 */
class HistoriqueEtatReclamationController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="historique_etat_reclamation_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_LISTE")
     */
    public function index(): array
    {
        $historiqueEtatReclamations = $this->getDoctrine()
            ->getRepository(HistoriqueEtatReclamation::class)
            ->findAll();

        return count($historiqueEtatReclamations)?$historiqueEtatReclamations:[];
    }

    /**
     * @Rest\Post(Path="/create", name="historique_etat_reclamation_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_NOUVEAU")
     */
    public function create(Request $request): HistoriqueEtatReclamation    {
        $historiqueEtatReclamation = new HistoriqueEtatReclamation();
        $form = $this->createForm(HistoriqueEtatReclamationType::class, $historiqueEtatReclamation);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($historiqueEtatReclamation);
        $entityManager->flush();

        return $historiqueEtatReclamation;
    }

    /**
     * @Rest\Get(path="/{id}", name="historique_etat_reclamation_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_AFFICHAGE")
     */
    public function show(HistoriqueEtatReclamation $historiqueEtatReclamation): HistoriqueEtatReclamation    {
        return $historiqueEtatReclamation;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="historique_etat_reclamation_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_EDITION")
     */
    public function edit(Request $request, HistoriqueEtatReclamation $historiqueEtatReclamation): HistoriqueEtatReclamation    {
        $form = $this->createForm(HistoriqueEtatReclamationType::class, $historiqueEtatReclamation);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $historiqueEtatReclamation;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="historique_etat_reclamation_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_CLONE")
     */
    public function cloner(Request $request, HistoriqueEtatReclamation $historiqueEtatReclamation):  HistoriqueEtatReclamation {
        $em=$this->getDoctrine()->getManager();
        $historiqueEtatReclamationNew=new HistoriqueEtatReclamation();
        $form = $this->createForm(HistoriqueEtatReclamationType::class, $historiqueEtatReclamationNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($historiqueEtatReclamationNew);

        $em->flush();

        return $historiqueEtatReclamationNew;
    }

    /**
     * @Rest\Delete("/{id}", name="historique_etat_reclamation_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_SUPPRESSION")
     */
    public function delete(HistoriqueEtatReclamation $historiqueEtatReclamation): HistoriqueEtatReclamation    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($historiqueEtatReclamation);
        $entityManager->flush();

        return $historiqueEtatReclamation;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="historique_etat_reclamation_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATRECLAMATION_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $historiqueEtatReclamations = Utils::getObjectFromRequest($request);
        if (!count($historiqueEtatReclamations)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($historiqueEtatReclamations as $historiqueEtatReclamation) {
            $historiqueEtatReclamation = $entityManager->getRepository(HistoriqueEtatReclamation::class)->find($historiqueEtatReclamation->id);
            $entityManager->remove($historiqueEtatReclamation);
        }
        $entityManager->flush();

        return $historiqueEtatReclamations;
    }
}
