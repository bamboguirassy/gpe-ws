<?php

namespace App\Controller;

use App\Entity\PaiementFraisEncadrement;
use App\Form\PaiementFraisEncadrementType;
use App\Repository\PaiementFraisEncadrementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/paiement/frais/encadrement")
 */
class PaiementFraisEncadrementController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="paiement_frais_encadrement_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_LISTE")
     */
    public function index(PaiementFraisEncadrementRepository $paiementFraisEncadrementRepository): array
    {
        return $paiementFraisEncadrementRepository->findAll();
    }

    /**
     * @Rest\Post(Path="/create", name="paiement_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_NOUVEAU")
     */
    public function create(Request $request): PaiementFraisEncadrement    {
        $paiementFraisEncadrement = new PaiementFraisEncadrement();
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paiementFraisEncadrement);
        $entityManager->flush();

        return $paiementFraisEncadrement;
    }

    /**
     * @Rest\Get(path="/{id}", name="paiement_frais_encadrement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_AFFICHAGE")
     */
    public function show(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        return $paiementFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="paiement_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_EDITION")
     */
    public function edit(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $paiementFraisEncadrement;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="paiement_frais_encadrement_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_CLONE")
     */
    public function cloner(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement):  PaiementFraisEncadrement {
        $em=$this->getDoctrine()->getManager();
        $paiementFraisEncadrementNew=new PaiementFraisEncadrement();
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($paiementFraisEncadrementNew);

        $em->flush();

        return $paiementFraisEncadrementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="paiement_frais_encadrement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_SUPPRESSION")
     */
    public function delete(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paiementFraisEncadrement);
        $entityManager->flush();

        return $paiementFraisEncadrement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="paiement_frais_encadrement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $paiementFraisEncadrements = Utils::getObjectFromRequest($request);
        if (!count($paiementFraisEncadrements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($paiementFraisEncadrements as $paiementFraisEncadrement) {
            $paiementFraisEncadrement = $entityManager->getRepository(PaiementFraisEncadrement::class)->find($paiementFraisEncadrement->id);
            $entityManager->remove($paiementFraisEncadrement);
        }
        $entityManager->flush();

        return $paiementFraisEncadrements;
    }
}
