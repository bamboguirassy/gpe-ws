<?php

namespace App\Controller;

use App\Entity\Anneeacad;
use App\Entity\Classe;
use App\Entity\Filiere;
use App\Entity\Niveau;
use App\Utils\FileUploader;
use App\Entity\PaiementFraisEncadrement;
use App\Form\PaiementFraisEncadrementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/paiementfraisencadrement")
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
    public function findByInscriptionacad(\App\Entity\Inscriptionacad $inscriptionacad)
    {
        $em = $this->getDoctrine()->getManager();
        $paiementfraisencadrements = $em->getRepository(PaiementFraisEncadrement::class)
                ->findBy(['inscriptionacad' => $inscriptionacad]);
        $paramfraisencadrement = $em->getRepository(\App\Entity\ParamFraisEncadrement::class)
                ->findBy(['filiere'=>$inscriptionacad->getIdclasse()->getIdfiliere()]);
        
        $totalmontantpaye = 0;
        
        foreach ($paiementfraisencadrements as $paiementfraisencadrement) {
            $totalmontantpaye = $totalmontantpaye + $paiementfraisencadrement->getMontantPaye();
        }
        
        return ['paiementfraisencadrements'=>count($paiementfraisencadrements)?$paiementfraisencadrements:[],
         'totalmontantpaye'=>$totalmontantpaye, 'inscriptionacad'=>$inscriptionacad];
    }

    /**
     * @Rest\Post(path="/paiementetudiants/", name="paiements_etudiants")
     * @Rest\View(StatusCode = 200)
     */
    public function findByClasse(Request $request):array
    {
        $em = $this->getDoctrine()->getManager();
        $redData = Utils::serializeRequestContent($request);
        $idanneAcad = $redData['idanneeacad'];
        $idfiliere = $redData['idfiliere'];
        $idniveau = $redData['idniveau'];
        $tab=[];
        //reccuperation de la classe
        $classe = $em->getRepository(Classe::class)
         ->findOneBy(['idfiliere' => $idfiliere, 'idniveau' => $idniveau, 'idanneeacad' => $idanneAcad]);
        if (!$classe) {
            throw $this->createNotFoundException("Classe introuvable pour la preinscription selectionnée");
        }
        //reccuperation des inscriptionAcads des etudiants privés de la classe
        $inscriptionAcads = $em->createQuery("select ia from App\Entity\Inscriptionacad ia, "
                        . "App\Entity\Regimeinscription ri where ia.idclasse=?1 and ia.idregimeinscription=ri and (ri.coderegimeinscription=?2 or ri.coderegimeinscription=?3)")
                ->setParameter(1, $classe)
                ->setParameter(2, 'RNP')
                ->setParameter(3, 'RPP')
                ->getResult();
        //calcul du montant total payé pour chaque etudiant
        $montantAPaye= $em->createQuery("select pfe.fraisAnnuel from App\Entity\ParamFraisEncadrement pfe "
        . " where pfe.filiere=?1")
        ->setParameter(1, $idfiliere)
        ->getSingleScalarResult();
        $totalMontantPaye=0;
        $resteAPaye=0;
        foreach ($inscriptionAcads as $inscriptionAcad) {
            $somme= $em->createQuery("select sum(pfe.montantPaye) from App\Entity\PaiementFraisEncadrement pfe "
               . " where pfe.inscriptionacad=?1")
               ->setParameter(1, $inscriptionAcad)
               ->getSingleScalarResult();
            if ($somme) {
                $totalMontantPaye=$somme;
            }else {
                $totalMontantPaye=0;
            }
            $resteAPaye=$montantAPaye - $somme;
            $tab[]= ["inscriptionacad"=>$inscriptionAcad, "totalmontantpaye"=>$totalMontantPaye,"resteAPaye"=>$resteAPaye];
        }
        
        return $tab;
    }
    
    /**
     * @Rest\Post(Path="/create", name="paiement_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     */
    public function create(Request $request, FileUploader $uploader, EntityManagerInterface $entityManager): PaiementFraisEncadrement
    {
        $paiementFraisEncadrement = new PaiementFraisEncadrement();
        $httpHost = $request->getHttpHost();
        $protocolVersion = $request->getScheme();
        $data = Utils::getObjectFromRequest($request);
        $idmethodePaiement = $data->methodePaiement;
        $montantPaye = $data->montantPaye;
        $idinscriptionacad = $data->idinscriptionacad;
        
        $deserializedDocument = Utils::getObjectFromRequest($request);
        $newFilename = $uploader->decodeAndUploadTo($deserializedDocument, $this->getParameter('document_paiementfraisencadrement_directory'));
        $inscriptionacad = $entityManager
            ->getRepository(\App\Entity\Inscriptionacad::class)
            ->find($idinscriptionacad);
        $methodePaiement = $entityManager
            ->getRepository(\App\Entity\Modepaiement::class)
            ->find($idmethodePaiement);
        
        $paiementFraisEncadrement
            ->setFilename($newFilename)
            ->setDatePaiement(new \DateTime())
            ->setMontantPaye($montantPaye)
            ->setMethodePaiement($methodePaiement)
            ->setInscriptionacad($inscriptionacad);
        
        $paiementFraisEncadrement
            ->setUrl($protocolVersion . '://' . $httpHost . '/' . $this->getParameter('document_paiementfraisencadrement_directory') . $paiementFraisEncadrement->getFilename());
        
        $entityManager->persist($paiementFraisEncadrement);
        $entityManager->flush();

        return $paiementFraisEncadrement;
    }

    /**
     * @Rest\Get(path="/{id}", name="paiement_frais_encadrement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_AFFICHAGE")
     */
    public function show(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement
    {
        return $paiementFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="paiement_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PAIEMENTFRAISENCADREMENT_EDITION")
     */
    public function edit(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement
    {
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
    public function cloner(Request $request, PaiementFraisEncadrement $paiementFraisEncadrement):  PaiementFraisEncadrement
    {
        $em=$this->getDoctrine()->getManager();
        $paiementFraisEncadrementNew = new PaiementFraisEncadrement();
        $form = $this->createForm(PaiementFraisEncadrementType::class, $paiementFraisEncadrementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($paiementFraisEncadrementNew);

        $em->flush();

        return $paiementFraisEncadrementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="paiement_frais_encadrement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function delete(PaiementFraisEncadrement $paiementFraisEncadrement): PaiementFraisEncadrement
    {
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
    public function deleteMultiple(Request $request): array
    {
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
