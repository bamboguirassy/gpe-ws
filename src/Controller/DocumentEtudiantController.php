<?php

namespace App\Controller;

use App\Entity\DocumentEtudiant;
use App\Entity\Etudiant;
use App\Form\DocumentEtudiantType;
use App\Utils\FileUploader;
use App\Utils\Utils;
use Couchbase\Document;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/api/document-etudiant")
 */
class DocumentEtudiantController extends AbstractController
{

    /**
     * @Rest\Post(path="/create", name="document_etudiant_new")
     * @Rest\View(statusCode=201)
     */
    public function create(Request $request, EntityManagerInterface $entityManager, FileUploader $uploader)
    {
        $documentEtudiant = new DocumentEtudiant();
        $httpHost = $request->getHttpHost();
        $protocolVersion = $request->getScheme();
        $form = $this->createForm(DocumentEtudiantType::class, $documentEtudiant);
        $form->submit(Utils::serializeRequestContent($request));

        if ($documentEtudiant->getTypeDocument()->getCodetypedocument() === 'OTHER' && empty($documentEtudiant->getTitreDocument()))
            throw new BadRequestHttpException("Vous devez obligatoirement donner un titre au document.");

        try {
            $documentEtudiantOld = $entityManager->createQuery('
                SELECT de
                FROM App\Entity\DocumentEtudiant de
                JOIN de.typeDocument td
                WHERE de.typeDocument=:typeDocument 
                    AND de.etudiant=:etudiant 
                    AND td.codetypedocument != :otherCode
            ')->setParameter('typeDocument', $documentEtudiant->getTypeDocument())
                ->setParameter('etudiant', $documentEtudiant->getEtudiant())
                ->setParameter('otherCode', 'OTHER')
                ->getResult();

            if (count($documentEtudiantOld)) {
                $documentEtudiantOld = $documentEtudiantOld[0];
            }

            if ($documentEtudiantOld) {
                $pathnameOld = $this->getParameter('document_etudiant_directory') . $documentEtudiantOld->getFilename();
                $fsInstance = new Filesystem();
                try {
                    if ($fsInstance->exists($pathnameOld)) {
                        $fsInstance->remove($pathnameOld);
                    }
                } catch (IOExceptionInterface $exception) {
                    echo "Une erreur est survenue lors de la suppression: " . $exception->getPath();
                }
                $entityManager->remove($documentEtudiantOld);
                $entityManager->flush();
            }
        } catch (NoResultException $e) {

        } catch (NonUniqueResultException $e) {

        }

        $deserializedDocument = Utils::getObjectFromRequest($request);
        $newFilename = $uploader->decodeAndUploadTo($deserializedDocument, $this->getParameter('document_etudiant_directory'));

        $documentEtudiant
            ->setFilename($newFilename)
            ->setDateAjout(new \DateTime())
            ->setEstValide(false);

        $documentEtudiant
            ->setUrl($protocolVersion . '://' . $httpHost . '/' . $this->getParameter('document_etudiant_directory') . $newFilename);
        $entityManager->persist($documentEtudiant);
        $entityManager->flush();

        return $documentEtudiant;
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @Rest\Put(path="/{id}/edit-other", name="document_etudiant_update", requirements={"id"="\d+"})
     * @Rest\View(statusCode=200)
     * @return DocumentEtudiant
     */
    public function updateOther(Request $request, DocumentEtudiant $documentEtudiant, EntityManagerInterface $entityManager, FileUploader $uploader)
    {
        $httpHost = $request->getHttpHost();
        $protocolVersion = $request->getScheme();
        $form = $this->createForm(DocumentEtudiantType::class, $documentEtudiant);
        $form->submit(Utils::serializeRequestContent($request));

        if ($documentEtudiant->getTypeDocument()->getCodetypedocument() === 'OTHER' && empty($documentEtudiant->getTitreDocument()))
            throw new BadRequestHttpException("Vous devez obligatoirement donner un titre au document.");

        $pathnameOld = $this->getParameter('document_etudiant_directory') . $documentEtudiant->getFilename();
        $fsInstance = new Filesystem();
        try {
            if ($fsInstance->exists($pathnameOld)) {
                $fsInstance->remove($pathnameOld);
            }
        } catch (IOExceptionInterface $exception) {
            echo "Une erreur est survenue lors de la suppression: " . $exception->getPath();
        }
        $entityManager->remove($documentEtudiant);
        $entityManager->flush();

        $deserializedDocument = Utils::getObjectFromRequest($request);
        $newFilename = $uploader->decodeAndUploadTo($deserializedDocument, $this->getParameter('document_etudiant_directory'));

        $documentEtudiant
            ->setFilename($newFilename)
            ->setDateAjout(new \DateTime())
            ->setEstValide(false);

        $documentEtudiant
            ->setUrl($protocolVersion . '://' . $httpHost . '/' . $this->getParameter('document_etudiant_directory') . $newFilename);
        $entityManager->persist($documentEtudiant);
        $entityManager->flush();

        return $documentEtudiant;
    }


    /**
     * @Rest\Get(path="/etudiant/{id}", name="find_by_etudiant", requirements = {"id"="\d+"})
     * @Rest\View(statusCode=200)
     */
    public function findByEtudiant(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager)
    {
        return $entityManager
            ->getRepository(DocumentEtudiant::class)
            ->findByEtudiant($etudiant);
    }

    /**
     * @Rest\Delete("/{id}", name="document_etudiant_delete",requirements = {"id"="\d+"})
     * @Rest\View(StatusCode=200)
     */
    public function delete(Request $request, DocumentEtudiant $documentEtudiant): DocumentEtudiant
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($documentEtudiant->getFilename()) {
            $pathname = $this->getParameter('document_etudiant_directory') . $documentEtudiant->getFilename();
            $fsInstance = new Filesystem();
            try {
                if ($fsInstance->exists($pathname)) {
                    $fsInstance->remove($pathname);
                }
            } catch (IOExceptionInterface $exception) {
                echo "Une erreur est survenue lors de la suppression: " . $exception->getPath();
            }
            $entityManager->remove($documentEtudiant);
            $entityManager->flush();
        }
        return $documentEtudiant;
    }
}
