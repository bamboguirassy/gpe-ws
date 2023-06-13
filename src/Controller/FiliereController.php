<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Entity\FosUser;
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
        $filieres = $em->createQuery('select f from App\Entity\Filiere f, App\Entity\UserFiliere uf '
            . 'where uf.idfiliere=f and uf.iduser=?1 order by f.libellefiliere asc')
            ->setParameter(1, $this->getUser())
            ->getResult();

        return count($filieres) ? $filieres : [];
    }



    /**
     * Récuperer la liste des filières et niveaux autorisés pour l'utilisateur connecté
     * @Rest\Get(path="/with-niveaux", name="filiere_with_nivaux_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FILIERE_LISTE")
     */
    public function findWithNiveaux(): array
    {
        $em = $this->getDoctrine()->getManager();
        $filieres = $em->createQuery('select f from App\Entity\Filiere f, App\Entity\UserFiliere uf '
            . 'where uf.idfiliere=f and uf.iduser=?1 order by f.libellefiliere asc')
            ->setParameter(1, $this->getUser())
            ->getResult();
        $tabFiliere = [];
        foreach ($filieres as $filiere) {
            $filiereniveaus = $em->createQuery('select fn from App\Entity\Filiereniveau fn where fn.idfiliere=?1 order by fn.idniveau asc')
                ->setParameter(1, $filiere)
                ->getResult();
            // créer un tableau de filiere niveau avec quelques champs de filiere et niveau
            $tabNiveaux = [];
            foreach ($filiereniveaus as $filiereniveau) {
                $tabNiveaux[] = ['id' => $filiereniveau->getId(), 'nom' => $filiereniveau->getIdniveau()->getLibelleniveau(), 'code' => $filiereniveau->getIdniveau()->getCodeniveau(),'niveau_id'=>$filiereniveau->getIdniveau()->getId()];
            }

            $tabFiliere[] = ['filiere' => ['nom' => "{$filiere->getIdcycle()->getLibellecycle()} {$filiere->getLibellefiliere()}", 'code' => $filiere->getCodefiliere(), 'id' => $filiere->getId(), 'type_formation' => $filiere->getTypeFormation()], 'filiereniveaus' => $tabNiveaux];
        }
        return count($tabFiliere) ? $tabFiliere : [];
    }

    /**
     * @Rest\Post(path="/public/find-authorized-filieres", name="filiere_user_authorized_id")
     * @Rest\View(StatusCode = 200)
     * @return array
     */
    public function findUserFiliereIds(Request $request): array
    {
        $em = $this->getDoctrine()->getManager();
        $data = Utils::serializeRequestContent($request);
        // verifier si le champ email est renseigné
        if (!isset($data['email'])) {
            throw $this->createNotFoundException("L'email de l'utilisateur est introuvable.");
        }
        $filieres = $em->createQuery('select f from App\Entity\Filiere f, App\Entity\UserFiliere uf join uf.iduser user '
            . 'where uf.idfiliere=f and user.email=?1 order by f.libellefiliere asc')
            ->setParameter(1, $data['email'])
            ->getResult();
        $ids = [];
        foreach ($filieres as $filiere) {
            $ids[] = $filiere->getId();
        }

        return count($ids) ? $ids : [];
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
    public function findUserFiliere(Request $request): array
    {
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
    public function create(Request $request): Filiere
    {
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
    public function show(Filiere $filiere): Filiere
    {
        return $filiere;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="filiere_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_EDITION")
     */
    public function edit(Request $request, Filiere $filiere): Filiere
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $filiere;
    }

    /**
     * Un web service qui met uniquement à jour le champ typeFormation de filiere
     * @Rest\Put(path="/{id}/edit-type-formation", name="filiere_edit_type_formation",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_EDITION")
     */
    public function editTypeFormation(Request $request, Filiere $filiere): Filiere
    {
        // recuperer le champ type_formation de la requete
        $data = Utils::serializeRequestContent($request);
        $typeFormation = $data['type_formation'];
        // verifier que la valeur de type de formation est dans [publique, privee, mixte]
        if (!in_array($typeFormation, ['publique', 'privee', 'mixte'])) {
            throw $this->createNotFoundException("La valeur du champ typeFormation doit être dans [publique, privee, mixte]");
        }
        $filiere->setTypeFormation($typeFormation);
        $this->getDoctrine()->getManager()->flush();

        return $filiere;
    }

    /**
     * Met à jour le champ typeFormation pour une liste de filiere
     * @Rest\Put(path="/edit-type-formation", name="filiere_edit_type_formation_list")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_EDITION")
     */
    public function editTypeFormationList(Request $request): array
    {
        $data = Utils::serializeRequestContent($request);
        // vérifier qu'il y'a des filieres à modifier
        if (!isset($data['ids']) || !count($data['ids']) || !isset($data['type_formation'])) {
            throw $this->createNotFoundException("Les filières à modifier et/ou le type de formation sont introuvables.");
        }
        $typeFormation = $data['type_formation'];
        // verifier que la valeur de type de formation est dans [publique, privee, mixte]
        if (!in_array($typeFormation, ['publique', 'privee', 'mixte'])) {
            throw $this->createNotFoundException("La valeur du champ typeFormation doit être dans [publique, privee, mixte]");
        }
        $em = $this->getDoctrine()->getManager();
        $filieres = $em->createQuery('select f from App\Entity\Filiere f where f.id in (?1)')
            ->setParameter(1, $data['ids'])
            ->getResult();
        // verifier s'il y'a une filiere qui n'existe pas
        if (count($filieres) != count($data['ids'])) {
            throw $this->createNotFoundException("Une ou plusieurs filières n'existent pas parmi les ids envoyés");
        }
        foreach ($filieres as $filiere) {
            $filiere->setTypeFormation($typeFormation);
        }
        $em->flush();

        return ['error' => false, 'message' => 'Mise à jour effectuée avec succès'];
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="filiere_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FILIERE_CLONE")
     */
    public function cloner(Request $request, Filiere $filiere): Filiere
    {
        $em = $this->getDoctrine()->getManager();
        $filiereNew = new Filiere();
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
    public function delete(Filiere $filiere): Filiere
    {
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
    public function deleteMultiple(Request $request): array
    {
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
