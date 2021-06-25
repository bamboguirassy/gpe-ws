<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * Preinscription
 *
 * @ORM\Table(name="preinscription", uniqueConstraints={@ORM\UniqueConstraint(name="idFiliere", columns={"idFiliere", "cni", "idAnneeAcad"})}, indexes={@ORM\Index(name="fk_preisncription_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_preisncription_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="fk_preisncription_Niveau1_idx", columns={"idNiveau"}), @ORM\Index(name="fk_preisncription_TypeAdmission1_idx", columns={"idTypeAdmission"})})
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
     * @var string
     *
     * @ORM\Column(name="cni", type="string", length=45, nullable=false)
     */
    private $cni;

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
     * @var bool
     *
     * @ORM\Column(name="paiement_confirme", type="boolean", nullable=true)
     */
    private $paiementConfirme;

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

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeAcad", referencedColumnName="id")
     * })
     * @MaxDepth(1)
     */
    private $idanneeacad;

    /**
     * @var \Filiere
     *
     * @ORM\ManyToOne(targetEntity="Filiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFiliere", referencedColumnName="id")
     * })
     * @MaxDepth(1)
     */
    private $idfiliere;

    /**
     * @var \Niveau
     *
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idNiveau", referencedColumnName="id")
     * })
     * @MaxDepth(1)
     */
    private $idniveau;

    /**
     * @var \Typeadmission
     *
     * @ORM\ManyToOne(targetEntity="Typeadmission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeAdmission", referencedColumnName="id")
     * })
     */
    private $idtypeadmission;
    
    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nationalite", referencedColumnName="id")
     * })
     */
    private $nationalite;
    
     /**
     * @var \Regimeinscription
     *
     * @ORM\ManyToOne(targetEntity="Regimeinscription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idregimeinscription", referencedColumnName="id")
     * })
     */
    private $idregimeinscription;

    public function getId()
    {
        return $this->id;
    }

    public function getCni()
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getIne()
    {
        return $this->ine;
    }

    public function setIne($ine): self
    {
        $this->ine = $ine;

        return $this;
    }

    public function getPassage()
    {
        return $this->passage;
    }

    public function setPassage(string $passage): self
    {
        $this->passage = $passage;

        return $this;
    }

    public function getPrenometudiant()
    {
        return $this->prenometudiant;
    }

    public function setPrenometudiant($prenometudiant): self
    {
        $this->prenometudiant = $prenometudiant;

        return $this;
    }

    public function getNometudiant()
    {
        return $this->nometudiant;
    }

    public function setNometudiant($nometudiant): self
    {
        $this->nometudiant = $nometudiant;

        return $this;
    }

    public function getDatenaiss()
    {
        return $this->datenaiss;
    }

    public function setDatenaiss($datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss()
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss($lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDatenotif()
    {
        return $this->datenotif;
    }

    public function setDatenotif($datenotif): self
    {
        $this->datenotif = $datenotif;

        return $this;
    }

    public function getDatedelai()
    {
        return $this->datedelai;
    }

    public function setDatedelai($datedelai): self
    {
        $this->datedelai = $datedelai;

        return $this;
    }

    public function getEstinscrit()
    {
        return $this->estinscrit;
    }

    public function setEstinscrit(bool $estinscrit): self
    {
        $this->estinscrit = $estinscrit;

        return $this;
    }

    public function getCodeOperateur()
    {
        return $this->codeOperateur;
    }

    public function setCodeOperateur($codeOperateur): self
    {
        $this->codeOperateur = $codeOperateur;

        return $this;
    }

    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    public function setDatePaiement($datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getNumeroTransaction()
    {
        return $this->numeroTransaction;
    }

    public function setNumeroTransaction($numeroTransaction): self
    {
        $this->numeroTransaction = $numeroTransaction;

        return $this;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant($montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getIdanneeacad()
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad($idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }

    public function getIdfiliere()
    {
        return $this->idfiliere;
    }

    public function setIdfiliere($idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getIdniveau()
    {
        return $this->idniveau;
    }

    public function setIdniveau($idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }

    public function getIdtypeadmission()
    {
        return $this->idtypeadmission;
    }

    public function setIdtypeadmission($idtypeadmission): self
    {
        $this->idtypeadmission = $idtypeadmission;

        return $this;
    }

    public function getNationalite()
    {
        return $this->nationalite;
    }

    public function setNationalite($nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getPaiementConfirme()
    {
        return $this->paiementConfirme;
    }

    /**
     * Set idregimeinscription
     *
     * @param \LmdproBundle\Entity\Regimeinscription $idregimeinscription
     *
     * @return Inscriptionacad
     */
    public function setIdregimeinscription($idregimeinscription) {
        $this->idregimeinscription = $idregimeinscription;

        return $this;
    }

    /**
     * Get idregimeinscription
     *
     * @return \LmdproBundle\Entity\Regimeinscription
     */
    public function getIdregimeinscription() {
        return $this->idregimeinscription;
    }

    public function setPaiementConfirme($paiementConfirme): self
    {
        $this->paiementConfirme = $paiementConfirme;

        return $this;
    }


}
