<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArreteVacation
 *
 * @ORM\Table(name="arrete_vacation", indexes={@ORM\Index(name="id_arrete_vacation", columns={"id_arrete_vacation"}), @ORM\Index(name="identite", columns={"identite"}), @ORM\Index(name="id_annee_academique", columns={"id_annee_academique"})})
 * @ORM\Entity
 */
class ArreteVacation
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_transmission1", type="date", nullable=true)
     */
    private $dateTransmission1;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reception1", type="date", nullable=true)
     */
    private $dateReception1;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat_transmission1", type="boolean", nullable=true)
     */
    private $etatTransmission1;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat_reception1", type="boolean", nullable=true)
     */
    private $etatReception1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_transmission1", type="string", length=200, nullable=true)
     */
    private $userTransmission1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_reception1", type="string", length=200, nullable=true)
     */
    private $userReception1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_creation", type="string", length=200, nullable=true)
     */
    private $userCreation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_arrete", type="string", length=50, nullable=true)
     */
    private $numeroArrete;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_transmission2", type="date", nullable=true)
     */
    private $dateTransmission2;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reception2", type="date", nullable=true)
     */
    private $dateReception2;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat_transmission2", type="boolean", nullable=true)
     */
    private $etatTransmission2;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat_reception2", type="boolean", nullable=true)
     */
    private $etatReception2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_transmission2", type="string", length=200, nullable=true)
     */
    private $userTransmission2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_reception2", type="string", length=200, nullable=true)
     */
    private $userReception2;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="signature", type="boolean", nullable=true)
     */
    private $signature;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_signature", type="date", nullable=true)
     */
    private $dateSignature;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="rejete", type="boolean", nullable=true)
     */
    private $rejete;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_rejet", type="date", nullable=true)
     */
    private $dateRejet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_rejet", type="string", length=255, nullable=true)
     */
    private $userRejet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="motif_rejet", type="text", length=65535, nullable=true)
     */
    private $motifRejet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_signature", type="string", length=255, nullable=true)
     */
    private $userSignature;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=true)
     */
    private $numero;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annee_academique", referencedColumnName="id")
     * })
     */
    private $idAnneeAcademique;

    /**
     * @var \Entite
     *
     * @ORM\ManyToOne(targetEntity="Entite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="identite", referencedColumnName="id")
     * })
     */
    private $identite;

    /**
     * @var \ArreteVacation
     *
     * @ORM\ManyToOne(targetEntity="ArreteVacation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arrete_vacation", referencedColumnName="id")
     * })
     */
    private $idArreteVacation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTransmission1(): ?\DateTimeInterface
    {
        return $this->dateTransmission1;
    }

    public function setDateTransmission1(?\DateTimeInterface $dateTransmission1): self
    {
        $this->dateTransmission1 = $dateTransmission1;

        return $this;
    }

    public function getDateReception1(): ?\DateTimeInterface
    {
        return $this->dateReception1;
    }

    public function setDateReception1(?\DateTimeInterface $dateReception1): self
    {
        $this->dateReception1 = $dateReception1;

        return $this;
    }

    public function getEtatTransmission1(): ?bool
    {
        return $this->etatTransmission1;
    }

    public function setEtatTransmission1(?bool $etatTransmission1): self
    {
        $this->etatTransmission1 = $etatTransmission1;

        return $this;
    }

    public function getEtatReception1(): ?bool
    {
        return $this->etatReception1;
    }

    public function setEtatReception1(?bool $etatReception1): self
    {
        $this->etatReception1 = $etatReception1;

        return $this;
    }

    public function getUserTransmission1(): ?string
    {
        return $this->userTransmission1;
    }

    public function setUserTransmission1(?string $userTransmission1): self
    {
        $this->userTransmission1 = $userTransmission1;

        return $this;
    }

    public function getUserReception1(): ?string
    {
        return $this->userReception1;
    }

    public function setUserReception1(?string $userReception1): self
    {
        $this->userReception1 = $userReception1;

        return $this;
    }

    public function getUserCreation(): ?string
    {
        return $this->userCreation;
    }

    public function setUserCreation(?string $userCreation): self
    {
        $this->userCreation = $userCreation;

        return $this;
    }

    public function getNumeroArrete(): ?string
    {
        return $this->numeroArrete;
    }

    public function setNumeroArrete(?string $numeroArrete): self
    {
        $this->numeroArrete = $numeroArrete;

        return $this;
    }

    public function getDateTransmission2(): ?\DateTimeInterface
    {
        return $this->dateTransmission2;
    }

    public function setDateTransmission2(?\DateTimeInterface $dateTransmission2): self
    {
        $this->dateTransmission2 = $dateTransmission2;

        return $this;
    }

    public function getDateReception2(): ?\DateTimeInterface
    {
        return $this->dateReception2;
    }

    public function setDateReception2(?\DateTimeInterface $dateReception2): self
    {
        $this->dateReception2 = $dateReception2;

        return $this;
    }

    public function getEtatTransmission2(): ?bool
    {
        return $this->etatTransmission2;
    }

    public function setEtatTransmission2(?bool $etatTransmission2): self
    {
        $this->etatTransmission2 = $etatTransmission2;

        return $this;
    }

    public function getEtatReception2(): ?bool
    {
        return $this->etatReception2;
    }

    public function setEtatReception2(?bool $etatReception2): self
    {
        $this->etatReception2 = $etatReception2;

        return $this;
    }

    public function getUserTransmission2(): ?string
    {
        return $this->userTransmission2;
    }

    public function setUserTransmission2(?string $userTransmission2): self
    {
        $this->userTransmission2 = $userTransmission2;

        return $this;
    }

    public function getUserReception2(): ?string
    {
        return $this->userReception2;
    }

    public function setUserReception2(?string $userReception2): self
    {
        $this->userReception2 = $userReception2;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getSignature(): ?bool
    {
        return $this->signature;
    }

    public function setSignature(?bool $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getDateSignature(): ?\DateTimeInterface
    {
        return $this->dateSignature;
    }

    public function setDateSignature(?\DateTimeInterface $dateSignature): self
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }

    public function getRejete(): ?bool
    {
        return $this->rejete;
    }

    public function setRejete(?bool $rejete): self
    {
        $this->rejete = $rejete;

        return $this;
    }

    public function getDateRejet(): ?\DateTimeInterface
    {
        return $this->dateRejet;
    }

    public function setDateRejet(?\DateTimeInterface $dateRejet): self
    {
        $this->dateRejet = $dateRejet;

        return $this;
    }

    public function getUserRejet(): ?string
    {
        return $this->userRejet;
    }

    public function setUserRejet(?string $userRejet): self
    {
        $this->userRejet = $userRejet;

        return $this;
    }

    public function getMotifRejet(): ?string
    {
        return $this->motifRejet;
    }

    public function setMotifRejet(?string $motifRejet): self
    {
        $this->motifRejet = $motifRejet;

        return $this;
    }

    public function getUserSignature(): ?string
    {
        return $this->userSignature;
    }

    public function setUserSignature(?string $userSignature): self
    {
        $this->userSignature = $userSignature;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getIdAnneeAcademique(): ?Anneeacad
    {
        return $this->idAnneeAcademique;
    }

    public function setIdAnneeAcademique(?Anneeacad $idAnneeAcademique): self
    {
        $this->idAnneeAcademique = $idAnneeAcademique;

        return $this;
    }

    public function getIdentite(): ?Entite
    {
        return $this->identite;
    }

    public function setIdentite(?Entite $identite): self
    {
        $this->identite = $identite;

        return $this;
    }

    public function getIdArreteVacation(): ?self
    {
        return $this->idArreteVacation;
    }

    public function setIdArreteVacation(?self $idArreteVacation): self
    {
        $this->idArreteVacation = $idArreteVacation;

        return $this;
    }


}
