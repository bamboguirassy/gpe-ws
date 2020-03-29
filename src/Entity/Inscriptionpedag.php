<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscriptionpedag
 *
 * @ORM\Table(name="inscriptionpedag", uniqueConstraints={@ORM\UniqueConstraint(name="idAnneeAcad", columns={"idAnneeAcad", "idUe", "idEtudiant"})}, indexes={@ORM\Index(name="fk_InscriptionPedag_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_inscriptionpedag_etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_InscriptionPedag_Ue1_idx", columns={"idUe"}), @ORM\Index(name="idinscriptionacad", columns={"idinscriptionacad"})})
 * @ORM\Entity
 */
class Inscriptionpedag
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
     * @ORM\Column(name="dateInscriptionPedag", type="datetime", nullable=true)
     */
    private $dateinscriptionpedag;

    /**
     * @var bool
     *
     * @ORM\Column(name="passage", type="boolean", nullable=false)
     */
    private $passage;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean", nullable=false)
     */
    private $valide;

    /**
     * @var float|null
     *
     * @ORM\Column(name="moyenneObtenue", type="float", precision=10, scale=0, nullable=true)
     */
    private $moyenneobtenue;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeAcad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    /**
     * @var \Ue
     *
     * @ORM\ManyToOne(targetEntity="Ue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUe", referencedColumnName="id")
     * })
     */
    private $idue;

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
     * @var \Inscriptionacad
     *
     * @ORM\ManyToOne(targetEntity="Inscriptionacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idinscriptionacad", referencedColumnName="id")
     * })
     */
    private $idinscriptionacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateinscriptionpedag(): ?\DateTimeInterface
    {
        return $this->dateinscriptionpedag;
    }

    public function setDateinscriptionpedag(?\DateTimeInterface $dateinscriptionpedag): self
    {
        $this->dateinscriptionpedag = $dateinscriptionpedag;

        return $this;
    }

    public function getPassage(): ?bool
    {
        return $this->passage;
    }

    public function setPassage(bool $passage): self
    {
        $this->passage = $passage;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getMoyenneobtenue(): ?float
    {
        return $this->moyenneobtenue;
    }

    public function setMoyenneobtenue(?float $moyenneobtenue): self
    {
        $this->moyenneobtenue = $moyenneobtenue;

        return $this;
    }

    public function getIdanneeacad(): ?Anneeacad
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(?Anneeacad $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }

    public function getIdue(): ?Ue
    {
        return $this->idue;
    }

    public function setIdue(?Ue $idue): self
    {
        $this->idue = $idue;

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

    public function getIdinscriptionacad(): ?Inscriptionacad
    {
        return $this->idinscriptionacad;
    }

    public function setIdinscriptionacad(?Inscriptionacad $idinscriptionacad): self
    {
        $this->idinscriptionacad = $idinscriptionacad;

        return $this;
    }


}
