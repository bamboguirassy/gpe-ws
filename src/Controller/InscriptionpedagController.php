<?php

namespace App\Controller;

use App\Entity\Inscriptionpedag;
use App\Form\InscriptionpedagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/inscriptionpedag")
 */
class InscriptionpedagController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="inscriptionpedag_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_LISTE")
     */
    public function index(): array {
        $inscriptionpedags = $this->getDoctrine()
                ->getRepository(Inscriptionpedag::class)
                ->findAll();

        return count($inscriptionpedags) ? $inscriptionpedags : [];
    }

    /**
     * @Rest\Post(Path="/create", name="inscriptionpedag_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_NOUVEAU")
     */
    public function create(Request $request): Inscriptionpedag {
        $inscriptionpedag = new Inscriptionpedag();
        $form = $this->createForm(InscriptionpedagType::class, $inscriptionpedag);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($inscriptionpedag);
        $entityManager->flush();

        return $inscriptionpedag;
    }

    /**
     * @Rest\Get(path="/{id}", name="inscriptionpedag_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_AFFICHAGE")
     */
    public function show(Inscriptionpedag $inscriptionpedag): Inscriptionpedag {
        return $inscriptionpedag;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="inscriptionpedag_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_EDITION")
     */
    public function edit(Request $request, Inscriptionpedag $inscriptionpedag): Inscriptionpedag {
        $form = $this->createForm(InscriptionpedagType::class, $inscriptionpedag);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $inscriptionpedag;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="inscriptionpedag_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_CLONE")
     */
    public function cloner(Request $request, Inscriptionpedag $inscriptionpedag): Inscriptionpedag {
        $em = $this->getDoctrine()->getManager();
        $inscriptionpedagNew = new Inscriptionpedag();
        $form = $this->createForm(InscriptionpedagType::class, $inscriptionpedagNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($inscriptionpedagNew);

        $em->flush();

        return $inscriptionpedagNew;
    }

    /**
     * @Rest\Delete("/{id}", name="inscriptionpedag_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_SUPPRESSION")
     */
    public function delete(Inscriptionpedag $inscriptionpedag): Inscriptionpedag {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($inscriptionpedag);
        $entityManager->flush();

        return $inscriptionpedag;
    }

    /**
     * @Rest\Post("/delete-selection/", name="inscriptionpedag_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_INSCRIPTIONPEDAG_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $inscriptionpedags = Utils::getObjectFromRequest($request);
        if (!count($inscriptionpedags)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($inscriptionpedags as $inscriptionpedag) {
            $inscriptionpedag = $entityManager->getRepository(Inscriptionpedag::class)->find($inscriptionpedag->id);
            $entityManager->remove($inscriptionpedag);
        }
        $entityManager->flush();

        return $inscriptionpedags;
    }

    /**
     * Trouver les inscriptions pedagogiques par l'inscription acad.
     *
     * @Rest\Get("/inscriptionacad/{id}",options={"expose":true}, name="inscriptionpedag_by_inscriptionacad")
     * @Rest\View(StatusCode=200)
     */
    public function findByInscriptionacadAction(\App\Entity\Inscriptionacad $inscriptionacad) {
        // @IsGranted("ROLE_INSCRIPTIONPEDAG_LISTE")
        $em = $this->getDoctrine()->getManager();
        //semestres de l'ue
        $semestreActuels = $em->getRepository('App\Entity\Semestre')->findByIdniveau($inscriptionacad->getIdclasse()->getIdniveau());
        $semestre_data = [];
        foreach ($semestreActuels as $semestre) {
            $inspedags = $em->createQuery('select ip from App\Entity\Inscriptionpedag ip,'
                            . 'App\Entity\Ue ue where ip.idue=ue and ip.idinscriptionacad=?1 '
                            . 'and ue.idsemestre=?2 ')
                    ->setParameter(1, $inscriptionacad)
                    ->setParameter(2, $semestre)
                    ->getResult();
            $inspedag_data = [];
            foreach ($inspedags as $inspedag) {
                $ueanneeacad = $em->getRepository('App\Entity\Ueanneeacad')
                        ->findOneBy(['idue' => $inspedag->getIdue(), 'idanneeacad' => $inspedag->getIdanneeacad()]);
                $inspedag_data[] = ['inspedag' => $inspedag, 'ueanneeacad' => $ueanneeacad];
            }
            $semestre_data[] = ['semestre' => $semestre, 'inscriptionpedagData' => $inspedag_data];
        }
        // find ue anterieurement non validée
        $inspedagAnterieurs = $em->createQuery('select ip from App\Entity\Inscriptionpedag ip,'
                        . 'App\Entity\Ue ue where ip.idue=ue and ip.idinscriptionacad=?1 '
                        . 'and ue.idsemestre not in (?2) ')
                ->setParameter(1, $inscriptionacad)
                ->setParameter(2, $semestreActuels)
                ->getResult();
        $inspedagAnterieurData = [];
        foreach ($inspedagAnterieurs as $inspedagAnterieur) {
            $ueanneeacad = $em->getRepository('App\Entity\Ueanneeacad')
                    ->findOneBy(['idue' => $inspedag->getIdue(), 'idanneeacad' => $inspedag->getIdanneeacad()]);
            $inspedagAnterieurData[] = ['inspedag' => $inspedagAnterieur, 'ueanneeacad' => $ueanneeacad];
        }

        $nombreUeNiveauValide = $em->createQuery('select count(ip) from App\Entity\Inscriptionpedag ip,'
                        . 'App\Entity\Ue ue where ip.idue=ue and ip.idinscriptionacad=?1 '
                        . 'and ue.idsemestre in (?2) and ip.valide=?3 ')
                ->setParameter(1, $inscriptionacad)
                ->setParameter(2, $semestreActuels)
                ->setParameter(3, 1)
                ->getSingleScalarResult();
        $nombreUeAnterieurValide = $em->createQuery('select count(ip) from App\Entity\Inscriptionpedag ip,'
                        . 'App\Entity\Ue ue where ip.idue=ue and ip.idinscriptionacad=?1 '
                        . 'and ue.idsemestre not in (?2) and ip.valide=?3 ')
                ->setParameter(1, $inscriptionacad)
                ->setParameter(2, $semestreActuels)
                ->setParameter(3, 1)
                ->getSingleScalarResult();
        $nombreUeInscrit = $em->createQuery('select count(ip) from App\Entity\Inscriptionpedag ip,'
                        . 'App\Entity\Ue ue where ip.idue=ue and ip.idinscriptionacad=?1')
                ->setParameter(1, $inscriptionacad)
                ->getSingleScalarResult();


        return [
            'semestreData' => $semestre_data,
            'inscriptionacad' => $inscriptionacad,
            'inspedagAnterieurs' => $inspedagAnterieurData,
            'nombreUeNiveauValide' => $nombreUeNiveauValide,
            'nombreUeAnterieurValide' => $nombreUeAnterieurValide,
            'nombreUeInscrit' => $nombreUeInscrit
        ];
    }

}
