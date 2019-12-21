<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayementVacation
 *
 * @ORM\Table(name="payement_vacation", indexes={@ORM\Index(name="user_mandatement_2", columns={"user_mandatement"}), @ORM\Index(name="enseignant", columns={"enseignant"}), @ORM\Index(name="anneeacad", columns={"anneeacad"}), @ORM\Index(name="user_paiement", columns={"user_paiement"}), @ORM\Index(name="ec", columns={"ec"}), @ORM\Index(name="user_mandatement", columns={"user_mandatement", "user_paiement", "enseignant", "ec", "anneeacad"})})
 * @ORM\Entity
 */
class PayementVacation
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
     * @ORM\Column(name="date_initiation", type="datetime", nullable=false)
     */
    private $dateInitiation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_mandatement", type="datetime", nullable=true)
     */
    private $dateMandatement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_mandatement", type="integer", nullable=true)
     */
    private $userMandatement;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_paiement", type="datetime", nullable=true)
     */
    private $datePaiement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_paiement", type="integer", nullable=true)
     */
    private $userPaiement;

    /**
     * @var int
     *
     * @ORM\Column(name="enseignant", type="integer", nullable=false)
     */
    private $enseignant;

    /**
     * @var int
     *
     * @ORM\Column(name="ec", type="integer", nullable=false)
     */
    private $ec;

    /**
     * @var int
     *
     * @ORM\Column(name="anneeacad", type="integer", nullable=false)
     */
    private $anneeacad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_cm", type="integer", nullable=true)
     */
    private $montantCm = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_td", type="integer", nullable=true)
     */
    private $montantTd = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant_tp", type="integer", nullable=true)
     */
    private $montantTp = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="mandate", type="boolean", nullable=true)
     */
    private $mandate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="paye", type="boolean", nullable=true)
     */
    private $paye;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInitiation(): ?\DateTimeInterface
    {
        return $this->dateInitiation;
    }

    public function setDateInitiation(\DateTimeInterface $dateInitiation): self
    {
        $this->dateInitiation = $dateInitiation;

        return $this;
    }

    public function getDateMandatement(): ?\DateTimeInterface
    {
        return $this->dateMandatement;
    }

    public function setDateMandatement(?\DateTimeInterface $dateMandatement): self
    {
        $this->dateMandatement = $dateMandatement;

        return $this;
    }

    public function getUserMandatement(): ?int
    {
        return $this->userMandatement;
    }

    public function setUserMandatement(?int $userMandatement): self
    {
        $this->userMandatement = $userMandatement;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getUserPaiement(): ?int
    {
        return $this->userPaiement;
    }

    public function setUserPaiement(?int $userPaiement): self
    {
        $this->userPaiement = $userPaiement;

        return $this;
    }

    public function getEnseignant(): ?int
    {
        return $this->enseignant;
    }

    public function setEnseignant(int $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getEc(): ?int
    {
        return $this->ec;
    }

    public function setEc(int $ec): self
    {
        $this->ec = $ec;

        return $this;
    }

    public function getAnneeacad(): ?int
    {
        return $this->anneeacad;
    }

    public function setAnneeacad(int $anneeacad): self
    {
        $this->anneeacad = $anneeacad;

        return $this;
    }

    public function getMontantCm(): ?int
    {
        return $this->montantCm;
    }

    public function setMontantCm(?int $montantCm): self
    {
        $this->montantCm = $montantCm;

        return $this;
    }

    public function getMontantTd(): ?int
    {
        return $this->montantTd;
    }

    public function setMontantTd(?int $montantTd): self
    {
        $this->montantTd = $montantTd;

        return $this;
    }

    public function getMontantTp(): ?int
    {
        return $this->montantTp;
    }

    public function setMontantTp(?int $montantTp): self
    {
        $this->montantTp = $montantTp;

        return $this;
    }

    public function getMandate(): ?bool
    {
        return $this->mandate;
    }

    public function setMandate(?bool $mandate): self
    {
        $this->mandate = $mandate;

        return $this;
    }

    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(?bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }


}
