<?php

namespace App\Controller;

use App\Entity\PaiementFraisEncadrement;
use App\Form\PaiementFraisEncadrementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/paiement/frais/encadrement")
 */
class PaiementFraisEncadrementController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="paiement_frais_encadrement_index")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $paiementFraisEncadrement = $this->getDoctrine()
            ->getRepository(PaiementFraisEncadrement::class)
            ->findAll();
      
        return count($paiementFraisEncadrement)?$paiementFraisEncadrement:[];
    }
    
    /**
     * @Rest\Get(path="/inscriptionacad/{id}", name="paiement_frais_encadrement_by_inscriptionacad")
     * @Rest\View(StatusCode = 200)
     */
    public function findByInscriptionacad(\App\Entity\Inscriptionacad $inscriptionacad) {
        $em = $this->getDoctrine()->getManager();
        $paiementfraisencadrements = $em->getRepository(PaiementFraisEncadrement::class)
                ->findBy(['inscriptionacad' => $inscriptionacad]);
        $paramfraisencadrement = $em->getRepository(\App\Entity\ParamFraisEncadrement::class)
                ->findBy(['filiere'=>$inscriptionacad->getIdclasse()->getIdfiliere()]);
        
        $totalmontantpaye = 0;
        
        foreach ($paiementfraisencadrements as $paiementfraisencadrement){
            $totalmontantpaye = $totalmontantpaye + $paiementfraisencadrement->getMontantPaye();
            
        }
        
        return ['paiementfraisencadrements'=>count($paiementfraisencadrements)?$paiementfraisencadrements:[],
         'paramfraisencadrement'=> count($paramfraisencadrement)?$paramfraisencadrement:[], 'totalmontantpaye'=>$totalmontantpaye];
        
        
    }

    /**
     * @Rest\Post(Path="/create", name="paiement_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request): PaiementFraisEncadrement    {
        $entityManager = $this->getDoctrine()->getManager();
        $redData = Utils::serializeRequestContent($request);
        $methodePaiement = $redData['newPaiement']['methodePaiement'];
        $montantPaye = $redData['newPaiement']['montantPaye'];
        $idinscriptionacad = $redData['idinscriptionacad'];
        
        $inscriptionacad = $this->getDoctrine()
            ->getRepository(\App\Entity\Inscriptionacad::class)
            ->find($idinscriptionacad);
      
        //throw $this->createNotFoundException($montantPaye);
        $paiementFraisEncadrement = new PaiementFraisEncadrement();
        
        $paiementFraisEncadrement->setDatePaiement(new \DateTime());
        $paiementFraisEncadrement->setMontantPaye($montantPaye);
        $paiementFraisEncadrement->setMethodePaiement($methodePaiement);
        $paiementFraisEncadrement->setInscriptionacad($inscriptionacad);
        
        $entityManager->persist($paiementFraisEncadrement);
        $entityManager->flush();

        return $paiementFraisEncadrement;
    }

    /**
     * @Rest\Get(path="/{id}", name="paiement_frais_encadrement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_AFFICHAGE")
     */
    public function show(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        return $paiementFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="paiement_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_EDITION")
     */
    public function edit(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $paiementFraisEncadrement;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="paiement_frais_encadrement_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_CLONE")
     */
    public function cloner(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement):  PaiementFraisEncadrement {
        $em=$this->getDoctrine()->getManager();
        $paiementFraisEncadrementNew=new PaiementFraisEncadrement();
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($paiementFraisEncadrementNew);

        $em->flush();

        return $paiementFraisEncadrementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="paiement_frais_encadrement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_SUPPRESSION")
     */
    public function delete(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paiementFraisEncadrement);
        $entityManager->flush();

        return $paiementFraisEncadrement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="paiement_frais_encadrement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $paiementFraisEncadrements = Utils::getObjectFromRequest($request);
        if (!count($paiementFraisEncadrements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($paiementFraisEncadrements as $paiementFraisEncadrement) {
            $paiementFraisEncadrement = $entityManager->getRepository(PaiementFraisEncadrement::class)->find($paiementFraisEncadrement->id);
            $entityManager->remove($paiementFraisEncadrement);
        }
        $entityManager->flush();

        return $paiementFraisEncadrements;
    }
}
