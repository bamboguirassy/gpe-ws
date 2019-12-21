<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moyenneec
 *
 * @ORM\Table(name="moyenneec", uniqueConstraints={@ORM\UniqueConstraint(name="idEtudiant", columns={"idEtudiant", "idEc", "idSession", "idAnneeAcad"})}, indexes={@ORM\Index(name="fk_MoyenneEc_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_MoyenneEc_Ec1_idx", columns={"idEc"}), @ORM\Index(name="fk_MoyenneEc_Session1_idx", columns={"idSession"}), @ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="fk_MoyenneEc_Etudiant1_idx", columns={"idEtudiant"})})
 * @ORM\Entity
 */
class Moyenneec
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
     * @var float|null
     *
     * @ORM\Column(name="moyenne", type="float", precision=10, scale=0, nullable=true)
     */
    private $moyenne;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="repeche", type="boolean", nullable=true)
     */
    private $repeche;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datemodification", type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remarque", type="text", length=0, nullable=true)
     */
    private $remarque;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estvalide", type="boolean", nullable=true)
     */
    private $estvalide;

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
     * @var \Ec
     *
     * @ORM\ManyToOne(targetEntity="Ec")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEc", referencedColumnName="id")
     * })
     */
    private $idec;

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
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSession", referencedColumnName="id")
     * })
     */
    private $idsession;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(?float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getRepeche(): ?bool
    {
        return $this->repeche;
    }

    public function setRepeche(?bool $repeche): self
    {
        $this->repeche = $repeche;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getEstvalide(): ?bool
    {
        return $this->estvalide;
    }

    public function setEstvalide(?bool $estvalide): self
    {
        $this->estvalide = $estvalide;

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

    public function getIdec(): ?Ec
    {
        return $this->idec;
    }

    public function setIdec(?Ec $idec): self
    {
        $this->idec = $idec;

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

    public function getIdsession(): ?Session
    {
        return $this->idsession;
    }

    public function setIdsession(?Session $idsession): self
    {
        $this->idsession = $idsession;

        return $this;
    }

    public function getIduser(): ?FosUser
    {
        return $this->iduser;
    }

    public function setIduser(?FosUser $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
