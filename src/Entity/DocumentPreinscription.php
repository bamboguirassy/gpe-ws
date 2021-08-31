<?php

namespace App\Entity;

use App\Repository\DocumentPreinscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentPreinscriptionRepository::class)
 */
class DocumentPreinscription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $titre;

   
     /**
     * @var Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe", referencedColumnName="id")
     * })
     */
    private $classe;

    public function getId()
    {
        return $this->id;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    public function setDateAjout($dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getClasse()
    {
        return $this->classe;
    }

    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }
}
