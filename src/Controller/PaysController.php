<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/pays")
 */
class PaysController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="pays_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $pays = $this->getDoctrine()
            ->getRepository(Pays::class)
            ->findAll();

        return count($pays)?$pays:[];
    }

    /**
     * @Rest\Post(Path="/create", name="pays_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_NOUVEAU")
     */
    public function create(Request $request): Pays    {
        $pay = new Pays();
        $form = $this->createForm(PaysType::class, $pay);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pay);
        $entityManager->flush();

        return $pay;
    }

    /**
     * @Rest\Get(path="/{id}", name="pays_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_AFFICHAGE")
     */
    public function show(Pays $pay): Pays    {
        return $pay;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="pays_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_EDITION")
     */
    public function edit(Request $request, Pays $pay): Pays    {
        $form = $this->createForm(PaysType::class, $pay);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $pay;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="pays_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_CLONE")
     */
    public function cloner(Request $request, Pays $pay):  Pays {
        $em=$this->getDoctrine()->getManager();
        $payNew=new Pays();
        $form = $this->createForm(PaysType::class, $payNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($payNew);

        $em->flush();

        return $payNew;
    }

    /**
     * @Rest\Delete("/{id}", name="pays_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_DELETE")
     */
    public function delete(Pays $pay): Pays    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($pay);
        $entityManager->flush();

        return $pay;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="pays_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAYS_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $pays = Utils::getObjectFromRequest($request);
        if (!count($pays)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($pays as $pay) {
            $pay = $entityManager->getRepository(Pays::class)->find($pay->id);
            $entityManager->remove($pay);
        }
        $entityManager->flush();

        return $pays;
    }
}
