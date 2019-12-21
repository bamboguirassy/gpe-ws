<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatPaieFinal
 *
 * @ORM\Table(name="etat_paie_final", indexes={@ORM\Index(name="anneeacad", columns={"anneeacad"})})
 * @ORM\Entity
 */
class EtatPaieFinal
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="user_creation", type="string", length=50, nullable=false)
     */
    private $userCreation;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="achemine", type="boolean", nullable=true)
     */
    private $achemine;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_achemination", type="date", nullable=true)
     */
    private $dateAchemination;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_achemination", type="string", length=50, nullable=true)
     */
    private $userAchemination;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reception", type="date", nullable=true)
     */
    private $dateReception;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_reception", type="string", length=50, nullable=true)
     */
    private $userReception;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @var float
     *
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=false)
     */
    private $budget;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anneeacad", referencedColumnName="id")
     * })
     */
    private $anneeacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
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

    public function getAchemine(): ?bool
    {
        return $this->achemine;
    }

    public function setAchemine(?bool $achemine): self
    {
        $this->achemine = $achemine;

        return $this;
    }

    public function getDateAchemination(): ?\DateTimeInterface
    {
        return $this->dateAchemination;
    }

    public function setDateAchemination(?\DateTimeInterface $dateAchemination): self
    {
        $this->dateAchemination = $dateAchemination;

        return $this;
    }

    public function getUserAchemination(): ?string
    {
        return $this->userAchemination;
    }

    public function setUserAchemination(?string $userAchemination): self
    {
        $this->userAchemination = $userAchemination;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getUserReception(): ?string
    {
        return $this->userReception;
    }

    public function setUserReception(?string $userReception): self
    {
        $this->userReception = $userReception;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getAnneeacad(): ?Anneeacad
    {
        return $this->anneeacad;
    }

    public function setAnneeacad(?Anneeacad $anneeacad): self
    {
        $this->anneeacad = $anneeacad;

        return $this;
    }


}
