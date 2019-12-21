<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enseignant
 *
 * @ORM\Table(name="enseignant", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="matricule_UNIQUE", columns={"matricule"})}, indexes={@ORM\Index(name="fk_enseignant_titreenseignant1_idx", columns={"idTitreEnseignant"}), @ORM\Index(name="idpays_2", columns={"idpays"}), @ORM\Index(name="fk_Enseignant_TypeEnseignant1_idx", columns={"idTypeEnseignant"}), @ORM\Index(name="idpays", columns={"idpays"})})
 * @ORM\Entity
 */
class Enseignant
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
     * @ORM\Column(name="matricule", type="string", length=45, nullable=false)
     */
    private $matricule;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_crea", type="date", nullable=true)
     */
    private $dateCrea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datemodification", type="date", nullable=false)
     */
    private $datemodification;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomEnseignant", type="string", length=45, nullable=true)
     */
    private $nomenseignant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenomEnseignant", type="string", length=45, nullable=true)
     */
    private $prenomenseignant;

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
     * @ORM\Column(name="telEnseignant", type="string", length=45, nullable=true)
     */
    private $telenseignant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sexe", type="string", length=25, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lien_cv", type="string", length=200, nullable=true)
     */
    private $lienCv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_compte", type="string", length=50, nullable=true)
     */
    private $numeroCompte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="banque", type="string", length=100, nullable=true)
     */
    private $banque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cin", type="string", length=25, nullable=true)
     */
    private $cin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profession", type="string", length=100, nullable=true)
     */
    private $profession;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entreprise", type="string", length=50, nullable=true)
     */
    private $entreprise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="universite", type="string", length=50, nullable=true)
     */
    private $universite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujet_these", type="string", length=25, nullable=true)
     */
    private $sujetThese;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_vacataire", type="string", length=50, nullable=true)
     */
    private $typeVacataire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dernier_diplome", type="string", length=200, nullable=true)
     */
    private $dernierDiplome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quartier", type="string", length=50, nullable=true)
     */
    private $quartier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=50, nullable=true)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=50, nullable=false)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_banque", type="string", length=50, nullable=true)
     */
    private $codeBanque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_guichet", type="string", length=50, nullable=true)
     */
    private $codeGuichet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rib", type="string", length=50, nullable=true)
     */
    private $rib;

    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpays", referencedColumnName="id")
     * })
     */
    private $idpays;

    /**
     * @var \Typeenseignant
     *
     * @ORM\ManyToOne(targetEntity="Typeenseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeEnseignant", referencedColumnName="id")
     * })
     */
    private $idtypeenseignant;

    /**
     * @var \Titreenseignant
     *
     * @ORM\ManyToOne(targetEntity="Titreenseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTitreEnseignant", referencedColumnName="id")
     * })
     */
    private $idtitreenseignant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(?\DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getNomenseignant(): ?string
    {
        return $this->nomenseignant;
    }

    public function setNomenseignant(?string $nomenseignant): self
    {
        $this->nomenseignant = $nomenseignant;

        return $this;
    }

    public function getPrenomenseignant(): ?string
    {
        return $this->prenomenseignant;
    }

    public function setPrenomenseignant(?string $prenomenseignant): self
    {
        $this->prenomenseignant = $prenomenseignant;

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

    public function getTelenseignant(): ?string
    {
        return $this->telenseignant;
    }

    public function setTelenseignant(?string $telenseignant): self
    {
        $this->telenseignant = $telenseignant;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLienCv(): ?string
    {
        return $this->lienCv;
    }

    public function setLienCv(?string $lienCv): self
    {
        $this->lienCv = $lienCv;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(?string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(?string $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getUniversite(): ?string
    {
        return $this->universite;
    }

    public function setUniversite(?string $universite): self
    {
        $this->universite = $universite;

        return $this;
    }

    public function getSujetThese(): ?string
    {
        return $this->sujetThese;
    }

    public function setSujetThese(?string $sujetThese): self
    {
        $this->sujetThese = $sujetThese;

        return $this;
    }

    public function getTypeVacataire(): ?string
    {
        return $this->typeVacataire;
    }

    public function setTypeVacataire(?string $typeVacataire): self
    {
        $this->typeVacataire = $typeVacataire;

        return $this;
    }

    public function getDernierDiplome(): ?string
    {
        return $this->dernierDiplome;
    }

    public function setDernierDiplome(?string $dernierDiplome): self
    {
        $this->dernierDiplome = $dernierDiplome;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodeBanque(): ?string
    {
        return $this->codeBanque;
    }

    public function setCodeBanque(?string $codeBanque): self
    {
        $this->codeBanque = $codeBanque;

        return $this;
    }

    public function getCodeGuichet(): ?string
    {
        return $this->codeGuichet;
    }

    public function setCodeGuichet(?string $codeGuichet): self
    {
        $this->codeGuichet = $codeGuichet;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getIdpays(): ?Pays
    {
        return $this->idpays;
    }

    public function setIdpays(?Pays $idpays): self
    {
        $this->idpays = $idpays;

        return $this;
    }

    public function getIdtypeenseignant(): ?Typeenseignant
    {
        return $this->idtypeenseignant;
    }

    public function setIdtypeenseignant(?Typeenseignant $idtypeenseignant): self
    {
        $this->idtypeenseignant = $idtypeenseignant;

        return $this;
    }

    public function getIdtitreenseignant(): ?Titreenseignant
    {
        return $this->idtitreenseignant;
    }

    public function setIdtitreenseignant(?Titreenseignant $idtitreenseignant): self
    {
        $this->idtitreenseignant = $idtitreenseignant;

        return $this;
    }


}
