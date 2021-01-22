<?php

namespace App\Controller;

use App\Entity\VisiteMedicale;
use App\Form\VisiteMedicaleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/api/visitemedicale")
 */
class VisiteMedicaleController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="visite_medicale_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VISITE MEDICALE_LISTE")
     */
    public function index(): array
    {
        $visiteMedicales = $this->getDoctrine()
            ->getRepository(VisiteMedicale::class)
            ->findAll();

        return count($visiteMedicales) ? $visiteMedicales : [];
    }

    /**
     * @Rest\Post(Path="/create", name="visite_medicale_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_NOUVEAU")
     */
    public function create(Request $request): VisiteMedicale
    {
        $visiteMedicale = new VisiteMedicale();
        $form = $this->createForm(VisiteMedicaleType::class, $visiteMedicale);
        $form->submit(Utils::serializeRequestContent($request));

        $requestData = Utils::getObjectFromRequest($request);
        $visiteMedicale->setDate(new \DateTime($requestData->date));
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($visiteMedicale);
        $entityManager->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Get(path="/{id}", name="visite_medicale_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_AFFICHAGE")
     */
    public function show(VisiteMedicale $visiteMedicale): VisiteMedicale
    {
        return $visiteMedicale;
    }


    /**
     * @Rest\Put(path="/{id}/edit", name="visite_medicale_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_EDITION")
     */
    public function edit(Request $request, VisiteMedicale $visiteMedicale): VisiteMedicale
    {
        $form = $this->createForm(VisiteMedicaleType::class, $visiteMedicale);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="visite_medicale_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_CLONE")
     */
    public function cloner(Request $request, VisiteMedicale $visiteMedicale): VisiteMedicale
    {
        $em = $this->getDoctrine()->getManager();
        $visiteMedicaleNew = new VisiteMedicale();
        $form = $this->createForm(VisiteMedicaleType::class, $visiteMedicaleNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($visiteMedicaleNew);

        $em->flush();

        return $visiteMedicaleNew;
    }

    /**
     * @Rest\Delete("/{id}", name="visite_medicale_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_SUPPRESSION")
     */
    public function delete(VisiteMedicale $visiteMedicale): VisiteMedicale
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($visiteMedicale);
        $entityManager->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Post("/delete-selection/", name="visite_medicale_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_VISITE MEDICALE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $visiteMedicales = Utils::getObjectFromRequest($request);
        if (!count($visiteMedicales)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($visiteMedicales as $visiteMedicale) {
            $visiteMedicale = $entityManager->getRepository(VisiteMedicale::class)->find($visiteMedicale->id);
            $entityManager->remove($visiteMedicale);
        }
        $entityManager->flush();

        return $visiteMedicales;
    }
}
