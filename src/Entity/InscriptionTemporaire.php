<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionTemporaire
 *
 * @ORM\Table(name="inscription_temporaire", uniqueConstraints={@ORM\UniqueConstraint(name="idClasse", columns={"idClasse", "idEtudiant"})}, indexes={@ORM\Index(name="fk_InscriptionAcad_Specialite1_idx", columns={"idSpecialite"}), @ORM\Index(name="fk_InscriptionAcad_ModaliteEnseignement1_idx", columns={"idModaliteEnseignement"}), @ORM\Index(name="fk_InscriptionAcad_ModePaiement1_idx", columns={"idModePaiement"}), @ORM\Index(name="fk_Inscription_Bourse1_idx", columns={"idBourse"}), @ORM\Index(name="fk_inscriptionacad_etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_InscriptionAcad_RegimeInscription1_idx", columns={"idRegimeInscription"}), @ORM\Index(name="fk_InscriptionAcad_Classe1_idx", columns={"idClasse"})})
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
     * @var int
     *
     * @ORM\Column(name="idClasse", type="integer", nullable=false)
     */
    private $idclasse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idSpecialite", type="integer", nullable=true)
     */
    private $idspecialite;

    /**
     * @var int
     *
     * @ORM\Column(name="idRegimeInscription", type="integer", nullable=false)
     */
    private $idregimeinscription;

    /**
     * @var int
     *
     * @ORM\Column(name="idModaliteEnseignement", type="integer", nullable=false)
     */
    private $idmodaliteenseignement;

    /**
     * @var int
     *
     * @ORM\Column(name="idEtudiant", type="integer", nullable=false)
     */
    private $idetudiant;

    /**
     * @var int
     *
     * @ORM\Column(name="idBourse", type="integer", nullable=false)
     */
    private $idbourse;

    /**
     * @var string
     *
     * @ORM\Column(name="passage", type="string", length=45, nullable=false)
     */
    private $passage;

    /**
     * @var int
     *
     * @ORM\Column(name="idModePaiement", type="integer", nullable=false)
     */
    private $idmodepaiement;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdclasse(): ?int
    {
        return $this->idclasse;
    }

    public function setIdclasse(int $idclasse): self
    {
        $this->idclasse = $idclasse;

        return $this;
    }

    public function getIdspecialite(): ?int
    {
        return $this->idspecialite;
    }

    public function setIdspecialite(?int $idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }

    public function getIdregimeinscription(): ?int
    {
        return $this->idregimeinscription;
    }

    public function setIdregimeinscription(int $idregimeinscription): self
    {
        $this->idregimeinscription = $idregimeinscription;

        return $this;
    }

    public function getIdmodaliteenseignement(): ?int
    {
        return $this->idmodaliteenseignement;
    }

    public function setIdmodaliteenseignement(int $idmodaliteenseignement): self
    {
        $this->idmodaliteenseignement = $idmodaliteenseignement;

        return $this;
    }

    public function getIdetudiant(): ?int
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(int $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getIdbourse(): ?int
    {
        return $this->idbourse;
    }

    public function setIdbourse(int $idbourse): self
    {
        $this->idbourse = $idbourse;

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

    public function getIdmodepaiement(): ?int
    {
        return $this->idmodepaiement;
    }

    public function setIdmodepaiement(int $idmodepaiement): self
    {
        $this->idmodepaiement = $idmodepaiement;

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


}
