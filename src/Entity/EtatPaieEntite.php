<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatPaieEntite
 *
 * @ORM\Table(name="etat_paie_entite", indexes={@ORM\Index(name="entite", columns={"entite"}), @ORM\Index(name="etat_parent", columns={"etat_parent"}), @ORM\Index(name="anneeacad", columns={"anneeacad"})})
 * @ORM\Entity
 */
class EtatPaieEntite
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
     * @var string
     *
     * @ORM\Column(name="type_etat", type="string", length=200, nullable=false)
     */
    private $typeEtat;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="achemine_rectorat", type="boolean", nullable=true)
     */
    private $achemineRectorat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_achemination", type="date", nullable=true)
     */
    private $dateAchemination;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_achemination", type="string", length=200, nullable=true)
     */
    private $userAchemination;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="validation_deipvu", type="boolean", nullable=true)
     */
    private $validationDeipvu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_validation_deipvu", type="date", nullable=true)
     */
    private $dateValidationDeipvu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_validation_deipvu", type="string", length=200, nullable=true)
     */
    private $userValidationDeipvu;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="validation_drh", type="boolean", nullable=true)
     */
    private $validationDrh;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_validation_drh", type="date", nullable=true)
     */
    private $dateValidationDrh;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_validation_drh", type="string", length=200, nullable=true)
     */
    private $userValidationDrh;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="reception_dfc", type="boolean", nullable=true)
     */
    private $receptionDfc;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reception_dfc", type="date", nullable=true)
     */
    private $dateReceptionDfc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_reception_dfc", type="string", length=200, nullable=true)
     */
    private $userReceptionDfc;

    /**
     * @var \EtatPaieEntite
     *
     * @ORM\ManyToOne(targetEntity="EtatPaieEntite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_parent", referencedColumnName="id")
     * })
     */
    private $etatParent;

    /**
     * @var \Entite
     *
     * @ORM\ManyToOne(targetEntity="Entite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entite", referencedColumnName="id")
     * })
     */
    private $entite;

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

    public function getTypeEtat(): ?string
    {
        return $this->typeEtat;
    }

    public function setTypeEtat(string $typeEtat): self
    {
        $this->typeEtat = $typeEtat;

        return $this;
    }

    public function getAchemineRectorat(): ?bool
    {
        return $this->achemineRectorat;
    }

    public function setAchemineRectorat(?bool $achemineRectorat): self
    {
        $this->achemineRectorat = $achemineRectorat;

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

    public function getValidationDeipvu(): ?bool
    {
        return $this->validationDeipvu;
    }

    public function setValidationDeipvu(?bool $validationDeipvu): self
    {
        $this->validationDeipvu = $validationDeipvu;

        return $this;
    }

    public function getDateValidationDeipvu(): ?\DateTimeInterface
    {
        return $this->dateValidationDeipvu;
    }

    public function setDateValidationDeipvu(?\DateTimeInterface $dateValidationDeipvu): self
    {
        $this->dateValidationDeipvu = $dateValidationDeipvu;

        return $this;
    }

    public function getUserValidationDeipvu(): ?string
    {
        return $this->userValidationDeipvu;
    }

    public function setUserValidationDeipvu(?string $userValidationDeipvu): self
    {
        $this->userValidationDeipvu = $userValidationDeipvu;

        return $this;
    }

    public function getValidationDrh(): ?bool
    {
        return $this->validationDrh;
    }

    public function setValidationDrh(?bool $validationDrh): self
    {
        $this->validationDrh = $validationDrh;

        return $this;
    }

    public function getDateValidationDrh(): ?\DateTimeInterface
    {
        return $this->dateValidationDrh;
    }

    public function setDateValidationDrh(?\DateTimeInterface $dateValidationDrh): self
    {
        $this->dateValidationDrh = $dateValidationDrh;

        return $this;
    }

    public function getUserValidationDrh(): ?string
    {
        return $this->userValidationDrh;
    }

    public function setUserValidationDrh(?string $userValidationDrh): self
    {
        $this->userValidationDrh = $userValidationDrh;

        return $this;
    }

    public function getReceptionDfc(): ?bool
    {
        return $this->receptionDfc;
    }

    public function setReceptionDfc(?bool $receptionDfc): self
    {
        $this->receptionDfc = $receptionDfc;

        return $this;
    }

    public function getDateReceptionDfc(): ?\DateTimeInterface
    {
        return $this->dateReceptionDfc;
    }

    public function setDateReceptionDfc(?\DateTimeInterface $dateReceptionDfc): self
    {
        $this->dateReceptionDfc = $dateReceptionDfc;

        return $this;
    }

    public function getUserReceptionDfc(): ?string
    {
        return $this->userReceptionDfc;
    }

    public function setUserReceptionDfc(?string $userReceptionDfc): self
    {
        $this->userReceptionDfc = $userReceptionDfc;

        return $this;
    }

    public function getEtatParent(): ?self
    {
        return $this->etatParent;
    }

    public function setEtatParent(?self $etatParent): self
    {
        $this->etatParent = $etatParent;

        return $this;
    }

    public function getEntite(): ?Entite
    {
        return $this->entite;
    }

    public function setEntite(?Entite $entite): self
    {
        $this->entite = $entite;

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
