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
 * Description of AuthController
 *
 * @author bambo
 *
 * @Route("/api/auth")
 */
class AuthController extends AbstractController {

    /**
     * @Rest\Get(path="/current_user/", name="current_user_show")
     * @Rest\View(StatusCode=200)
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function getCurrentUser(): FosUser {
        return $this->getUser();
    }
    
    /**
     * @Rest\Get(path="/security-code/", name="get_security_code")
     * @Rest\View(StatusCode=200)
     */
    public function getSecurityCode(\Swift_Mailer $mailer) {
        $secureCode=random_int(1000000000, 9999999999);
        //send confirmation mail
        $message = (new \Swift_Message('Code de confirmation'))
                ->setFrom(\App\Utils\Utils::$senderEmail)
                ->setTo($this->getUser()->getEmail())
                ->setBody(
                $this->renderView(
                        'emails/security/secure-code.html.twig', ['code' => $secureCode]
                ), 'text/html'
        );
        $mailer->send($message);
        return $secureCode;
    }

}
