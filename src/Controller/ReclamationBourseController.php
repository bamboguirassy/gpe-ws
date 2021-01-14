<?php

namespace App\Controller;

use App\Entity\ReclamationBourse;
use App\Form\ReclamationBourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/reclamationbourse")
 */
class ReclamationBourseController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="reclamation_bourse_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $reclamationBourses = $this->getDoctrine()
            ->getRepository(ReclamationBourse::class)
            ->findAll(['date'=>'DESC']);

        return count($reclamationBourses)?$reclamationBourses:[];
    }
    
    
    /**
     * @Rest\Get(path="/mes-reclamations/", name="reclamation_bourse_by_etudiant_connecte")
     * @Rest\View(StatusCode = 200)
     */
    public function findMesReclamations(): array
    {
        $reclamationBourses = $this->getDoctrine()
            ->getRepository(ReclamationBourse::class)
            ->findByEtudiant(EtudiantController::getEtudiantConnecte($this),['date'=>'DESC']);

        return count($reclamationBourses)?$reclamationBourses:[];
    }

    /**
     * @Rest\Post(Path="/create", name="reclamation_bourse_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): ReclamationBourse    {
        $reclamationBourse = new ReclamationBourse();
        $form = $this->createForm(ReclamationBourseType::class, $reclamationBourse);
        $form->submit(Utils::serializeRequestContent($request));
        $reclamationBourse->setEtudiant(EtudiantController::getEtudiantConnecte($this));
        $reclamationBourse->setDate(new \DateTime());
        // definir premiere étape des reclamations bourses
        $reclamationBourse->setEtatActuel(EtatReclamationBourseController::getEtatInitial($this));
        // créer l'historique
        $historiqueInitiale = HistoriqueEtatReclamationController::createHistoriqueFromReclamation($reclamationBourse, $this);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamationBourse);
        $em->persist($historiqueInitiale);
        
        $em->flush();

        return $reclamationBourse;
    }

    /**
     * @Rest\Get(path="/{id}", name="reclamation_bourse_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function show(ReclamationBourse $reclamationBourse): ReclamationBourse    {
        return $reclamationBourse;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="reclamation_bourse_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, ReclamationBourse $reclamationBourse): ReclamationBourse    {
        $em = $this->getDoctrine()->getManager();
        $oldEtat = $reclamationBourse->getEtatActuel();
        $form = $this->createForm(ReclamationBourseType::class, $reclamationBourse);
        $form->submit(Utils::serializeRequestContent($request));
        if($reclamationBourse->getEtatActuel()->getCode()!=$oldEtat->getCode()) {
            $historique = HistoriqueEtatReclamationController::createHistoriqueFromReclamation($reclamationBourse, $this);
            $em->persist($historique);
        }

        $em->flush();

        return $reclamationBourse;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="reclamation_bourse_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_RECLAMATIONBOURSE_CLONE")
     */
    public function cloner(Request $request, ReclamationBourse $reclamationBourse):  ReclamationBourse {
        $em=$this->getDoctrine()->getManager();
        $reclamationBourseNew=new ReclamationBourse();
        $form = $this->createForm(ReclamationBourseType::class, $reclamationBourseNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($reclamationBourseNew);

        $em->flush();

        return $reclamationBourseNew;
    }

    /**
     * @Rest\Delete("/{id}", name="reclamation_bourse_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_RECLAMATIONBOURSE_SUPPRESSION")
     */
    public function delete(ReclamationBourse $reclamationBourse): ReclamationBourse    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamationBourse);
        $entityManager->flush();

        return $reclamationBourse;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="reclamation_bourse_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_RECLAMATIONBOURSE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamationBourses = Utils::getObjectFromRequest($request);
        if (!count($reclamationBourses)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($reclamationBourses as $reclamationBourse) {
            $reclamationBourse = $entityManager->getRepository(ReclamationBourse::class)->find($reclamationBourse->id);
            $entityManager->remove($reclamationBourse);
        }
        $entityManager->flush();

        return $reclamationBourses;
    }
}
