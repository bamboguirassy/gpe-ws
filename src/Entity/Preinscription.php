<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Preinscription
 *
 * @ORM\Table(name="preinscription", uniqueConstraints={@ORM\UniqueConstraint(name="idFiliere", columns={"idFiliere", "cni", "idAnneeAcad"})}, indexes={@ORM\Index(name="fk_preisncription_Niveau1_idx", columns={"idNiveau"}), @ORM\Index(name="fk_preisncription_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="fk_preisncription_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_preisncription_TypeAdmission1_idx", columns={"idTypeAdmission"})})
 * @ORM\Entity
 */
class Preinscription
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
     * @var int
     *
     * @ORM\Column(name="idFiliere", type="integer", nullable=false)
     */
    private $idfiliere;

    /**
     * @var int
     *
     * @ORM\Column(name="idAnneeAcad", type="integer", nullable=false)
     */
    private $idanneeacad;

    /**
     * @var int
     *
     * @ORM\Column(name="idNiveau", type="integer", nullable=false)
     */
    private $idniveau;

    /**
     * @var string
     *
     * @ORM\Column(name="cni", type="string", length=45, nullable=false)
     */
    private $cni;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idTypeAdmission", type="integer", nullable=true)
     */
    private $idtypeadmission;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ine", type="string", length=45, nullable=true)
     */
    private $ine;

    /**
     * @var string
     *
     * @ORM\Column(name="passage", type="string", length=45, nullable=false)
     */
    private $passage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenomEtudiant", type="string", length=255, nullable=true)
     */
    private $prenometudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomEtudiant", type="string", length=255, nullable=true)
     */
    private $nometudiant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateNaiss", type="date", nullable=true)
     */
    private $datenaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieuNaiss", type="string", length=45, nullable=true)
     */
    private $lieunaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel", type="string", length=45, nullable=true)
     */
    private $tel;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datenotif", type="date", nullable=true)
     */
    private $datenotif;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datedelai", type="date", nullable=true)
     */
    private $datedelai;

    /**
     * @var bool
     *
     * @ORM\Column(name="estInscrit", type="boolean", nullable=false)
     */
    private $estinscrit = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_operateur", type="string", length=55, nullable=true)
     */
    private $codeOperateur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_paiement", type="string", length=55, nullable=true)
     */
    private $datePaiement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_transaction", type="string", length=55, nullable=true)
     */
    private $numeroTransaction;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montant", type="integer", nullable=true)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdfiliere(): ?int
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(int $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getIdanneeacad(): ?int
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(int $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }

    public function getIdniveau(): ?int
    {
        return $this->idniveau;
    }

    public function setIdniveau(int $idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getIdtypeadmission(): ?int
    {
        return $this->idtypeadmission;
    }

    public function setIdtypeadmission(?int $idtypeadmission): self
    {
        $this->idtypeadmission = $idtypeadmission;

        return $this;
    }

    public function getIne(): ?string
    {
        return $this->ine;
    }

    public function setIne(?string $ine): self
    {
        $this->ine = $ine;

        return $this;
    }

    public function getPassage(): ?string
    {
        return $this->passage;
    }

    public function setPassage(string $passage): self
    {
        $this->passage = $passage;

        return $this;
    }

    public function getPrenometudiant(): ?string
    {
        return $this->prenometudiant;
    }

    public function setPrenometudiant(?string $prenometudiant): self
    {
        $this->prenometudiant = $prenometudiant;

        return $this;
    }

    public function getNometudiant(): ?string
    {
        return $this->nometudiant;
    }

    public function setNometudiant(?string $nometudiant): self
    {
        $this->nometudiant = $nometudiant;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(?\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss(): ?string
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(?string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDatenotif(): ?\DateTimeInterface
    {
        return $this->datenotif;
    }

    public function setDatenotif(?\DateTimeInterface $datenotif): self
    {
        $this->datenotif = $datenotif;

        return $this;
    }

    public function getDatedelai(): ?\DateTimeInterface
    {
        return $this->datedelai;
    }

    public function setDatedelai(?\DateTimeInterface $datedelai): self
    {
        $this->datedelai = $datedelai;

        return $this;
    }

    public function getEstinscrit(): ?bool
    {
        return $this->estinscrit;
    }

    public function setEstinscrit(bool $estinscrit): self
    {
        $this->estinscrit = $estinscrit;

        return $this;
    }

    public function getCodeOperateur(): ?string
    {
        return $this->codeOperateur;
    }

    public function setCodeOperateur(?string $codeOperateur): self
    {
        $this->codeOperateur = $codeOperateur;

        return $this;
    }

    public function getDatePaiement(): ?string
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?string $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getNumeroTransaction(): ?string
    {
        return $this->numeroTransaction;
    }

    public function setNumeroTransaction(?string $numeroTransaction): self
    {
        $this->numeroTransaction = $numeroTransaction;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }


}
