<?php

namespace App\Controller;

use App\Entity\Preinscription;
use App\Entity\Etudiant;
use App\Form\PreinscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/preinscription")
 */
class PreinscriptionController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="preinscription_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_PREINSCRIPTION_LISTE")
     */
    public function index(): array {
        $preinscriptions = $this->getDoctrine()
                ->getRepository(Preinscription::class)
                ->findAll();

        return count($preinscriptions) ? $preinscriptions : [];
    }

    /**
     * @Rest\Get(path="/active/{id}/etudiant", name="preinscription_active_etudiant")
     * @Rest\View(StatusCode = 200)
     */
    public function findActivePreinscriptionByEtudiant(Etudiant $etudiant): array {
        $preinscriptions = $this->getDoctrine()->getManager()
                ->getRepository(Preinscription::class)
                ->findBy(['cni'=>$etudiant->getCni(),
                    'estinscrit'=>false]);
        $tabPreinscription = [];
        $dateDuJour = new \DateTime();
        foreach ($preinscriptions as $preinscription) {
            $active = ($preinscription->getDatenotif()<=$dateDuJour && $preinscription->getDatedelai()>=$dateDuJour);
            $tabPreinscription[] = ['active'=>$active,'preinscription'=>$preinscription];
        }

        return count($tabPreinscription) ? $tabPreinscription : [];
    }

    /**
     * @Rest\Get(path="/public/request-etudiant-creation/{cni}", name="request_etudiant_creation")
     * @Rest\View(StatusCode = 200)
     */
    public function requestNewEtudiantCreation($cni) {
        $em = $this->getDoctrine()->getManager();
        $preinscriptionActifs = $em
                ->createQuery('select p from App\Entity\Preinscription p '
                        . 'where p.datenotif<=?1 and p.datedelai>=?2 '
                        . 'and p.cni=?3 and p.estinscrit=?4')
                ->setParameter(1, new \DateTime())
                ->setParameter(2, new \DateTime())
                ->setParameter(3, $cni)
                ->setParameter(4, false)
                ->getResult();
        if (!count($preinscriptionActifs)) {
            // si aucune préinscription actif, vérifier si l'étudiant a une préinscription en suspens
            $preinscriptionInactifs = $em
                    ->createQuery('select p from App\Entity\Preinscription p '
                            . 'where p.cni=?3 and p.estinscrit=?4')
                    ->setParameter(3, $cni)
                    ->setParameter(4, false)
                    ->getResult();
            if (count($preinscriptionInactifs)) {
                throw $this->createAccessDeniedException("Votre campagne d'inscription n'est pas encore ouverte, merci de patienter !");
            }
            throw $this->createNotFoundException("Nous n'avons pas pu vous authentifier, si vous pensez qu'il s'agit d'une erreur,"
                    . " merci de vous rapprocher de la DSOS de l'université de Thiès.");
        }
        $etudiants = $em->getRepository('App\Entity\Etudiant')
                ->findByCni($cni);

        if (count($etudiants)) {
            // verifier si l'étudiant a une inscription acad active
            $inscriptionacads = $em->getRepository("App\Entity\Inscriptionacad")
                    ->findByIdetudiant($etudiants[0]);
            if (count($inscriptionacads)) {
                throw $this->createAccessDeniedException("Vous êtes déja étudiant à l'université de Thiès,"
                        . " cette interface est réservée aux étudiants qui viennent juste d'être admis"
                        . " à l'université de Thiès, merci de vous rapprocher de la DSOS si vous pensez"
                        . " qu'il s'agit d'une erreur.");
            }
            return ['code' => 'etudiant', 'etudiant' => $etudiants[0]];
        }


        return ['code' => 'preinscription', 'preinscription' => $preinscriptionActifs[0]];
    }

    /**
     * @Rest\Post(Path="/create", name="preinscription_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PREINSCRIPTION_NOUVEAU")
     */
    public function create(Request $request): Preinscription {
        $preinscription = new Preinscription();
        $form = $this->createForm(PreinscriptionType::class, $preinscription);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($preinscription);
        $entityManager->flush();

        return $preinscription;
    }

    /**
     * @Rest\Get(path="/public/{id}", name="preinscription_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function show(Preinscription $preinscription): Preinscription {
        return $preinscription;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="preinscription_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PREINSCRIPTION_EDITION")
     */
    public function edit(Request $request, Preinscription $preinscription): Preinscription {
        $form = $this->createForm(PreinscriptionType::class, $preinscription);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $preinscription;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="preinscription_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PREINSCRIPTION_CLONE")
     */
    public function cloner(Request $request, Preinscription $preinscription): Preinscription {
        $em = $this->getDoctrine()->getManager();
        $preinscriptionNew = new Preinscription();
        $form = $this->createForm(PreinscriptionType::class, $preinscriptionNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($preinscriptionNew);

        $em->flush();

        return $preinscriptionNew;
    }

    /**
     * @Rest\Delete("/{id}", name="preinscription_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PREINSCRIPTION_DELETE")
     */
    public function delete(Preinscription $preinscription): Preinscription {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($preinscription);
        $entityManager->flush();

        return $preinscription;
    }

    /**
     * @Rest\Post("/delete-selection/", name="preinscription_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_PREINSCRIPTION_DELETE")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $preinscriptions = Utils::getObjectFromRequest($request);
        if (!count($preinscriptions)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($preinscriptions as $preinscription) {
            $preinscription = $entityManager->getRepository(Preinscription::class)->find($preinscription->id);
            $entityManager->remove($preinscription);
        }
        $entityManager->flush();

        return $preinscriptions;
    }
    
    /**
     * @Rest\Get(path="/public/verifier-inscription-etudiant-active/{cni}", name="verifier-inscription-etudiant-active")
     * @Rest\View(StatusCode = 200)
     */
    public function verifierInscriptionEtudiantActif($cni) {
        $isInscriptionActive = false;
        $em = $this->getDoctrine()->getManager();
        $preinscriptionActifs = $em
                ->createQuery('select p from App\Entity\Preinscription p '
                        . 'where p.datenotif<=?1 and p.datedelai>=?2 '
                        . 'and p.cni=?3 and p.estinscrit=?4')
                ->setParameter(1, new \DateTime())
                ->setParameter(2, new \DateTime())
                ->setParameter(3, $cni)
                ->setParameter(4, false)
                ->getResult();
        
        if(count($preinscriptionActifs)){
            $isInscriptionActive = true;
        }
        return  $isInscriptionActive; 
    }

}
