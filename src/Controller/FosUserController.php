<?php

namespace App\Controller;

use App\Entity\FosUser;
use App\Form\FosUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/fos_user")
 */
class FosUserController extends AbstractController
{

    /**
     * @Rest\Get(path="/", name="fos_user_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_FOSUSER_LISTE")
     */
    public function index(): array
    {
        $fosUsers = $this->getDoctrine()
            ->getRepository(FosUser::class)
            ->findAll();

        return count($fosUsers) ? $fosUsers : [];
    }

    /**
     * @Rest\Get(path="/public/check-user-existence-admission/{email}", name="fos_user_check_existence_admission")
     * @Rest\View(StatusCode = 200)
     */
    public function checkUserExistenceForAdmission($email)
    {
        $fosUser = $this->getDoctrine()
            ->getRepository(FosUser::class)
            ->findOneByEmail($email);
        if (!$fosUser) {
            throw $this->createNotFoundException("Le mail indiqué ne correspond à aucun utilisateur.");
        }
        if (!$fosUser->getAdmission()) {
            throw $this->createNotFoundException("Cet utilisateur n'est pas habilité à acceder à la plateforme admission, merci de contacter votre administrateur.");
        }

        return $fosUser;
    }

    /**
     * @Rest\Get(path="/public/validate/{email}", name="fos_user_validate_account_by_email")
     * @Rest\View(statusCode = 200)
     * @param Request $request
     * @param $email
     * @return FosUser
     */
    public function validateUserByEmail(Request $request, $email)
    {
        /** @var FosUser $user */
        $user = $this->getDoctrine()
            ->getRepository(FosUser::class)
            ->findOneBy(compact('email'));

        if(!$user) throw new BadRequestHttpException("Cette adresse e-mail n'est associé à aucun compte.");

        if (!$user->isEnabled()) throw new BadRequestHttpException("Votre compte n'est pas encore actif");

        if (!in_array($user->getIdgroup()->getCodegroupe(),['ADMIN', 'ETU', 'DSOS','SA','ADSOS','ADMIN_DSOS','MEDECIN'])) throw new BadRequestHttpException("Vous n'êtes pas autorisé à vous connecter à la plateforme");

        return $user;
    }

    /**
     * @Rest\Post(path="/public/reset-password/", name="user_password_reset")
     * @Rest\View(StatusCode=200)
     */
    public function resetPassword(Request $request, \Swift_Mailer $mailer): bool
    {
        $email = $request->getContent();
        if (!$email) {
            throw $this->createNotFoundException("Adresse email introuvable");
        }
        $em = $this->getDoctrine()->getManager();
        $linkedUser = $em->getRepository(FosUser::class)
            ->findOneByEmail($email);
        if (!$linkedUser) {
            throw $this->createAccessDeniedException("Cette adresse email n'est asssocié à aucun utilisateur, merci de vérifier.");
        }
        $linkedUser->setConfirmationToken(time());
        $linkedUser->setPasswordRequestedAt(new \DateTime());
        $em->flush();
        $message = (new \Swift_Message('Lien de réinitialisation du mot de passe.'))
            ->setFrom(\App\Utils\Utils::$senderEmail)
            ->setTo($linkedUser->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/forgot-password/etudiant.html.twig', ['user' => $linkedUser,
                        'link' => \App\Utils\Utils::$lienResetEtudiantPassword . $linkedUser->getConfirmationToken()]
                ), 'text/html'
            );
        $mailer->send($message);

        return true;
    }

    /**
     * @Rest\Post(path="/public/check-token/", name="user_token_check")
     * @Rest\View(StatusCode=200)
     */
    public function checkToken(Request $request): FosUser
    {
        $token = $request->getContent();
        if (!$token) {
            throw $this->createNotFoundException("Lien invalide !");
        }
        $em = $this->getDoctrine()->getManager();
        $linkedUser = $em->getRepository(FosUser::class)
            ->findOneByConfirmationToken($token);
        if (!$linkedUser) {
            throw $this->createAccessDeniedException("Ce lien n'est plus valable.");
        }
        // verifier si le token n'a pas expiré
        /* $tokenLife = Utils::getDateDifferenceInHours(new \DateTime(), $linkedUser->getPasswordRequestedAt());
          if ($tokenLife > 48) {
          $linkedUser->setConfirmationToken(null);
          $linkedUser->setPasswordRequestedAt(null);
          throw $this->createAccessDeniedException("Ce lien a déja expiré, merci de faire une nouvelle demande.");
          } */

        $em->flush();

        return $linkedUser;
    }

    /**
     * @Rest\Post(path="/public/update-password/", name="user_update_password")
     * @Rest\View(StatusCode=200)
     */
    public function updatePassword(Request $request, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder): FosUser
    {
        $updateData = json_decode($request->getContent());
        if (!isset($updateData->password)) {
            throw $this->createNotFoundException("Mot de passe introuvable");
        }
        $password = $updateData->password;
        if (!isset($updateData->email)) {
            throw $this->createNotFoundException("Utilisateur introuvable, identifiant incorrect.");
        }
        $email = $updateData->email;

        $em = $this->getDoctrine()->getManager();
        $linkedUser = $em->getRepository(FosUser::class)
            ->findOneByEmail($email);
        if (!$linkedUser) {
            throw $this->createAccessDeniedException("Information incorrecte...");
        }
        // verifier si le token n'a pas expiré
        /* $tokenLife = Utils::getDateDifferenceInHours(new \DateTime(), $linkedUser->getPasswordRequestedAt());
          if ($tokenLife > 48) {
          $linkedUser->setConfirmationToken(null);
          $linkedUser->setPasswordRequestedAt(null);
          throw $this->createAccessDeniedException("Ce lien a déja expiré, merci de faire une nouvelle demande.");
          } */
        $linkedUser->setConfirmationToken(null);
        $linkedUser->setPasswordRequestedAt(null);
        $linkedUser->setPassword($passwordEncoder->encodePassword($linkedUser, $password));

        $em->flush();

        return $linkedUser;
    }
    
     /**
     * @Rest\Post(path="/change-password/", name="user_change_password")
     * @Rest\View(StatusCode=200)
     */
    
    public function changerPassword(Request $request, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder): FosUser
    {
        $em = $this->getDoctrine()->getManager();
        $updateData = json_decode($request->getContent());
        $password = $updateData->newPassword;
        $password2 = $updateData->newPasswordConfirm;
        $passworactuel = $updateData->currentPassword;
        $userManager = $this->getUser();
        $verification = password_verify($passworactuel, $this->getUser()->getPassword());
        
        if ($verification) {
             if($password != $password2){
                throw $this->createNotFoundException("'Les deux mots de passe ne concordent pas.");               
             }
        } else {
            throw $this->createNotFoundException("Mot de passe introuvable");
        }

       
        $userManager->setConfirmationToken(null);
        $userManager->setPasswordRequestedAt(null);
        $userManager->setPassword($passwordEncoder->encodePassword($userManager, $password));

        $em->flush();

        return $userManager;
    }
    

    /**
     * @Rest\Post(Path="/create", name="fos_user_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_NOUVEAU")
     */
    public function create(Request $request): FosUser
    {
        $fosUser = new FosUser();
        $form = $this->createForm(FosUserType::class, $fosUser);
        $form->submit(Utils::serializeRequestContent($request));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fosUser);
        $entityManager->flush();

        return $fosUser;
    }

    /**
     * @Rest\Get(path="/{id}", name="fos_user_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_AFFICHAGE")
     */
    public function show(FosUser $fosUser): FosUser
    {
        return $fosUser;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="fos_user_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_EDITION")
     */
    public function edit(Request $request, FosUser $fosUser): FosUser
    {
        $form = $this->createForm(FosUserType::class, $fosUser);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $fosUser;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="fos_user_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_CLONE")
     */
    public function cloner(Request $request, FosUser $fosUser): FosUser
    {
        $em = $this->getDoctrine()->getManager();
        $fosUserNew = new FosUser();
        $form = $this->createForm(FosUserType::class, $fosUserNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($fosUserNew);

        $em->flush();

        return $fosUserNew;
    }

    /**
     * @Rest\Delete("/{id}", name="fos_user_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_DELETE")
     */
    public function delete(FosUser $fosUser): FosUser
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fosUser);
        $entityManager->flush();

        return $fosUser;
    }

    /**
     * @Rest\Post("/delete-selection/", name="fos_user_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_FOSUSER_DELETE")
     */
    public function deleteMultiple(Request $request): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $fosUsers = Utils::getObjectFromRequest($request);
        if (!count($fosUsers)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($fosUsers as $fosUser) {
            $fosUser = $entityManager->getRepository(FosUser::class)->find($fosUser->id);
            $entityManager->remove($fosUser);
        }
        $entityManager->flush();

        return $fosUsers;
    }

}
