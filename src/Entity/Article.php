<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity
 */
class Article
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="user_creation", type="string", length=55, nullable=false)
     */
    private $userCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="publie", type="boolean", nullable=false)
     */
    private $publie;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=true)
     */
    private $datePublication;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_publication", type="string", length=55, nullable=true)
     */
    private $userPublication;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_desactivation", type="datetime", nullable=true)
     */
    private $dateDesactivation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_desactivation", type="string", length=55, nullable=true)
     */
    private $userDesactivation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_name", type="string", length=100, nullable=true)
     */
    private $photoName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_path", type="string", length=255, nullable=true)
     */
    private $photoPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setDateCreation($dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUserCreation(): ?string
    {
        return $this->userCreation;
    }

    public function setUserCreation(string $userCreation): self
    {
        $this->userCreation = $userCreation;

        return $this;
    }

    public function getPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): self
    {
        $this->publie = $publie;

        return $this;
    }

    public function getDatePublication()
    {
        return $this->datePublication;
    }

    public function setDatePublication($datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getUserPublication(): ?string
    {
        return $this->userPublication;
    }

    public function setUserPublication(?string $userPublication): self
    {
        $this->userPublication = $userPublication;

        return $this;
    }

    public function getDateDesactivation()
    {
        return $this->dateDesactivation;
    }

    public function setDateDesactivation($dateDesactivation): self
    {
        $this->dateDesactivation = $dateDesactivation;

        return $this;
    }

    public function getUserDesactivation(): ?string
    {
        return $this->userDesactivation;
    }

    public function setUserDesactivation(?string $userDesactivation): self
    {
        $this->userDesactivation = $userDesactivation;

        return $this;
    }

    public function getPhotoName(): ?string
    {
        return $this->photoName;
    }

    public function setPhotoName(?string $photoName): self
    {
        $this->photoName = $photoName;

        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photoPath;
    }

    public function setPhotoPath(?string $photoPath): self
    {
        $this->photoPath = $photoPath;

        return $this;
    }


}
