<?php

namespace App\Controller;

use App\Entity\Inscriptionacad;
use App\Form\InscriptionacadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/inscriptionacad")
 */
class InscriptionacadController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="inscriptionacad_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_LISTE")
     */
    public function index(): array {
        $inscriptionacads = $this->getDoctrine()
                ->getRepository(Inscriptionacad::class)
                ->findAll();

        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Get(path="/mes-inscriptions/", name="mes_inscriptionacad_index")
     * @Rest\View(StatusCode = 200)
     */
    public function getInscriptionEtudiantConnecte(): array {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacads = $em->getRepository(Inscriptionacad::class)
                ->findBy(['idetudiant'=>EtudiantController::getEtudiantConnecte($this),
                    'etat'=>'V'],['id'=>'DESC']);
        return count($inscriptionacads) ? $inscriptionacads : [];
    }

    /**
     * @Rest\Post(Path="/create", name="inscriptionacad_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_NOUVEAU")
     */
    public function create(Request $request): Inscriptionacad {
        $inscriptionacad = new Inscriptionacad();
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacad);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($inscriptionacad);
        $entityManager->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscriptionacad_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_AFFICHAGE")
     */
    public function show(Inscriptionacad $inscriptionacad): Inscriptionacad {
        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="inscriptionacad_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_EDITION")
     */
    public function edit(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad {
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacad);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="inscriptionacad_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_CLONE")
     */
    public function cloner(Request $request, Inscriptionacad $inscriptionacad): Inscriptionacad {
        $em = $this->getDoctrine()->getManager();
        $inscriptionacadNew = new Inscriptionacad();
        $form = $this->createForm(InscriptionacadType::class, $inscriptionacadNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionacadNew);

        $em->flush();

        return $inscriptionacadNew;
    }

    /**
     * @Rest\Delete("/{id}", name="inscriptionacad_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_DELETE")
     */
    public function delete(Inscriptionacad $inscriptionacad): Inscriptionacad {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($inscriptionacad);
        $entityManager->flush();

        return $inscriptionacad;
    }

    /**
     * @Rest\Post("/delete-selection/", name="inscriptionacad_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONACAD_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $inscriptionacads = Utils::getObjectFromRequest($request);
        if (!count($inscriptionacads)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($inscriptionacads as $inscriptionacad) {
            $inscriptionacad = $entityManager->getRepository(Inscriptionacad::class)->find($inscriptionacad->id);
            $entityManager->remove($inscriptionacad);
        }
        $entityManager->flush();

        return $inscriptionacads;
    }

}
