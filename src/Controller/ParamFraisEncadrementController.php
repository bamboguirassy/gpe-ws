<?php

namespace App\Controller;

use App\Entity\ParamFraisEncadrement;
use App\Entity\Filiere;
use App\Entity\UserEntite;
use App\Form\ParamFraisEncadrementType;
use App\Repository\ParamFraisEncadrementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\Length;

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
         * @Rest\Get(path="/{id}/user", name="param_frais_encadrement_by_user")
         * @Rest\View(StatusCode = 200)
         *
         */
    public function findByUser(UserEntite $user): array
    {
        $em = $this->getDoctrine()->getManager();
        $paramFraisEncadrements = $em->createQuery('select pfe from App\Entity\ParamFraisEncadrement pfe, App\Entity\UserFiliere uf '
                        . 'where uf.idfiliere=pfe.filiere and uf.iduser=?1')
                ->setParameter(1, $user)
                ->getResult();

        return count($paramFraisEncadrements)?$paramFraisEncadrements:[];
    }

    /**

    *
    * @Rest\Get(path="/{id}/user/filiere", name="user_filiere")
    * @Rest\View(StatusCode = 200)
    * @IsGranted("ROLE_FILIERE_LISTE")
    * @param Request $request
    * @return array
    */
    public function findUserFiliere(UserEntite $user): array
    {
        $em = $this->getDoctrine()->getManager();
      
        $filieresParametre = $em->createQuery('select f from App\Entity\Filiere f, App\Entity\ParamFraisEncadrement pfe where f=pfe.filiere')
        ->getResult();
        $filieres= $em->createQuery('select f from App\Entity\Filiere f, App\Entity\UserFiliere uf '
. 'where uf.idfiliere=f and uf.iduser=?1 and f not in (?2)')
->setParameter(1, $user)
->setParameter(2, $filieresParametre)
->getResult();
        return $filieres;
    }
    /**
     * @Rest\Post(Path="/create", name="param_frais_encadrement_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PARAMFRAISENCADREMENT_NOUVEAU")
     */
    public function create(Request $request): ParamFraisEncadrement
    {
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
    public function ajouterPluisieursParamFraisEncadrement(Request $request)
    {
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
    public function show(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement
    {
        return $paramFraisEncadrement;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="param_frais_encadrement_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function edit(Request $request, ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement
    {
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
    public function cloner(Request $request, ParamFraisEncadrement $paramFraisEncadrement):  ParamFraisEncadrement
    {
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
     */
    public function delete(ParamFraisEncadrement $paramFraisEncadrement): ParamFraisEncadrement
    {
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
    public function deleteMultiple(Request $request): array
    {
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
