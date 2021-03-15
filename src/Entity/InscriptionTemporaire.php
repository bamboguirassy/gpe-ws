<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionTemporaire
 *
 * @ORM\Table(name="inscription_temporaire", uniqueConstraints={@ORM\UniqueConstraint(name="idClasse", columns={"idClasse", "idEtudiant"})}, indexes={@ORM\Index(name="fk_InscriptionAcad_RegimeInscription1_idx", columns={"idRegimeInscription"}), @ORM\Index(name="fk_InscriptionAcad_Classe1_idx", columns={"idClasse"}), @ORM\Index(name="fk_Inscription_Bourse1_idx", columns={"idBourse"}), @ORM\Index(name="fk_inscriptionacad_etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_InscriptionAcad_ModePaiement1_idx", columns={"idModePaiement"}), @ORM\Index(name="fk_InscriptionAcad_Specialite1_idx", columns={"idSpecialite"}), @ORM\Index(name="fk_InscriptionAcad_ModaliteEnseignement1_idx", columns={"idModaliteEnseignement"})})
 * @ORM\Entity
 */
class InscriptionTemporaire
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
     * @ORM\Column(name="passage", type="string", length=45, nullable=false)
     */
    private $passage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montantInscriptionAcad", type="integer", nullable=true)
     */
    private $montantinscriptionacad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="coutformation", type="integer", nullable=true)
     */
    private $coutformation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numQuittance", type="string", length=45, nullable=true)
     */
    private $numquittance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="source", type="string", length=50, nullable=true)
     */
    private $source;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="croust", type="boolean", nullable=true)
     */
    private $croust;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClasse", referencedColumnName="id")
     * })
     */
    private $idclasse;

    /**
     * @var \Specialite
     *
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSpecialite", referencedColumnName="id")
     * })
     */
    private $idspecialite;

    /**
     * @var \Regimeinscription
     *
     * @ORM\ManyToOne(targetEntity="Regimeinscription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRegimeInscription", referencedColumnName="id")
     * })
     */
    private $idregimeinscription;

    /**
     * @var \Modaliteenseignement
     *
     * @ORM\ManyToOne(targetEntity="Modaliteenseignement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idModaliteEnseignement", referencedColumnName="id")
     * })
     */
    private $idmodaliteenseignement;

    /**
     * @var \Modepaiement
     *
     * @ORM\ManyToOne(targetEntity="Modepaiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idModePaiement", referencedColumnName="id")
     * })
     */
    private $idmodepaiement;

    /**
     * @var \Bourse
     *
     * @ORM\ManyToOne(targetEntity="Bourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBourse", referencedColumnName="id")
     * })
     */
    private $idbourse;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMontantinscriptionacad(): ?int
    {
        return $this->montantinscriptionacad;
    }

    public function setMontantinscriptionacad(?int $montantinscriptionacad): self
    {
        $this->montantinscriptionacad = $montantinscriptionacad;

        return $this;
    }

    public function getCoutformation(): ?int
    {
        return $this->coutformation;
    }

    public function setCoutformation(?int $coutformation): self
    {
        $this->coutformation = $coutformation;

        return $this;
    }

    public function getNumquittance(): ?string
    {
        return $this->numquittance;
    }

    public function setNumquittance(?string $numquittance): self
    {
        $this->numquittance = $numquittance;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getCroust(): ?bool
    {
        return $this->croust;
    }

    public function setCroust(?bool $croust): self
    {
        $this->croust = $croust;

        return $this;
    }

    public function getIdetudiant(): ?Etudiant
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(?Etudiant $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getIdclasse(): ?Classe
    {
        return $this->idclasse;
    }

    public function setIdclasse(?Classe $idclasse): self
    {
        $this->idclasse = $idclasse;

        return $this;
    }

    public function getIdspecialite(): ?Specialite
    {
        return $this->idspecialite;
    }

    public function setIdspecialite(?Specialite $idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }

    public function getIdregimeinscription(): ?Regimeinscription
    {
        return $this->idregimeinscription;
    }

    public function setIdregimeinscription(?Regimeinscription $idregimeinscription): self
    {
        $this->idregimeinscription = $idregimeinscription;

        return $this;
    }

    public function getIdmodaliteenseignement(): ?Modaliteenseignement
    {
        return $this->idmodaliteenseignement;
    }

    public function setIdmodaliteenseignement(?Modaliteenseignement $idmodaliteenseignement): self
    {
        $this->idmodaliteenseignement = $idmodaliteenseignement;

        return $this;
    }

    public function getIdmodepaiement(): ?Modepaiement
    {
        return $this->idmodepaiement;
    }

    public function setIdmodepaiement(?Modepaiement $idmodepaiement): self
    {
        $this->idmodepaiement = $idmodepaiement;

        return $this;
    }

    public function getIdbourse(): ?Bourse
    {
        return $this->idbourse;
    }

    public function setIdbourse(?Bourse $idbourse): self
    {
        $this->idbourse = $idbourse;

        return $this;
    }


}
