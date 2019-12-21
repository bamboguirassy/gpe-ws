<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatPaieEc
 *
 * @ORM\Table(name="etat_paie_ec", indexes={@ORM\Index(name="idenseignant", columns={"idenseignant"}), @ORM\Index(name="id_etat_paie_final", columns={"etat_paie_final"}), @ORM\Index(name="idanneeacad", columns={"idecanneeacad", "idenseignant", "etat_paie_departement"}), @ORM\Index(name="etat_paie_departement", columns={"etat_paie_departement"}), @ORM\Index(name="arrete_enseignant", columns={"arrete_enseignant"}), @ORM\Index(name="IDX_867838AF153C28F0", columns={"idecanneeacad"})})
 * @ORM\Entity
 */
class EtatPaieEc
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
     * @var bool|null
     *
     * @ORM\Column(name="paiement_acp", type="boolean", nullable=true)
     */
    private $paiementAcp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_paiement", type="date", nullable=true)
     */
    private $datePaiement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_paiement", type="string", length=50, nullable=true)
     */
    private $userPaiement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="volume_cm_affecte", type="integer", nullable=true)
     */
    private $volumeCmAffecte = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="volume_td_affecte", type="integer", nullable=true)
     */
    private $volumeTdAffecte = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="volume_tp_affecte", type="integer", nullable=true)
     */
    private $volumeTpAffecte = '0';

    /**
     * @var \Ecanneeacad
     *
     * @ORM\ManyToOne(targetEntity="Ecanneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idecanneeacad", referencedColumnName="id")
     * })
     */
    private $idecanneeacad;

    /**
     * @var \Enseignant
     *
     * @ORM\ManyToOne(targetEntity="Enseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idenseignant", referencedColumnName="id")
     * })
     */
    private $idenseignant;

    /**
     * @var \EtatPaieEntite
     *
     * @ORM\ManyToOne(targetEntity="EtatPaieEntite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_paie_departement", referencedColumnName="id")
     * })
     */
    private $etatPaieDepartement;

    /**
     * @var \EtatPaieFinal
     *
     * @ORM\ManyToOne(targetEntity="EtatPaieFinal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_paie_final", referencedColumnName="id")
     * })
     */
    private $etatPaieFinal;

    /**
     * @var \ArreteEnseignant
     *
     * @ORM\ManyToOne(targetEntity="ArreteEnseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arrete_enseignant", referencedColumnName="id")
     * })
     */
    private $arreteEnseignant;

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

    public function getPaiementAcp(): ?bool
    {
        return $this->paiementAcp;
    }

    public function setPaiementAcp(?bool $paiementAcp): self
    {
        $this->paiementAcp = $paiementAcp;

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

    public function getUserPaiement(): ?string
    {
        return $this->userPaiement;
    }

    public function setUserPaiement(?string $userPaiement): self
    {
        $this->userPaiement = $userPaiement;

        return $this;
    }

    public function getVolumeCmAffecte(): ?int
    {
        return $this->volumeCmAffecte;
    }

    public function setVolumeCmAffecte(?int $volumeCmAffecte): self
    {
        $this->volumeCmAffecte = $volumeCmAffecte;

        return $this;
    }

    public function getVolumeTdAffecte(): ?int
    {
        return $this->volumeTdAffecte;
    }

    public function setVolumeTdAffecte(?int $volumeTdAffecte): self
    {
        $this->volumeTdAffecte = $volumeTdAffecte;

        return $this;
    }

    public function getVolumeTpAffecte(): ?int
    {
        return $this->volumeTpAffecte;
    }

    public function setVolumeTpAffecte(?int $volumeTpAffecte): self
    {
        $this->volumeTpAffecte = $volumeTpAffecte;

        return $this;
    }

    public function getIdecanneeacad(): ?Ecanneeacad
    {
        return $this->idecanneeacad;
    }

    public function setIdecanneeacad(?Ecanneeacad $idecanneeacad): self
    {
        $this->idecanneeacad = $idecanneeacad;

        return $this;
    }

    public function getIdenseignant(): ?Enseignant
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(?Enseignant $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
    }

    public function getEtatPaieDepartement(): ?EtatPaieEntite
    {
        return $this->etatPaieDepartement;
    }

    public function setEtatPaieDepartement(?EtatPaieEntite $etatPaieDepartement): self
    {
        $this->etatPaieDepartement = $etatPaieDepartement;

        return $this;
    }

    public function getEtatPaieFinal(): ?EtatPaieFinal
    {
        return $this->etatPaieFinal;
    }

    public function setEtatPaieFinal(?EtatPaieFinal $etatPaieFinal): self
    {
        $this->etatPaieFinal = $etatPaieFinal;

        return $this;
    }

    public function getArreteEnseignant(): ?ArreteEnseignant
    {
        return $this->arreteEnseignant;
    }

    public function setArreteEnseignant(?ArreteEnseignant $arreteEnseignant): self
    {
        $this->arreteEnseignant = $arreteEnseignant;

        return $this;
    }


}
