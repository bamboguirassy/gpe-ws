<?php

namespace App\Controller;

use App\Entity\BourseEtudiant;
use App\Form\BourseEtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/bourseetudiant")
 */
class BourseEtudiantController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="bourse_etudiant_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $em = $this->getDoctrine()->getManager();
        // reccuperer les années des bourses
        $anneeObjects = $em->createQuery('select distinct be.annee from '
                        . 'App\Entity\BourseEtudiant be order by be.annee desc')
                ->getResult();
        // pour chaque année, reccuperer les mois de bourse disponibles
        $tab_annee = [];
        foreach ($anneeObjects as $anneeObject) {
            $tab_mois = [];
            $listeMois = $em->createQuery('select distinct be.mois from '
                            . 'App\Entity\BourseEtudiant be where be.annee=?1 order by be.id desc')
                    ->setParameter(1, (array)$anneeObject['annee'])
                    ->getResult();
            // pour chaque mois, verifier si l'étudiant est sur les états
            foreach ($listeMois as $moisObject) {
                $bourseEtudiants = $em->getRepository('App\Entity\BourseEtudiant')
                        ->findBy(['annee' => (array)$anneeObject['annee'], 'mois' => (array)$moisObject['mois'], 'cni' => $etudiant->getCni()]);
                if(count($bourseEtudiants)) {
                    $tab_mois[] = ['mois'=>(array)$moisObject['mois'],'bourseEtudiant'=>$bourseEtudiants[0]];
                } else {
                    $tab_mois[] = ['mois'=>(array)$moisObject['mois'],'bourseEtudiant'=>null];
                }
            }
            $tab_annee[] = ['annee' => (array)$anneeObject['annee'], 'tabMois' => $tab_mois];
        }

        return count($tab_annee) ? $tab_annee : [];
    }
    
    
    /**
     * @Rest\Get(path="/nomatching/mois/{mois}/annee/{annee}", name="bourse_etudiant_with_no_matching_per_month_year")
     * @Rest\View(StatusCode = 200)
     */
    public function findEtatBourseWithNoMatching($mois, $annee): array {
        $em = $this->getDoctrine()->getManager();
        $bourseWithNoMatchings = $em->createQuery('select be from '
                . 'App\Entity\BourseEtudiant be where be.mois=?1 '
                . 'and be.annee=?2 and be.cni not in'
                . ' (select e.cni from App\Entity\Etudiant e) ')
                ->setParameter(1,$mois)
                ->setParameter(2,$annee)
                ->getResult();
       return $bourseWithNoMatchings;
    }
    
    /**
     * @Rest\Get(path="/nomatching/global/", name="bourse_etudiant_with_no_matching_global")
     * @Rest\View(StatusCode = 200)
     */
    public function findGlobalEtatBourseWithNoMatching(): array {
        $em = $this->getDoctrine()->getManager();
        $bourseWithNoMatchings = $em->createQuery('select be from '
                . 'App\Entity\BourseEtudiant be where be.cni not in'
                . ' (select e.cni from App\Entity\Etudiant e) ')
                ->getResult();
       return $bourseWithNoMatchings;
    }
    
    /**
     * @Rest\Get(path="/available-states/", name="bourse_etudiant_available_states")
     * @Rest\View(StatusCode = 200)
     */
    public function findAvalaibleStatesBourse(): array {
        $em = $this->getDoctrine()->getManager();
        // reccuperer les années des bourses
        $anneeObjects = $em->createQuery('select distinct be.annee from '
                        . 'App\Entity\BourseEtudiant be order by be.annee desc')
                ->getResult();
        // pour chaque année, reccuperer les mois de bourse disponibles
        $tab_annee = [];
        foreach ($anneeObjects as $anneeObject) {
            $listeMois = $em->createQuery('select distinct be.mois from '
                            . 'App\Entity\BourseEtudiant be where be.annee=?1 order by be.id desc')
                    ->setParameter(1, $anneeObject['annee'])
                    ->getResult();
            $tab_annee[] = ['annee' => $anneeObject['annee'], 'listeMois' => $listeMois];
        }

        return count($tab_annee) ? $tab_annee : [];
    }
    
    

    /**
     * @Rest\Post(Path="/create", name="bourse_etudiant_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_BOURSEETUDIANT_NOUVEAU")
     */
    public function create(Request $request): BourseEtudiant {
        $bourseEtudiant = new BourseEtudiant();
        $form = $this->createForm(BourseEtudiantType::class, $bourseEtudiant);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($bourseEtudiant);
        $entityManager->flush();

        return $bourseEtudiant;
    }

    /**
     * @Rest\Get(path="/{id}", name="bourse_etudiant_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_BOURSEETUDIANT_AFFICHAGE")
     */
    public function show(BourseEtudiant $bourseEtudiant): BourseEtudiant {
        return $bourseEtudiant;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="bourse_etudiant_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, BourseEtudiant $bourseEtudiant): BourseEtudiant {
        $form = $this->createForm(BourseEtudiantType::class, $bourseEtudiant);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $bourseEtudiant;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="bourse_etudiant_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_BOURSEETUDIANT_CLONE")
     */
    public function cloner(Request $request, BourseEtudiant $bourseEtudiant): BourseEtudiant {
        $em = $this->getDoctrine()->getManager();
        $bourseEtudiantNew = new BourseEtudiant();
        $form = $this->createForm(BourseEtudiantType::class, $bourseEtudiantNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($bourseEtudiantNew);

        $em->flush();

        return $bourseEtudiantNew;
    }

    /**
     * @Rest\Delete("/{id}", name="bourse_etudiant_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_BOURSEETUDIANT_SUPPRESSION")
     */
    public function delete(BourseEtudiant $bourseEtudiant): BourseEtudiant {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bourseEtudiant);
        $entityManager->flush();

        return $bourseEtudiant;
    }

    /**
     * @Rest\Post("/delete-selection/", name="bourse_etudiant_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_BOURSEETUDIANT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $bourseEtudiants = Utils::getObjectFromRequest($request);
        if (!count($bourseEtudiants)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($bourseEtudiants as $bourseEtudiant) {
            $bourseEtudiant = $entityManager->getRepository(BourseEtudiant::class)->find($bourseEtudiant->id);
            $entityManager->remove($bourseEtudiant);
        }
        $entityManager->flush();

        return $bourseEtudiants;
    }

}
