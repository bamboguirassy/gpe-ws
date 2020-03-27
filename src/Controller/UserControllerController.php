<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/api/user", name="user_cntroller")
 */
class UserControllerController extends AbstractController
{
    /**
     * @Rest\Get("/", name="user_cntroller")
     * @Rest\View(statusCode=200)
     */
    public function index()
    {
        return $this->getUser();
    }
}
