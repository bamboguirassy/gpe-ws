<?php

namespace App\Controller;

use App\Entity\EtatReclamationBourse;
use App\Form\EtatReclamationBourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/etatreclamationbourse")
 */
class EtatReclamationBourseController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="etat_reclamation_bourse_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $etatReclamationBourses = $this->getDoctrine()
            ->getRepository(EtatReclamationBourse::class)
            ->findAll();

        return count($etatReclamationBourses)?$etatReclamationBourses:[];
    }
    
    public static function getEtatInitial($cntrl) {
        $em = $cntrl->getDoctrine()->getManager();
        $etatInitial = $em->getRepository(EtatReclamationBourse::class)
                ->findOneByCode('INITIEE');
        if(!$etatInitial) {
            throw new Exception("L'état initié est introuvale...");
        }
        return $etatInitial;
    }

    /**
     * @Rest\Post(Path="/create", name="etat_reclamation_bourse_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_NOUVEAU")
     */
    public function create(Request $request): EtatReclamationBourse    {
        $etatReclamationBourse = new EtatReclamationBourse();
        $form = $this->createForm(EtatReclamationBourseType::class, $etatReclamationBourse);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etatReclamationBourse);
        $entityManager->flush();

        return $etatReclamationBourse;
    }

    /**
     * @Rest\Get(path="/{id}", name="etat_reclamation_bourse_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_AFFICHAGE")
     */
    public function show(EtatReclamationBourse $etatReclamationBourse): EtatReclamationBourse    {
        return $etatReclamationBourse;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="etat_reclamation_bourse_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_EDITION")
     */
    public function edit(Request $request, EtatReclamationBourse $etatReclamationBourse): EtatReclamationBourse    {
        $form = $this->createForm(EtatReclamationBourseType::class, $etatReclamationBourse);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $etatReclamationBourse;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="etat_reclamation_bourse_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_CLONE")
     */
    public function cloner(Request $request, EtatReclamationBourse $etatReclamationBourse):  EtatReclamationBourse {
        $em=$this->getDoctrine()->getManager();
        $etatReclamationBourseNew=new EtatReclamationBourse();
        $form = $this->createForm(EtatReclamationBourseType::class, $etatReclamationBourseNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($etatReclamationBourseNew);

        $em->flush();

        return $etatReclamationBourseNew;
    }

    /**
     * @Rest\Delete("/{id}", name="etat_reclamation_bourse_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_SUPPRESSION")
     */
    public function delete(EtatReclamationBourse $etatReclamationBourse): EtatReclamationBourse    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($etatReclamationBourse);
        $entityManager->flush();

        return $etatReclamationBourse;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="etat_reclamation_bourse_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETATRECLAMATIONBOURSE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $etatReclamationBourses = Utils::getObjectFromRequest($request);
        if (!count($etatReclamationBourses)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($etatReclamationBourses as $etatReclamationBourse) {
            $etatReclamationBourse = $entityManager->getRepository(EtatReclamationBourse::class)->find($etatReclamationBourse->id);
            $entityManager->remove($etatReclamationBourse);
        }
        $entityManager->flush();

        return $etatReclamationBourses;
    }
}
