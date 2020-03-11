<?php

namespace App\Controller;

use App\Entity\Filiereniveau;
use App\Form\FiliereniveauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/filiereniveau")
 */
class FiliereniveauController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="filiereniveau_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FILIERENIVEAU_LISTE")
     */
    public function index(): array
    {
        $filiereniveaus = $this->getDoctrine()
            ->getRepository(Filiereniveau::class)
            ->findAll();

        return count($filiereniveaus)?$filiereniveaus:[];
    }

    /**
     * @Rest\Post(Path="/create", name="filiereniveau_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_NOUVEAU")
     */
    public function create(Request $request): Filiereniveau    {
        $filiereniveau = new Filiereniveau();
        $form = $this->createForm(FiliereniveauType::class, $filiereniveau);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($filiereniveau);
        $entityManager->flush();

        return $filiereniveau;
    }

    /**
     * @Rest\Get(path="/{id}", name="filiereniveau_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_AFFICHAGE")
     */
    public function show(Filiereniveau $filiereniveau): Filiereniveau    {
        return $filiereniveau;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="filiereniveau_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_EDITION")
     */
    public function edit(Request $request, Filiereniveau $filiereniveau): Filiereniveau    {
        $form = $this->createForm(FiliereniveauType::class, $filiereniveau);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $filiereniveau;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="filiereniveau_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_CLONE")
     */
    public function cloner(Request $request, Filiereniveau $filiereniveau):  Filiereniveau {
        $em=$this->getDoctrine()->getManager();
        $filiereniveauNew=new Filiereniveau();
        $form = $this->createForm(FiliereniveauType::class, $filiereniveauNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($filiereniveauNew);

        $em->flush();

        return $filiereniveauNew;
    }

    /**
     * @Rest\Delete("/{id}", name="filiereniveau_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_SUPPRESSION")
     */
    public function delete(Filiereniveau $filiereniveau): Filiereniveau    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($filiereniveau);
        $entityManager->flush();

        return $filiereniveau;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="filiereniveau_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERENIVEAU_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $filiereniveaus = Utils::getObjectFromRequest($request);
        if (!count($filiereniveaus)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($filiereniveaus as $filiereniveau) {
            $filiereniveau = $entityManager->getRepository(Filiereniveau::class)->find($filiereniveau->id);
            $entityManager->remove($filiereniveau);
        }
        $entityManager->flush();

        return $filiereniveaus;
    }
}
