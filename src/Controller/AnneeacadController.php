<?php

namespace App\Controller;

use App\Entity\Anneeacad;
use App\Form\AnneeacadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/anneeacad")
 */
class AnneeacadController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="anneeacad_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ANNEEACAD_LISTE")
     */
    public function index(): array
    {
        $anneeacads = $this->getDoctrine()
            ->getRepository(Anneeacad::class)
            ->findAll();

        return count($anneeacads)?$anneeacads:[];
    }

    /**
     * @Rest\Post(Path="/create", name="anneeacad_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_NOUVEAU")
     */
    public function create(Request $request): Anneeacad {
        $anneeacad = new Anneeacad();
        $form = $this->createForm(AnneeacadType::class, $anneeacad);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($anneeacad);
        $entityManager->flush();

        return $anneeacad;
    }

    /**
     * @Rest\Get(path="/{id}", name="anneeacad_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_AFFICHAGE")
     */
    public function show(Anneeacad $anneeacad): Anneeacad {
        return $anneeacad;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="anneeacad_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_EDITION")
     */
    public function edit(Request $request, Anneeacad $anneeacad): Anneeacad    {
        $form = $this->createForm(AnneeacadType::class, $anneeacad);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $anneeacad;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="anneeacad_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_CLONE")
     */
    public function cloner(Request $request, Anneeacad $anneeacad):  Anneeacad {
        $em=$this->getDoctrine()->getManager();
        $anneeacadNew=new Anneeacad();
        $form = $this->createForm(AnneeacadType::class, $anneeacadNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($anneeacadNew);

        $em->flush();

        return $anneeacadNew;
    }

    /**
     * @Rest\Delete("/{id}", name="anneeacad_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_SUPPRESSION")
     */
    public function delete(Anneeacad $anneeacad): Anneeacad    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($anneeacad);
        $entityManager->flush();

        return $anneeacad;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="anneeacad_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ANNEEACAD_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $anneeacads = Utils::getObjectFromRequest($request);
        if (!count($anneeacads)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($anneeacads as $anneeacad) {
            $anneeacad = $entityManager->getRepository(Anneeacad::class)->find($anneeacad->id);
            $entityManager->remove($anneeacad);
        }
        $entityManager->flush();

        return $anneeacads;
    }
}
