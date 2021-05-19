<?php

namespace App\Controller;

use App\Entity\FosGroup;
use App\Entity\Profil;
use App\Entity\VisiteMedicale;
use App\Form\VisiteMedicaleType;
use Doctrine\ORM\EntityManagerInterface;
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
class VisiteMedicaleController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="visite_medicale_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_VISITE MEDICALE_LISTE")
     */
    public function index(): array {
        /** @var FosGroup $groupe */
        $groupe = $this->getUser()->getIdGroup();
        /** @var Profil $currentUserProfile */
        $currentUserProfile = $this->getUser()->getProfession();
        if ($groupe->getCodegroupe() == 'MEDECIN') {
            $visiteMedicales = $this->getDoctrine()
                    ->getRepository(VisiteMedicale::class)
                    ->findByUser($this->getUser()->getUsername());
            return count($visiteMedicales) ? $visiteMedicales : [];
        }
        if ($groupe->getCodegroupe() == 'SA' || $currentUserProfile->getCodeprofil() == 'DSOS' || $groupe->getCodegroupe() == 'ADSOS') {
            $visiteMedicales = $this->getDoctrine()->getManager()
                    ->createQuery('select vm from App\Entity\VisiteMedicale vm order by id desc')
                    ->getResult();
            return count($visiteMedicales) ? $visiteMedicales : [];
        }

        throw $this->createAccessDeniedException('Accés Interdit, vous n\'avez pas le droit de visualiser ce contenu.');
    }

    /**
     * @Rest\Post(Path="/create", name="visite_medicale_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): VisiteMedicale {
        $visiteMedicale = new VisiteMedicale();
        $form = $this->createForm(VisiteMedicaleType::class, $visiteMedicale);
        $form->submit(Utils::serializeRequestContent($request));

        $requestData = Utils::getObjectFromRequest($request);
        $visiteMedicale->setDate(new \DateTime($requestData->date));
        $visiteMedicale->setUser($this->getUser()->getEmail());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($visiteMedicale);
        $entityManager->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Get(path="/{id}", name="visite_medicale_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function show(VisiteMedicale $visiteMedicale): VisiteMedicale {
        return $visiteMedicale;
    }

    /**
     * @Rest\Get(path="/with-inscriptionacad", name="visite_medicale_with_inscriptionacad")
     * @Rest\View(StatusCode=200)
     */
    public function findWithAtLeastOneInsacad(Request $request, EntityManagerInterface $entityManager) {
        /** @var FosGroup $currentUserGroupe */
        $currentUserGroupe = $this->getUser()->getIdgroup();
        $query = '
        SELECT vm
        FROM App\Entity\VisiteMedicale vm
        JOIN vm.inscriptionacad ia
        JOIN ia.idetudiant etu
        JOIN ia.idclasse classe
        JOIN classe.idanneeacad aa
        WHERE aa = :anneeEnCours
       ';

        $doctorQuery = '
        SELECT vm
        FROM App\Entity\VisiteMedicale vm
        JOIN vm.inscriptionacad ia
        JOIN ia.idetudiant etu
        JOIN ia.idclasse classe
        JOIN classe.idanneeacad aa
        WHERE aa = :anneeEnCours AND vm.user = :user
        ';

        $subQuery = '
            SELECT an
            FROM App\Entity\Anneeacad an
            WHERE an.encours = :enCours
            ORDER BY an.id DESC
        ';

        $lastAnneeEnCours = $entityManager
                ->createQuery($subQuery)
                ->setParameter('enCours', true)
                ->setMaxResults(1)
                ->getSingleResult();

        if ($currentUserGroupe->getCodegroupe() == 'SA') {
            return $entityManager
                            ->createQuery($query)
                            ->setParameter('anneeEnCours', $lastAnneeEnCours)
                            ->setMaxResults(500)
                            ->getResult();
        }
        if ($currentUserGroupe->getCodegroupe() == 'MEDECIN') {
            return $entityManager
                            ->createQuery($doctorQuery)
                            ->setParameters([
                                'anneeEnCours' => $lastAnneeEnCours,
                                'user' => $this->getUser()->getUsername()
                            ])
                            ->setMaxResults(100)
                            ->getResult();
        }
        throw $this->createAccessDeniedException('Accés Interdit, vous n\'avez pas le droit de visualiser ce contenu.');
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="visite_medicale_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, VisiteMedicale $visiteMedicale): VisiteMedicale {
        $form = $this->createForm(VisiteMedicaleType::class, $visiteMedicale);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="visite_medicale_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function cloner(Request $request, VisiteMedicale $visiteMedicale): VisiteMedicale {
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
     */
    public function delete(VisiteMedicale $visiteMedicale): VisiteMedicale {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($visiteMedicale);
        $entityManager->flush();

        return $visiteMedicale;
    }

    /**
     * @Rest\Post("/delete-selection/", name="visite_medicale_selection_delete")
     * @Rest\View(StatusCode=200)
     */
    public function deleteMultiple(Request $request): array {
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
