<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/filiere")
 */
class FiliereController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="filiere_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FILIERE_LISTE")
     * @return array
     */
    public function index(): array
    {
        $em = $this->getDoctrine()->getManager();
        $filieres = $em->getRepository(Filiere::class)
            ->findAll(['nomfiliere'=>'asc']);

        return count($filieres)?$filieres:[];
    }

    /**
     * Permet de recupérer la liste des filieres aux quelles l'utilisateur est autorisé
     * En spécifiant le codeGroupe de l'utisateur dans la requete
     *
     * @Rest\Get(path="/userfiliere", name="user_filiere")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FILIERE_LISTE")
     * @param Request $request
     * @return array
     */
    public function findUserFiliere(Request $request): array {
        $em = $this->getDoctrine()->getManager();
        $filieres = [];
        $data = Utils::serializeRequestContent($request);
        if ($this->getUser()->getIdgroup()->getCodegroupe() == $data['codeGroupe']) {
            $filieres = $em->createQuery('select f from App\Entity\Filiere f,'
                . 'App\Entity\UserFiliere uf where uf.idfiliere=f and f.libellefiliere=?1 and uf.iduser=?2')
                ->setParameter(1, $data['libelleFiliere'])
                ->setParameter(2, $this->getUser())
                ->getResult();
        }

        return $filieres;
    }

    /**
     * @Rest\Post(Path="/create", name="filiere_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_NOUVEAU")
     */
    public function create(Request $request): Filiere    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($filiere);
        $entityManager->flush();
        return $filiere;
    }

    /**
     * @Rest\Get(path="/{id}", name="filiere_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_AFFICHAGE")
     */
    public function show(Filiere $filiere): Filiere    {
        return $filiere;
    }


    /**
     * @Rest\Put(path="/{id}/edit", name="filiere_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_EDITION")
     */
    public function edit(Request $request, Filiere $filiere): Filiere    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $filiere;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="filiere_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_CLONE")
     */
    public function cloner(Request $request, Filiere $filiere):  Filiere {
        $em=$this->getDoctrine()->getManager();
        $filiereNew=new Filiere();
        $form = $this->createForm(FiliereType::class, $filiereNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($filiereNew);

        $em->flush();

        return $filiereNew;
    }

    /**
     * @Rest\Delete("/{id}", name="filiere_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_SUPPRESSION")
     */
    public function delete(Filiere $filiere): Filiere    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($filiere);
        $entityManager->flush();

        return $filiere;
    }

    /**
     * @Rest\Post("/delete-selection/", name="filiere_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $filieres = Utils::getObjectFromRequest($request);
        if (!count($filieres)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($filieres as $filiere) {
            $filiere = $entityManager->getRepository(Filiere::class)->find($filiere->id);
            $entityManager->remove($filiere);
        }
        $entityManager->flush();

        return $filieres;
    }
}
