<?php

namespace App\Controller;

use App\Entity\InscriptionTemporaire;
use App\Form\InscriptionTemporaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/inscriptiontemporaire")
 */
class InscriptionTemporaireController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="inscription_temporaire_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_LISTE")
     */
    public function index(): array
    {
        $inscriptionTemporaires = $this->getDoctrine()
            ->getRepository(InscriptionTemporaire::class)
            ->findAll();

        return count($inscriptionTemporaires)?$inscriptionTemporaires:[];
    }

    /**
     * @Rest\Post(Path="/create", name="inscription_temporaire_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_NOUVEAU")
     */
    public function create(Request $request): InscriptionTemporaire    {
        $inscriptionTemporaire = new InscriptionTemporaire();
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaire);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($inscriptionTemporaire);
        $entityManager->flush();

        return $inscriptionTemporaire;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscription_temporaire_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_AFFICHAGE")
     */
    public function show(InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        return $inscriptionTemporaire;
    }

    
    /**
     * @Rest\Put(path="/{id}/edit", name="inscription_temporaire_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_EDITION")
     */
    public function edit(Request $request, InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaire);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionTemporaire;
    }
    
    /**
     * @Rest\Put(path="/{id}/clone", name="inscription_temporaire_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_CLONE")
     */
    public function cloner(Request $request, InscriptionTemporaire $inscriptionTemporaire):  InscriptionTemporaire {
        $em=$this->getDoctrine()->getManager();
        $inscriptionTemporaireNew=new InscriptionTemporaire();
        $form = $this->createForm(InscriptionTemporaireType::class, $inscriptionTemporaireNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionTemporaireNew);

        $em->flush();

        return $inscriptionTemporaireNew;
    }

    /**
     * @Rest\Delete("/{id}", name="inscription_temporaire_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_SUPPRESSION")
     */
    public function delete(InscriptionTemporaire $inscriptionTemporaire): InscriptionTemporaire    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($inscriptionTemporaire);
        $entityManager->flush();

        return $inscriptionTemporaire;
    }
    
    /**
     * @Rest\Post("/delete-selection/", name="inscription_temporaire_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONTEMPORAIRE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $inscriptionTemporaires = Utils::getObjectFromRequest($request);
        if (!count($inscriptionTemporaires)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($inscriptionTemporaires as $inscriptionTemporaire) {
            $inscriptionTemporaire = $entityManager->getRepository(InscriptionTemporaire::class)->find($inscriptionTemporaire->id);
            $entityManager->remove($inscriptionTemporaire);
        }
        $entityManager->flush();

        return $inscriptionTemporaires;
    }
}
