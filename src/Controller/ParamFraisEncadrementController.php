<?php

namespace App\Controller;

use App\Entity\ParamFraisEncadrement;
use App\Entity\Filiere;
use App\Form\ParamFraisEncadrementType;
use App\Repository\ParamFraisEncadrementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/paramfraisencadrement")
 */
class ParamFraisEncadrementController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="param_frais_encadrement_index")
     * @Rest\View(StatusCode = 200)
     * 
     */
    public function index(): array
    {
        $paramFraisEncadrement = $this->getDoctrine()
            ->getRepository(ParamFraisEncadrement::class)
            ->findAll();
      
        return count($paramFraisEncadrement)?$paramFraisEncadrement:[];
    }

    /**
     * @Rest\Post(Path="/create", name="param_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_NOUVEAU")
     */
    public function create(Request $request): ParamFraisEncadrement    {
        $paramFraisEncadrement = new ParamFraisEncadrement();
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paramFraisEncadrement);
        $entityManager->flush();

        return $paramFraisEncadrement;
    }
    
     /**
     * @Rest\Post(Path="/all-param-frais-encadrement-create", name="create_pluisieurs_param_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     *
     */
     public function ajouterPluisieursParamFraisEncadrement(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $redData = Utils::serializeRequestContent($request);
        $params = $redData['paramFraisEncadrements'];
        //throw $this->createNotFoundException($params[0]['filiere']['id']);
        foreach ($params as $ligneparamfraisencadrement) {
            $paramFraisEncadrement = new ParamFraisEncadrement();
            $filiere = $entityManager->getRepository(Filiere::class)->find($ligneparamfraisencadrement['filiere']['id']);
            $paramFraisEncadrement->setFiliere($filiere);
            $paramFraisEncadrement->setFraisAnnuel($ligneparamfraisencadrement['fraisAnnuel']);
            $entityManager->persist($paramFraisEncadrement);
        }
        $entityManager->flush();
        return ;
     }

    /**
     * @Rest\Get(path="/{id}", name="param_frais_encadrement_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * 
     */
    public function show(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        return $paramFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="param_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrement);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $paramFraisEncadrement;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="param_frais_encadrement_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_CLONE")
     */
    public function cloner(Request $request, ParamFraisEncadrement $paramFraisEncadrement):  ParamFraisEncadrement {
        $em=$this->getDoctrine()->getManager();
        $paramFraisEncadrementNew=new ParamFraisEncadrement();
        $form = $this->createForm(ParamFraisEncadrementType::class, $paramFraisEncadrementNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($paramFraisEncadrementNew);

        $em->flush();

        return $paramFraisEncadrementNew;
    }

    /**
     * @Rest\Delete("/{id}", name="param_frais_encadrement_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_SUPPRESSION")
     */
    public function delete(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paramFraisEncadrement);
        $entityManager->flush();

        return $paramFraisEncadrement;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="param_frais_encadrement_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $paramFraisEncadrements = Utils::getObjectFromRequest($request);
        if (!count($paramFraisEncadrements)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($paramFraisEncadrements as $paramFraisEncadrement) {
            $paramFraisEncadrement = $entityManager->getRepository(ParamFraisEncadrement::class)->find($paramFraisEncadrement->id);
            $entityManager->remove($paramFraisEncadrement);
        }
        $entityManager->flush();

        return $paramFraisEncadrements;
    }
}
