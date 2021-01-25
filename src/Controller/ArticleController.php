<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/article")
 */
class ArticleController extends AbstractController {

    /**
     * @Rest\Get(path="/", name="article_index")
     * @Rest\View(StatusCode = 200)
     * @IsGranted("ROLE_ARTICLE_LISTE")
     */
    public function index(): array {
        $articles = $this->getDoctrine()
                ->getRepository(Article::class)
                ->findAll();

        return count($articles) ? $articles : [];
    }

    /**
     * @Rest\Post(Path="/create", name="article_new")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_NOUVEAU")
     */
    public function create(Request $request): Article {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit(Utils::serializeRequestContent($request));
        $article->setDateCreation(new \DateTime());
        $article->setUserCreation($this->getUser());
        // si publie est true 
        if ($article->getPublie()) {
            $article->setDatePublication(new \DateTime());
            $article->setUserPublication($this->getUser());
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        return $article;
    }

    /**
     * @Rest\Get(path="/{id}", name="article_show",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_AFFICHAGE")
     */
    public function show(Article $article): Article {
        return $article;
    }

    /**
     * @Rest\Put(path="/{id}/edit", name="article_edit",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_EDITION")
     */
    public function edit(Request $request, Article $article): Article {
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit(Utils::serializeRequestContent($request));

        $this->getDoctrine()->getManager()->flush();

        return $article;
    }

    /**
     * @Rest\Put(path="/{id}/clone", name="article_clone",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_CLONE")
     */
    public function cloner(Request $request, Article $article): Article {
        $em = $this->getDoctrine()->getManager();
        $articleNew = new Article();
        $form = $this->createForm(ArticleType::class, $articleNew);
        $form->submit(Utils::serializeRequestContent($request));
        $em->persist($articleNew);

        $em->flush();

        return $articleNew;
    }

    /**
     * @Rest\Delete("/{id}", name="article_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_SUPPRESSION")
     */
    public function delete(Article $article): Article {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $article;
    }

    /**
     * @Rest\Post("/delete-selection/", name="article_selection_delete")
     * @Rest\View(StatusCode=200)
     * @IsGranted("ROLE_ARTICLE_SUPPRESSION")
     */
    public function deleteMultiple(Request $request): array {
        $entityManager = $this->getDoctrine()->getManager();
        $articles = Utils::getObjectFromRequest($request);
        if (!count($articles)) {
            throw $this->createNotFoundException("Selectionner au minimum un élément à supprimer.");
        }
        foreach ($articles as $article) {
            $article = $entityManager->getRepository(Article::class)->find($article->id);
            $entityManager->remove($article);
        }
        $entityManager->flush();

        return $articles;
    }

}
