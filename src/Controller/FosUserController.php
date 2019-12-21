<?php

namespace App\Controller;

use App\Entity\FosUser;
use App\Form\FosUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/fos_user")
 */
class FosUserController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="fos_user_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FOSUSER_LISTE")
     */
    public function index(): array {
        $fosUsers = $this->getDoctrine()
                ->getRepository(FosUser::class)
                ->findAll();

        return count($fosUsers) ? $fosUsers : [];
    }

    /**
     * @Rest\Post(Path="/create", name="fos_user_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_NOUVEAU")
     */
    public function create(Request $request): FosUser {
        $fosUser = new FosUser();
        $form = $this->createForm(FosUserType::class, $fosUser);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fosUser);
        $entityManager->flush();

        return $fosUser;
    }

    /**
     * @Rest\Get(path="/{id}", name="fos_user_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_AFFICHAGE")
     */
    public function show(FosUser $fosUser): FosUser {
        return $fosUser;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="fos_user_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_EDITION")
     */
    public function edit(Request $request, FosUser $fosUser): FosUser {
        $form = $this->createForm(FosUserType::class, $fosUser);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $fosUser;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="fos_user_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_CLONE")
     */
    public function cloner(Request $request, FosUser $fosUser): FosUser {
        $em = $this->getDoctrine()->getManager();
        $fosUserNew = new FosUser();
        $form = $this->createForm(FosUserType::class, $fosUserNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($fosUserNew);

        $em->flush();

        return $fosUserNew;
    }

    /**
     * @Rest\Delete("/{id}", name="fos_user_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_DELETE")
     */
    public function delete(FosUser $fosUser): FosUser {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fosUser);
        $entityManager->flush();

        return $fosUser;
    }

    /**
     * @Rest\Post("/delete-selection/", name="fos_user_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $fosUsers = Utils::getObjectFromRequest($request);
        if (!count($fosUsers)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($fosUsers as $fosUser) {
            $fosUser = $entityManager->getRepository(FosUser::class)->find($fosUser->id);
            $entityManager->remove($fosUser);
        }
        $entityManager->flush();

        return $fosUsers;
    }

}
