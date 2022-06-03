<?php

namespace App\Controller;

use App\Entity\Preinscription;
use App\Entity\Etudiant;
use App\Entity\Anneeacad;
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
                ->findBy(['cni' => $etudiant->getCni(),
            'estinscrit' => false]);
        $tabPreinscription = [];
        $dateDuJour = new \DateTime();
        $dateDuJourString = date_format($dateDuJour, 'Y-m-d');
        foreach ($preinscriptions as $preinscription) {
            $active = ($preinscription->getDatenotif() <= $dateDuJour && $preinscription->getDatedelai() >= date('Y-m-d', strtotime($dateDuJourString. ' + 1 days')));
            $tabPreinscription[] = ['active' => $active, 'preinscription' => $preinscription];
        }

        return count($tabPreinscription) ? $tabPreinscription : [];
    }

    /**
     * @Rest\Get(path="/public/request-etudiant-creation/{cni}", name="request_etudiant_creation", requirements={"cni"=".+"})
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
            throw $this->createNotFoundException("Nous n'avons pas pu vous authentifier,"
                    . " si vous pensez qu’il s’agit d’une erreur,"
                    . " écrire un mail à dsos@univ-thies.sn en"
                    . " précisant dans le mail votre INE et votre filière.");
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
     * @Rest\Get(path="/public/verifier-inscription-etudiant-active/{cni}", name="verifier-inscription-etudiant-active", requirements={"cni"=".+"})
     * @Rest\View(StatusCode = 200)
     */
    public function verifierInscriptionEtudiantActif($cni) {
        $isInscriptionActive = false;
        $em = $this->getDoctrine()->getManager();
        $preinscriptionActifs = $em
                ->createQuery('select p from App\Entity\Preinscription p '
                        . 'where p.datenotif<=?1 and p.datedelai>=?2 '
                        . 'and p.cni=?3')
                ->setParameter(1, new \DateTime())
                ->setParameter(2, new \DateTime())
                ->setParameter(3, $cni)
                ->getResult();
        $inscriptionEnInstances = $em->createQuery('select ia from App\Entity\Inscriptionacad ia join ia.idetudiant et ' 
                . 'where et.cni=?1 and ia.etat=?2')
                ->setParameter(1, $cni)
                ->setParameter(2, 'I')
                ->getResult();
        //throw $this->createAccessDeniedException("PreActif ".$preinscriptionActifs[0].getDatenotif());
        if (count($preinscriptionActifs) || count($inscriptionEnInstances)) {
            $isInscriptionActive = true;
        }
        return $isInscriptionActive;
    }
    
    /**
     * @Rest\Post(path="/for/filter/anneeacad/{id}", name="preinscription_for_filter", requirements={"id"="\d+"})
     * @Rest\View(StatusCode = 200, serializerEnableMaxDepthChecks=true)
     */
    public function findForFilterAction(Request $request, Anneeacad $anneeacad) {
        ini_set('memory_limit', '512M');
        $em = $this->getDoctrine()->getManager();
        $redData = Utils::serializeRequestContent($request);
        $estInscrit = $redData['estInscrit'];
        $etablissement = $redData['etablissement'];        
        $filiere = $redData['filiere'];
        $niveau = $redData['niveau'];
        if($estInscrit==2){            
            if(isset($filiere) && isset($niveau)){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idfiliere=?1 and p.idanneeacad=?2 and p.idniveau=?3')
                        ->setParameter(1, $filiere)
                        ->setParameter(2, $anneeacad)
                        ->setParameter(3, $niveau)
                        ->getResult();

                    return $preinscriptions;
            }
            if(isset($filiere) && $niveau == NULL ){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idfiliere=?1 and p.idanneeacad=?2')
                        ->setParameter(1, $filiere)
                        ->setParameter(2, $anneeacad)
                        ->getResult();

                    return $preinscriptions;
            }
            if(isset($etablissement) && (!isset($filiere) || $filiere == NULL) ){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'JOIN p.idfiliere f '
                                . 'where f.identite=?1 and p.idanneeacad=?2')
                        ->setParameter(1, $etablissement)
                        ->setParameter(2, $anneeacad)
                        ->getResult();

                    return $preinscriptions;
            }
            if(!isset($etablissement) || $etablissement == NULL){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idanneeacad=?1')
                        ->setParameter(1, $anneeacad)
                        ->getResult();

                    return $preinscriptions;
            }
        }
           else {
            if(isset($filiere) && isset($niveau)){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idfiliere=?1 and p.idanneeacad=?2 and p.idniveau=?3 and p.estinscrit=?4')
                        ->setParameter(1, $filiere)
                        ->setParameter(2, $anneeacad)
                        ->setParameter(3, $niveau)
                        ->setParameter(4, $estInscrit)
                        ->getResult();

                    return $preinscriptions;
            }
            if(isset($filiere) && $niveau == NULL ){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idfiliere=?1 and p.idanneeacad=?2 and p.estinscrit=?3')
                        ->setParameter(1, $filiere)
                        ->setParameter(2, $anneeacad)
                        ->setParameter(3, $estInscrit)
                        ->getResult();

                    return $preinscriptions;
            }
            if(isset($etablissement) && (!isset($filiere) || $filiere == NULL) ){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'JOIN p.idfiliere f '
                                . 'where f.identite=?1 and p.idanneeacad=?2 and p.estinscrit=?3')
                        ->setParameter(1, $etablissement)
                        ->setParameter(2, $anneeacad)
                        ->setParameter(3, $estInscrit)
                        ->getResult();

                    return $preinscriptions;
            }
            if(!isset($etablissement) || $etablissement == NULL){                
                $preinscriptions = $em->createQuery('select p from App\Entity\Preinscription p '
                                . 'where p.idanneeacad=?1 and p.estinscrit=?2')
                        ->setParameter(1, $anneeacad)
                        ->setParameter(2, $estInscrit)
                        ->getResult();

                    return $preinscriptions;
            }
        }

        return;
        
    }

}
