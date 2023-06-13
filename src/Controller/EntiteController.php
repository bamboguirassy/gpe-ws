<?php

namespace App\Controller;

use App\Entity\Entite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/entite")
 */
class EntiteController extends AbstractController
{
    /**
     * @Rest\Get(path="/", name="entite_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ENTITE_LISTE")
     * @return array
     */
    public function index(): array
    {
        $entites = $this->getDoctrine()
            ->getRepository(Entite::class)
            ->findAll();

        return count($entites) ? $entites : [];
    }
    /**
     * WS pour récuperer les entités dont le parent du parent est null
     * @Rest\Get(path="/etablissement", name="entite_etablissement_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ENTITE_LISTE")
     * @return array
     */
    public function getEtablissements(): array
    {
        $em = $this->getDoctrine()->getManager();
        $entites = $em->createQuery('select e.id as etablissement_id, e.codeentite as code,
         e.libelleentite as nom, te.codetypeentite as code_type,
          te.libelletypeentite as nom_type  from App\Entity\Entite e
           join e.identiteparent univ join e.idtypeentite te
            where univ.identiteparent is null')
            ->getResult();

        return count($entites) ? $entites : [];
    }

    /**
     * @Rest\Get(path="/{id}", name="entite_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ENTITE_AFFICHAGE")
     */
    public function show(Entite $entite): Entite
    {
        return $entite;
    }
}
