<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\FosUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Description of PublicController
 *
 * @author bambo
 *
 * @Route("/api/public")
 */
class PublicController extends AbstractController {

    /**
     * @Rest\Post(Path="/register-etudiant", name="fos_user_register_etudiant")
     * @Rest\View(StatusCode=200)
     */
    public function createEtudiantAccount(\Symfony\Component\HttpFoundation\Request $request, \Swift_Mailer $mailer, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder): FosUser {
        $em = $this->getDoctrine()->getManager();
        $reqData = \App\Utils\Utils::getObjectFromRequest($request);
        if (!isset($reqData->identifiant)) {
            throw $this->createNotFoundException("Numéro de dossier est obligatoire");
        }
        $identifiant = $reqData->identifiant;
        //trouver l'étudiant
        $etudiants = $em->createQuery('select et from App\Entity\Etudiant et '
                        . 'where et.numinterne=?1')
                ->setParameter(1, $identifiant)
                ->getResult();
        if (!count($etudiants)) {
            throw $this->createNotFoundException("Le numéro de dossier saisi est incorrect, merci de vérifier.");
        }
        $etudiant = $etudiants[0];

        //check if the email is already associated to an account
        $linkedEmailAccount = $em->getRepository(FosUser::class)->findByEmail($etudiant->getEmail());
        if ($linkedEmailAccount) {
            throw $this->createAccessDeniedException("Vous avez déja un compte, merci de vous connecter.");
        }

        if (!isset($reqData->password)) {
            throw $this->createNotFoundException("Le mot de passe est obligatoire");
        }

        //create User
        $user = new FosUser();
        $password = $passwordEncoder->encodePassword($user, $reqData->password);
        $user->setPassword($password);
        $user->setPrenom($etudiant->getPrenometudiant());
        $user->setNom($etudiant->getNometudiant());
        $user->setEmail($etudiant->getEmail());
        $user->setEnabled(false);
        $user->setUsername($etudiant->getEmail());
        $user->setSexe($etudiant->getGenre());
        $user->setTitre('Etudiant');
        $groupEtudiant = $em->getRepository(\App\Entity\FosGroup::class)->findOneByCodegroupe('ETU');
        if (!$groupEtudiant) {
            throw $this->createNotFoundException("Le groupe étudiant est introuvable");
        }
        $user->setIdgroup($groupEtudiant);
        $profilEtudiant = $em->getRepository(\App\Entity\Profil::class)->findOneByCodeprofil('ETU');
        if (!$profilEtudiant) {
            throw $this->createNotFoundException("Le profil étudiant est introuvable");
        }
        $user->setProfession($profilEtudiant);

        $em->persist($user);
       // $em->flush();
        //send confirmation mail
        $message = (new \Swift_Message('Confirmation de compte'))
                ->setFrom(\App\Utils\Utils::$senderEmail)
                ->setTo($etudiant->getEmail())
                ->setBody(
                $this->renderView(
                        'emails/registrations/etudiant.html.twig', ['user' => $user, 'link' => \App\Utils\Utils::$lienValidationCompteEtudiant . $user->getId()]
                ), 'text/html'
        );
      //  $mailer->send($message);

        return $user;
    }

    /**
     * @Rest\get(Path="/registration-confirmation/{id}", name="fos_user_confirm_account")
     * @Rest\View(StatusCode=200)
     */
    public function confirmAccount(FosUser $user): FosUser {
        $em = $this->getDoctrine()->getManager();
        if ($user->isEnabled()) {
            throw $this->createAccessDeniedException("Ce compte est déja actif");
        }
        $user->setEnabled(true);
        $em->flush();

        return $user;
    }

    /**
     * @Rest\Post(Path="/change-mail", name="fos_user_email_change_etudiant")
     * @Rest\View(StatusCode=200)
     */
    public function handleMailChange(\Symfony\Component\HttpFoundation\Request $request, \Swift_Mailer $mailer, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder): FosUser {
        $em = $this->getDoctrine()->getManager();
        $reqData = \App\Utils\Utils::getObjectFromRequest($request);
        if (!isset($reqData->idInscription)) {
            throw $this->createNotFoundException("Numero Inscription obligatoire");
        }
        $idInscription = $reqData->idInscription;

        if (!isset($reqData->idAnnee)) {
            throw $this->createNotFoundException("Derniere d'inscription non selectionnée");
        }
        $idAnnee = $reqData->idAnnee;

        if (!isset($reqData->email)) {
            throw $this->createNotFoundException("Email de remplacement introuvale...");
        }
        $email = $reqData->email;
        // verifier l'id de l'inscription acad correspondant
        $inscriptionacad = $em->getRepository(\App\Entity\Inscriptionacad::class)->find($idInscription);
        if (!$inscriptionacad) {
            throw $this->createNotFoundException("Numero Inscription invalide");
        }
        //verifier la derniere inscription
        $derniereInscription = $em->getRepository(\App\Entity\Inscriptionacad::class)
                ->findOneByIdetudiant($inscriptionacad->getIdetudiant(), ['id' => 'desc']);
        if ($derniereInscription->getId() != $idInscription || $derniereInscription->getIdclasse()->getIdanneeacad()->getId() != $idAnnee) {
            throw $this->createAccessDeniedException("Numero inscription et/ou année invalide");
        }
        // verfieir si un compte n'est pas rattaché au mail donnée
        $linkedEmailAccount = $em->getRepository(FosUser::class)->findByEmail($email);
        if ($linkedEmailAccount) {
            throw $this->createAccessDeniedException("Ce mail est déja associé à un autre compte,"
                    . " merci de vous connecter ou de proposer une autre adresse email.");
        }
        //trouver l'étudiant
        $etudiant = $inscriptionacad->getIdetudiant();
        //check if the email is already associated to an account
        $etudiantAccount = $em->getRepository(FosUser::class)->findByEmail($etudiant->getEmail());
        if ($etudiantAccount) {
            if ($etudiantAccount[0]->isEnabled()) {
                throw $this->createAccessDeniedException("Vous avez déja un compte, merci de vous connecter.");
            }
        } else {
            throw $this->createAccessDeniedException("Vous devriez d'abord créer un compte pour pouvoir accèder à cette interface...");
        }

        //create User
        $user = $em->getRepository(FosUser::class)->findOneByEmail($etudiant->getEmail());
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setEmailCanonical($email);
        $user->setUsernameCanonical($email);
        $inscriptionacad->getIdetudiant()->setEmail($email);
        $em->flush();
        //send confirmation mail
        $message = (new \Swift_Message('Confirmation de compte'))
                ->setFrom(\App\Utils\Utils::$senderEmail)
                ->setTo($etudiant->getEmail())
                ->setBody(
                $this->renderView(
                        'emails/registrations/etudiant.html.twig', ['user' => $user, 'link' => \App\Utils\Utils::$lienValidationCompteEtudiant . $user->getId()]
                ), 'text/html'
        );
        $mailer->send($message);

        return $user;
    }

}
