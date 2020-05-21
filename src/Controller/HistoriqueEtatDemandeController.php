<?php

namespace App\Controller;

use App\Entity\HistoriqueEtatDemande;
use App\Form\HistoriqueEtatDemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/historiqueetatdemande")
 */
class HistoriqueEtatDemandeController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="historique_etat_demande_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_LISTE")
     */
    public function index(): array
    {
        $historiqueEtatDemandes = $this->getDoctrine()
            ->getRepository(HistoriqueEtatDemande::class)
            ->findAll();

        return count($historiqueEtatDemandes)?$historiqueEtatDemandes:[];
    }

    /**
     * @Rest\Post(Path="/create", name="historique_etat_demande_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_NOUVEAU")
     */
    public function create(Request $request): HistoriqueEtatDemande    {
        $historiqueEtatDemande = new HistoriqueEtatDemande();
        $form = $this->createForm(HistoriqueEtatDemandeType::class, $historiqueEtatDemande);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($historiqueEtatDemande);
        $entityManager->flush();

        return $historiqueEtatDemande;
    }

    /**
     * @Rest\Get(path="/{id}", name="historique_etat_demande_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_AFFICHAGE")
     */
    public function show(HistoriqueEtatDemande $historiqueEtatDemande): HistoriqueEtatDemande    {
        return $historiqueEtatDemande;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="historique_etat_demande_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_EDITION")
     */
    public function edit(Request $request, HistoriqueEtatDemande $historiqueEtatDemande): HistoriqueEtatDemande    {
        $form = $this->createForm(HistoriqueEtatDemandeType::class, $historiqueEtatDemande);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $historiqueEtatDemande;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="historique_etat_demande_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_CLONE")
     */
    public function cloner(Request $request, HistoriqueEtatDemande $historiqueEtatDemande):  HistoriqueEtatDemande {
        $em=$this->getDoctrine()->getManager();
        $historiqueEtatDemandeNew=new HistoriqueEtatDemande();
        $form = $this->createForm(HistoriqueEtatDemandeType::class, $historiqueEtatDemandeNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($historiqueEtatDemandeNew);

        $em->flush();

        return $historiqueEtatDemandeNew;
    }

    /**
     * @Rest\Delete("/{id}", name="historique_etat_demande_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_SUPPRESSION")
     */
    public function delete(HistoriqueEtatDemande $historiqueEtatDemande): HistoriqueEtatDemande    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($historiqueEtatDemande);
        $entityManager->flush();

        return $historiqueEtatDemande;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="historique_etat_demande_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_HISTORIQUEETATDEMANDE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $historiqueEtatDemandes = Utils::getObjectFromRequest($request);
        if (!count($historiqueEtatDemandes)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($historiqueEtatDemandes as $historiqueEtatDemande) {
            $historiqueEtatDemande = $entityManager->getRepository(HistoriqueEtatDemande::class)->find($historiqueEtatDemande->id);
            $entityManager->remove($historiqueEtatDemande);
        }
        $entityManager->flush();

        return $historiqueEtatDemandes;
    }
}
