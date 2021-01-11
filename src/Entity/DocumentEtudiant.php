<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentEtudiant
 *
 * @ORM\Table(name="document_etudiant")
 * @ORM\Entity
 */
class DocumentEtudiant
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
     * @ORM\Column(name="filename", type="string", length=150, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="date", nullable=false)
     */
    private $dateAjout;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre_document", type="string", length=150, nullable=true)
     */
    private $titreDocument;

    /**
     * @var bool
     *
     * @ORM\Column(name="est_valide", type="boolean", nullable=false)
     */
    private $estValide;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_validation", type="date", nullable=true)
     */
    private $dateValidation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_validation", type="string", length=150, nullable=true)
     */
    private $userValidation;

    /**
     * @var Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etudiant", referencedColumnName="id")
     * })
     */
    private $etudiant;

    /**
     * @var Typedocument
     *
     * @ORM\ManyToOne(targetEntity="Typedocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_document", referencedColumnName="id")
     * })
     */
    private $typeDocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUrl(): ?string
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

    public function getTitreDocument(): ?string
    {
        return $this->titreDocument;
    }

    public function setTitreDocument(?string $titreDocument): self
    {
        $this->titreDocument = $titreDocument;

        return $this;
    }

    public function getEstValide(): ?bool
    {
        return $this->estValide;
    }

    public function setEstValide(bool $estValide): self
    {
        $this->estValide = $estValide;

        return $this;
    }

    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    public function setDateValidation($dateValidation): self
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function getUserValidation(): ?string
    {
        return $this->userValidation;
    }

    public function setUserValidation(?string $userValidation): self
    {
        $this->userValidation = $userValidation;

        return $this;
    }

    public function getEtudiant()
    {
        return $this->etudiant;
    }

    public function setEtudiant($etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getTypeDocument()
    {
        return $this->typeDocument;
    }

    public function setTypeDocument($typeDocument): self
    {
        $this->typeDocument = $typeDocument;

        return $this;
    }


}
