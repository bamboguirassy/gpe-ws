<?php

namespace App\Controller;

use App\Entity\Modepaiement;
use App\Form\ModepaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/modepaiement")
 */
class ModepaiementController extends AbstractController
{
    /**
     * @Rest\Get(path="/public/", name="modepaiement_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $modepaiements = $this->getDoctrine()
            ->getRepository(Modepaiement::class)
            ->findAll();

        return count($modepaiements)?$modepaiements:[];
    }

    /**
     * @Rest\Post(Path="/create", name="modepaiement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_NOUVEAU")
     */
    public function create(Request $request): Modepaiement    {
        $modepaiement = new Modepaiement();
        $form = $this->createForm(ModepaiementType::class, $modepaiement);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($modepaiement);
        $entityManager->flush();

        return $modepaiement;
    }

    /**
     * @Rest\Get(path="/{id}", name="modepaiement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_AFFICHAGE")
     */
    public function show(Modepaiement $modepaiement): Modepaiement    {
        return $modepaiement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="modepaiement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_EDITION")
     */
    public function edit(Request $request, Modepaiement $modepaiement): Modepaiement    {
        $form = $this->createForm(ModepaiementType::class, $modepaiement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $modepaiement;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="modepaiement_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_CLONE")
     */
    public function cloner(Request $request, Modepaiement $modepaiement):  Modepaiement {
        $em=$this->getDoctrine()->getManager();
        $modepaiementNew=new Modepaiement();
        $form = $this->createForm(ModepaiementType::class, $modepaiementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($modepaiementNew);

        $em->flush();

        return $modepaiementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="modepaiement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_SUPPRESSION")
     */
    public function delete(Modepaiement $modepaiement): Modepaiement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($modepaiement);
        $entityManager->flush();

        return $modepaiement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="modepaiement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_MODEPAIEMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $modepaiements = Utils::getObjectFromRequest($request);
        if (!count($modepaiements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($modepaiements as $modepaiement) {
            $modepaiement = $entityManager->getRepository(Modepaiement::class)->find($modepaiement->id);
            $entityManager->remove($modepaiement);
        }
        $entityManager->flush();

        return $modepaiements;
    }
}
