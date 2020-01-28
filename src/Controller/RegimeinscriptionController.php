<?php

namespace App\Controller;

use App\Entity\Regimeinscription;
use App\Form\RegimeinscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/regimeinscription")
 */
class RegimeinscriptionController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="regimeinscription_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $regimeinscriptions = $this->getDoctrine()
            ->getRepository(Regimeinscription::class)
            ->findAll();

        return count($regimeinscriptions)?$regimeinscriptions:[];
    }

    /**
     * @Rest\Post(Path="/create", name="regimeinscription_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_NOUVEAU")
     */
    public function create(Request $request): Regimeinscription    {
        $regimeinscription = new Regimeinscription();
        $form = $this->createForm(RegimeinscriptionType::class, $regimeinscription);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($regimeinscription);
        $entityManager->flush();

        return $regimeinscription;
    }

    /**
     * @Rest\Get(path="/{id}", name="regimeinscription_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_AFFICHAGE")
     */
    public function show(Regimeinscription $regimeinscription): Regimeinscription    {
        return $regimeinscription;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="regimeinscription_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_EDITION")
     */
    public function edit(Request $request, Regimeinscription $regimeinscription): Regimeinscription    {
        $form = $this->createForm(RegimeinscriptionType::class, $regimeinscription);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $regimeinscription;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="regimeinscription_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_CLONE")
     */
    public function cloner(Request $request, Regimeinscription $regimeinscription):  Regimeinscription {
        $em=$this->getDoctrine()->getManager();
        $regimeinscriptionNew=new Regimeinscription();
        $form = $this->createForm(RegimeinscriptionType::class, $regimeinscriptionNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($regimeinscriptionNew);

        $em->flush();

        return $regimeinscriptionNew;
    }

    /**
     * @Rest\Delete("/{id}", name="regimeinscription_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_DELETE")
     */
    public function delete(Regimeinscription $regimeinscription): Regimeinscription    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($regimeinscription);
        $entityManager->flush();

        return $regimeinscription;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="regimeinscription_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_REGIMEINSCRIPTION_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $regimeinscriptions = Utils::getObjectFromRequest($request);
        if (!count($regimeinscriptions)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($regimeinscriptions as $regimeinscription) {
            $regimeinscription = $entityManager->getRepository(Regimeinscription::class)->find($regimeinscription->id);
            $entityManager->remove($regimeinscription);
        }
        $entityManager->flush();

        return $regimeinscriptions;
    }
}
