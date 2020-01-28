<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Entity\Filiere;
use App\Form\SpecialiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/specialite")
 */
class SpecialiteController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="specialite_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_SPECIALITE_LISTE")
     */
    public function index(): array {
        $specialites = $this->getDoctrine()
                ->getRepository(Specialite::class)
                ->findAll();

        return count($specialites) ? $specialites : [];
    }

    /**
     * @Rest\Get(path="/filiere/{id}", name="specialite_by_filiere_index")
     * @Rest\View(StatusCode = 200)
     */
    public function findByFiliere(Filiere $filiere): array {
        $specialites = $this->getDoctrine()
                ->getRepository(Specialite::class)
                ->findByIdfiliere($filiere);

        return count($specialites) ? $specialites : [];
    }

    /**
     * @Rest\Post(Path="/create", name="specialite_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_NOUVEAU")
     */
    public function create(Request $request): Specialite {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($specialite);
        $entityManager->flush();

        return $specialite;
    }

    /**
     * @Rest\Get(path="/{id}", name="specialite_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_AFFICHAGE")
     */
    public function show(Specialite $specialite): Specialite {
        return $specialite;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="specialite_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_EDITION")
     */
    public function edit(Request $request, Specialite $specialite): Specialite {
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $specialite;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="specialite_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_CLONE")
     */
    public function cloner(Request $request, Specialite $specialite): Specialite {
        $em = $this->getDoctrine()->getManager();
        $specialiteNew = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialiteNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($specialiteNew);

        $em->flush();

        return $specialiteNew;
    }

    /**
     * @Rest\Delete("/{id}", name="specialite_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_DELETE")
     */
    public function delete(Specialite $specialite): Specialite {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($specialite);
        $entityManager->flush();

        return $specialite;
    }

    /**
     * @Rest\Post("/delete-selection/", name="specialite_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_SPECIALITE_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $specialites = Utils::getObjectFromRequest($request);
        if (!count($specialites)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($specialites as $specialite) {
            $specialite = $entityManager->getRepository(Specialite::class)->find($specialite->id);
            $entityManager->remove($specialite);
        }
        $entityManager->flush();

        return $specialites;
    }

}
