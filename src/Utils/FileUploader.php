<?php

namespace App\Utils;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileUploader
{

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var string
     */
    private $targetDirectory;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @param File $file
     * @param $oldName
     * @return string
     * @throws Exception
     */
    public function upload(File $file, $newNameWithoutExtension, $oldName = null)
    {
        $fs = new Filesystem();
        # $authorizedExtensions = ['jpeg', 'jpg', 'png'];
        # if (!in_array($file->guessExtension(), $authorizedExtensions)) throw new BadRequestHttpException('Fichier non pris en charge');
        if ($oldName) {
            $oldFile = $this->getTargetDirectory() . $oldName;
            if ($fs->exists($oldFile))
                $fs->remove($oldFile); // remove old file
        }
        $newFileName = $newNameWithoutExtension . '.' . $file->guessExtension();
        $file->move($this->getTargetDirectory(), $newFileName);

        return $newFileName;
    }

    public function getTargetDirectory()
    {
        return $this->params->get($this->targetDirectory);
    }

    /**
     * @param string $targetDirectory
     * @return FileUploader
     */
    public function setTargetDirectory(string $targetDirectory): FileUploader
    {
        $this->targetDirectory = $targetDirectory;

        return $this;
    }

    public function decodeAndUploadTo($deserializedFile, $target_directory): string
    {
        $binaryDecodedData = base64_decode($deserializedFile->url);
        $tmpPath = sys_get_temp_dir() . '/sf_upload' . uniqid();
        $originalFileName = $deserializedFile->filename;
        file_put_contents($tmpPath, $binaryDecodedData);
        $uploadedFile = new File($tmpPath);
        $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
        $authorizedExtensions = ['jpeg', 'jpg', 'png', 'pdf', 'svg'];
        if (!in_array($uploadedFile->guessExtension(), $authorizedExtensions))
            throw new BadRequestHttpException("Impossible de charger ce type de ficher.");

        $uploadedFile->move(
            $target_directory,
            $newFilename
        );

        return $newFilename;
    }

}
