<?php

namespace App\Controller;

use App\Entity\Anneeacad;
use App\Entity\Classe;
use App\Entity\Filiere;
use App\Entity\Niveau;
use App\Form\ClasseType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/classe")
 */
class ClasseController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="classe_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_CLASSE_LISTE")
     */
    public function index(): array
    {
        $classes = $this->getDoctrine()
            ->getRepository(Classe::class)
            ->findAll();

        return count($classes) ? $classes : [];
    }

    /**
     * @Rest\Post(Path="/create", name="classe_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_NOUVEAU")
     */
    public function create(Request $request): Classe
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($classe);
        $entityManager->flush();

        return $classe;
    }

    /**
     * @Rest\Get(path="/{id}", name="classe_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_AFFICHAGE")
     */
    public function show(Classe $classe): Classe
    {
        return $classe;
    }


    /**
     * @Rest\Put(path="/{id}/edit", name="classe_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_EDITION")
     */
    public function edit(Request $request, Classe $classe): Classe
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $classe;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="classe_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_CLONE")
     */
    public function cloner(Request $request, Classe $classe): Classe
    {
        $em = $this->getDoctrine()->getManager();
        $classeNew = new Classe();
        $form = $this->createForm(ClasseType::class, $classeNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($classeNew);

        $em->flush();

        return $classeNew;
    }

    /**
     * @Rest\Delete("/{id}", name="classe_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_SUPPRESSION")
     */
    public function delete(Classe $classe): Classe
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($classe);
        $entityManager->flush();

        return $classe;
    }

    /**
     * @Rest\Post("/delete-selection/", name="classe_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_CLASSE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classes = Utils::getObjectFromRequest($request);
        if (!count($classes)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($classes as $classe) {
            $classe = $entityManager->getRepository(Classe::class)->find($classe->id);
            $entityManager->remove($classe);
        }
        $entityManager->flush();

        return $classes;
    }

    /**
     *Permet de recupérer une liste de classes en spécifiant le libelleFiliere et l'année académique
     *
     * @Rest\Post("/annee", name="by_anneeacad_filiere")
     * @Rest\View(statusCode=200)
     * @param Request $request
     * @return array
     */
    public function findClasseByFiliereAndAnneeAcad(Request $request): array
    {
        /** @var Classe[] $classes */
        /** @var EntityManagerInterface $manager */

        $data = Utils::serializeRequestContent($request);
        $manager = $this->getDoctrine()->getManager();

        $classes = $manager->createQuery(
            'SELECT c FROM App\Entity\Classe c, App\Entity\Filiere f WHERE c.idanneeacad = ?1 AND f.libellefiliere = ?2 AND c.idfiliere = f')
            ->setParameter(1, $data['annee'])->setParameter(2, $data['libelleFiliere'])->getResult();

        return $classes;
    }


    /**
     *
     * @Rest\Post("/niveau/{id}", name="classe_by_niveau")
     * @Rest\View(statusCode=200)
     * @param Request $request
     * @param Niveau $niveau
     * @return Classe
     */
    public function findClasseByNiveau(Request $request, Niveau $niveau): Classe
    {
        $manager = $this->getDoctrine()->getManager();
        $data = Utils::serializeRequestContent($request);
        return $manager->createQuery("SELECT c FROM App\Entity\Classe c, App\Entity\Filiere f WHERE f.libellefiliere = ?1 AND  c.idanneeacad = ?2 AND c.idniveau = ?3 AND c.idfiliere = f")
            ->setParameter(1, $data["libelleFiliere"])->setParameter(2, $data["annee"])->setParameter(3, $niveau)->getSingleResult();
    }
    

}
