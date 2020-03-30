<?php

namespace App\Controller;

use App\Entity\Anneeacad;
use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Entity\Inscriptionacad;
use App\Form\EtudiantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/etudiant")
 */
class EtudiantController extends AbstractController
{

    /**
     * @Rest\Get(path="/", name="etudiant_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ETUDIANT_LISTE")
     */
    public function index(): array
    {
        $etudiants = $this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->findAll();

        return count($etudiants) ? $etudiants : [];
    }

    /**
     * @Rest\Get(path="/statistique-globale/", name="etudiant_statistique_globale")
     * @Rest\View(StatusCode = 200)
     */
    public function findGlobalStatistiqueByEtudiant(): array
    {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $nombreInscription = 0;
        $nombreClasseRedoublee = 0;
        $nombrePassageConditionnel = 0;
        $nombreUeNonValidee = 0;
        $nombreUeValidee = 0;
        $nombrePreinscriptionActive = 0;

        return [
            'nombreInscription' => $nombreInscription,
            'nombreClasseRedoublee' => $nombreClasseRedoublee,
            'nombrePassageConditionnel' => $nombrePassageConditionnel,
            'nombreUeNonValidee' => $nombreUeNonValidee,
            'nombreUeValidee' => $nombreUeValidee,
            'nombrePreinscriptionActive' => $nombrePreinscriptionActive,
        ];
    }

    /**
     * @Rest\Get(path="/statistique-parcours/{id}", name="etudiant_statistique_globale")
     * @Rest\View(StatusCode = 200)
     */
    public function findStatistiqueParcoursByEtudiant(Inscriptionacad $inscriptionacad): array
    {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $nombreUeInscrite = 0;
        $totalCreditInscrit = 0;
        $totalCreditCapitalise = 0;
        $nombreUeNonValidee = 0;
        $nombreUeValidee = 0;
        $nombreUeAnterieureReprise = 0;

        return [
            'nombreUeInscrite' => $nombreUeInscrite,
            'totalCreditInscrit' => $totalCreditInscrit,
            'totalCreditCapitalise' => $totalCreditCapitalise,
            'nombreUeNonValidee' => $nombreUeNonValidee,
            'nombreUeValidee' => $nombreUeValidee,
            'nombreUeAnterieureReprise' => $nombreUeAnterieureReprise,
        ];
    }

    /**
     * @Rest\Post(Path="/create", name="etudiant_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_NOUVEAU")
     */
    public function create(Request $request): Etudiant
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($etudiant);
        $entityManager->flush();

        return $etudiant;
    }

    /**
     * @Rest\Get(path="/{id}", name="etudiant_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_AFFICHAGE")
     */
    public function show(Etudiant $etudiant): Etudiant
    {
        return $etudiant;
    }

    /**
     * @Rest\Get(path="/situation-matrimoniale/", name="situation_matrimoniale_list")
     * @Rest\View(StatusCode=200)
     */
    public function getSituationMatrimonialeValues()
    {
        return [
            ["value" => 'C', "label" => 'Célibataire'],
            ["value" => 'M', "label" => 'Marié (e)'],
            ["value" => 'D', "label" => 'Divorcé (e)'],
            ["value" => 'V', "label" => 'Veuf (ve)']
        ];
    }

    /**
     * @Rest\Get(path="/handicap/", name="handicap_list")
     * @Rest\View(StatusCode=200)
     */
    public function getHandicapValues()
    {
        return [
            ["value" => 'Oui', "label" => 'Oui'],
            ["value" => 'Non', "label" => 'Non']
        ];
    }

    /**
     * @Rest\Get(path="/orphelin/", name="orphelin_list")
     * @Rest\View(StatusCode=200)
     */
    public function getOrphelinValues()
    {
        return [
            ["value" => 'Oui', "label" => 'Oui'],
            ["value" => 'Non', "label" => 'Non']
        ];
    }

    /**
     * @Rest\Get(path="/type-handicap/", name="type_handicap_list")
     * @Rest\View(StatusCode=200)
     */
    public function getTypeHandicapValues()
    {
        return [
            ["value" => 'Handicap mental (ou déficience intellectuelle)', "label" => 'Handicap mental (ou déficience intellectuelle'],
            ["value" => 'Handicap auditif', "label" => 'Handicap auditif'],
            ["value" => 'Handicap visuel', "label" => "Handicap visuel"],
            ["value" => 'Handicap moteur', "label" => "Handicap moteur"],
            ["value" => 'Autisme et Troubles Envahissants du Développement', "label" => 'Autisme et Troubles Envahissants du Développement'],
            ["value" => 'Handicap Psychique', "label" => 'Handicap Psychique'],
            ["value" => 'Plurihandicap', "label" => 'Plurihandicap'],
            ["value" => 'Polyhandicap', "label" => 'Polyhandicap'],
            ["value" => 'Traumatismes crâniens', "label" => 'Traumatismes crâniens'],
            ["value" => 'Maladies dégénératives', "label" => 'Maladies dégénératives'],
            ["value" => 'Troubles dys', "label" => 'Troubles dys']
        ];
    }

    /**
     * @Rest\Get(path="/cni/{cni}", name="etudiant_by_cni")
     * @Rest\View(StatusCode=200)
     */
    public function findByCni($cni): Etudiant
    {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository(Etudiant::class)->findOneByCni($cni);
        if (!$etudiant) {
            throw $this->createNotFoundException("Etudiant introuvable avec le cni :" . $cni);
        }
        return $etudiant;
    }

    /**
     * @Rest\Get(path="/mon-compte/", name="etudiant_mon_compte")
     * @Rest\View(StatusCode=200)
     */
    public function getMonCompteEtudiant(): Etudiant
    {
        return EtudiantController::getEtudiantConnecte($this);
    }

    public static function getEtudiantConnecte($controller)
    {
        $etudiants = $controller->getDoctrine()->getManager()->createQuery('select et from App\Entity\Etudiant et'
            . 'where et.email=?1')->setParameter(1, $controller->getUser()->getEmail())
            ->getResult();

        if (count($etudiants) < 1) {
            throw $controller->createAccessDeniedException("Votre compte n'est rattaché à aucun étudiant.");
        }
        return $etudiants[0];
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="etudiant_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, Etudiant $etudiant): Etudiant
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));
        //find
        if ($etudiant->getAdPays()->getAlpha2() != 'SN') {
            $senegal = $em->getRepository(\App\Entity\Pays::class)->findOneByAlpha2('SN');
            $etudiant->setAdpays($senegal);
        }
        if ($etudiant->getHandicap() == 'Non') {
            $etudiant->setTypeHandicap(null);
            $etudiant->setDescriptionHandicap(null);
        }

        $em->flush();

        return $etudiant;
    }

    /**
     * @Rest\Put(path="/update-infos/", name="etudiant_auto_update")
     * @Rest\View(StatusCode=200)
     */
    public function updateInfosByEtudiant(Request $request): Etudiant
    {
        $etudiant = EtudiantController::getEtudiantConnecte($this);
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $etudiant;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="etudiant_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_CLONE")
     */
    public function cloner(Request $request, Etudiant $etudiant): Etudiant
    {
        $em = $this->getDoctrine()->getManager();
        $etudiantNew = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiantNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($etudiantNew);

        $em->flush();

        return $etudiantNew;
    }

    /**
     * @Rest\Delete("/{id}", name="etudiant_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_DELETE")
     */
    public function delete(Etudiant $etudiant): Etudiant
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($etudiant);
        $entityManager->flush();

        return $etudiant;
    }

    /**
     * @Rest\Post("/delete-selection/", name="etudiant_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ETUDIANT_DELETE")
     */
    public function deleteMultiple(Request $request): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiants = Utils::getObjectFromRequest($request);
        if (!count($etudiants)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($etudiants as $etudiant) {
            $etudiant = $entityManager->getRepository(Etudiant::class)->find($etudiant->id);
            $entityManager->remove($etudiant);
        }
        $entityManager->flush();

        return $etudiants;
    }

    /**
     * Permet de recupérer tous les étudiants d'une filière donnée pour une annéé académique
     *
     * @Rest\Post("/filiere", name="etudiants_by_filiere")
     * @Rest\View(statusCode=200)
     * @param Request $request
     * @return array
     */
    public function findAllEtudiantByFiliere(Request $request): array
    {
        /** @var Etudiant[] $etudiants */

        $data = Utils::serializeRequestContent($request);
        $manager = $this->getDoctrine()->getManager();
        $annee = $manager->getRepository(Anneeacad::class)->find($data['annee']);
        if (isset($annee))
            $etudiants = $manager
                ->createQuery('SELECT e FROM App\Entity\Etudiant e, App\Entity\Inscriptionacad i, App\Entity\Classe c, App\Entity\Filiere f WHERE f.libellefiliere = ?1 AND c.idfiliere = f AND c.idanneeacad = ?2 AND i.idclasse = c and i.idetudiant = e')
                ->setParameter(1, $data['libelleFiliere'])->setParameter(2, $annee)->getResult();

        return $etudiants;
    }

    /**
     * @Rest\Get("/classe/{id}", name="etudiants_by_classe")
     * @Rest\View(statusCode=200)
     * @param Classe $classe
     * @return array
     */
    public function findEtudiantByClasse(Classe $classe): array
    {
        /** @var Etudiant[] $etudiants */

        $manager = $this->getDoctrine()->getManager();
        $etudiants = $manager->createQuery('SELECT e FROM App\Entity\Etudiant e, App\Entity\Inscriptionacad i WHERE i.idclasse = ?1 AND i.idetudiant = e')->setParameter(1, $classe)->getResult();
        return $etudiants;
    }

}
