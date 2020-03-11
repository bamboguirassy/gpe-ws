<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/niveau")
 */
class NiveauController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="niveau_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_NIVEAU_LISTE")
     */
    public function index(): array
    {
        $niveaux = $this->getDoctrine()
            ->getRepository(Niveau::class)
            ->findAll();

        return count($niveaux)?$niveaux:[];
    }

    /**
     * @Rest\Post(Path="/create", name="niveau_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_NOUVEAU")
     */
    public function create(Request $request): Niveau    {
        $niveau = new Niveau();
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($niveau);
        $entityManager->flush();

        return $niveau;
    }

    /**
     * @Rest\Get(path="/{id}", name="niveau_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_AFFICHAGE")
     */
    public function show(Niveau $niveau): Niveau    {
        return $niveau;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="niveau_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_EDITION")
     */
    public function edit(Request $request, Niveau $niveau): Niveau    {
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $niveau;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="niveau_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_CLONE")
     */
    public function cloner(Request $request, Niveau $niveau):  Niveau {
        $em=$this->getDoctrine()->getManager();
        $niveauNew=new Niveau();
        $form = $this->createForm(NiveauType::class, $niveauNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($niveauNew);

        $em->flush();

        return $niveauNew;
    }

    /**
     * @Rest\Delete("/{id}", name="niveau_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_SUPPRESSION")
     */
    public function delete(Niveau $niveau): Niveau    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($niveau);
        $entityManager->flush();

        return $niveau;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="niveau_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_NIVEAU_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $niveaux = Utils::getObjectFromRequest($request);
        if (!count($niveaux)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($niveaux as $niveau) {
            $niveau = $entityManager->getRepository(Niveau::class)->find($niveau->id);
            $entityManager->remove($niveau);
        }
        $entityManager->flush();

        return $niveaux;
    }
}
