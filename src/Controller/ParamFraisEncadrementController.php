<?php

namespace App\Controller;

use App\Entity\ParamFraisEncadrement;
use App\Form\ParamFraisEncadrementType;
use App\Repository\ParamFraisEncadrementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/param/frais/encadrement")
 */
class ParamFraisEncadrementController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="param_frais_encadrement_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_LISTE")
     */
    public function index(ParamFraisEncadrementRepository $paramFraisEncadrementRepository): array
    {
        return $paramFraisEncadrementRepository->findAll();
    }

    /**
     * @Rest\Post(Path="/create", name="param_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_NOUVEAU")
     */
    public function create(Request $request): ParamFraisEncadrement    {
        $paramFraisEncadrement = new ParamFraisEncadrement();
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paramFraisEncadrement);
        $entityManager->flush();

        return $paramFraisEncadrement;
    }

    /**
     * @Rest\Get(path="/{id}", name="param_frais_encadrement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_AFFICHAGE")
     */
    public function show(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        return $paramFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="param_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_EDITION")
     */
    public function edit(Request $request, ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $paramFraisEncadrement;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="param_frais_encadrement_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_CLONE")
     */
    public function cloner(Request $request, ParamFraisEncadrement $paramFraisEncadrement):  ParamFraisEncadrement {
        $em=$this->getDoctrine()->getManager();
        $paramFraisEncadrementNew=new ParamFraisEncadrement();
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($paramFraisEncadrementNew);

        $em->flush();

        return $paramFraisEncadrementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="param_frais_encadrement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_SUPPRESSION")
     */
    public function delete(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paramFraisEncadrement);
        $entityManager->flush();

        return $paramFraisEncadrement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="param_frais_encadrement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $paramFraisEncadrements = Utils::getObjectFromRequest($request);
        if (!count($paramFraisEncadrements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($paramFraisEncadrements as $paramFraisEncadrement) {
            $paramFraisEncadrement = $entityManager->getRepository(ParamFraisEncadrement::class)->find($paramFraisEncadrement->id);
            $entityManager->remove($paramFraisEncadrement);
        }
        $entityManager->flush();

        return $paramFraisEncadrements;
    }
}
