<?php

namespace App\Controller;

use App\Entity\DocumentPreinscription;
use App\Entity\Classe;
use App\Utils\FileUploader;
use App\Form\DocumentPreinscriptionType;
use App\Repository\DocumentPreinscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Utils\Utils;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;



/**
 * @Route("/api/document-preinscription")
 */
class DocumentPreinscriptionController extends AbstractController
{


    /**
     * @Rest\Post(path="/create", name="document_preinscription_new")
     * @Rest\View(statusCode=201)
     */
    public function create(Request $request, EntityManagerInterface $entityManager, FileUploader $uploader)
    {
        $documentPreinscription = new DocumentPreinscription();
        $httpHost = $request->getHttpHost();
        $protocolVersion = $request->getScheme();
        $form = $this->createForm(DocumentPreinscriptionType::class, $documentPreinscription);
        $form->handleRequest($request);
        $data = Utils::getObjectFromRequest($request);
  
        $deserializedDocument = Utils::getObjectFromRequest($request);
        $newFilename = $uploader->decodeAndUploadTo($deserializedDocument, $this->getParameter('document_preinscription_directory'));

        $classe = $entityManager->getRepository(Classe::class)->find($data->classe);
        $documentPreinscription
            ->setFilename($newFilename)
            ->setTitre($data->titre)
            ->setClasse($classe)
            ->setDateAjout(new \DateTime());
        
        $documentPreinscription
            ->setUrl($protocolVersion . '://' . $httpHost . '/' . $this->getParameter('document_preinscription_directory') . $documentPreinscription->getFilename());
        $entityManager->persist($documentPreinscription);
        $entityManager->flush();
        
        return $documentPreinscription;
    }
    
    /**
     * @Rest\Get(path="/preinscription/{id}", name="find_by_document_preinscription", requirements = {"id"="\d+"})
     * @Rest\View(statusCode=200)
     */
    public function findByPreinscription(Request $request, Classe $classe, EntityManagerInterface $entityManager)
    {
        return $entityManager
            ->getRepository(DocumentPreinscription::class)
            ->findByClasse($classe);
    }

    /**
     * @Rest\Delete("/{id}", name="document_preinscription_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function delete(Request $request, DocumentPreinscription $documentPreinscription)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        if ($documentPreinscription->getFilename()) {
            $pathname = $this->getParameter('document_preinscription_directory') . $documentPreinscription->getFilename();
            $fsInstance = new Filesystem();
            try {
                if ($fsInstance->exists($pathname)) {
                    $fsInstance->remove($pathname);
                }
            } catch (IOExceptionInterface $exception) {
                echo "Une erreur est survenue lors de la suppression: " . $exception->getPath();
            }
            $entityManager->remove($documentPreinscription);
            $entityManager->flush();
        }
        return $documentPreinscription;

    }
}
