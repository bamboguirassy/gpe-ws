<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responsablecours
 *
 * @ORM\Table(name="responsablecours", uniqueConstraints={@ORM\UniqueConstraint(name="idEc", columns={"idEc", "idEnseignant", "idAnneeAcad"})}, indexes={@ORM\Index(name="fk_ResponsableCours_ElementConstitutif1_idx", columns={"idEc"}), @ORM\Index(name="fk_ResponsableCours_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_ResponsableCours_Enseignant1_idx", columns={"idEnseignant"})})
 * @ORM\Entity
 */
class Responsablecours
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
     * @ORM\Column(name="idEc", type="integer", nullable=false)
     */
    private $idec;

    /**
     * @var int
     *
     * @ORM\Column(name="idEnseignant", type="integer", nullable=false)
     */
    private $idenseignant;

    /**
     * @var int
     *
     * @ORM\Column(name="idAnneeAcad", type="integer", nullable=false)
     */
    private $idanneeacad;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDeb", type="date", nullable=true)
     */
    private $datedeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation", type="text", length=65535, nullable=true)
     */
    private $observation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdec(): ?int
    {
        return $this->idec;
    }

    public function setIdec(int $idec): self
    {
        $this->idec = $idec;

        return $this;
    }

    public function getIdenseignant(): ?int
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(int $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

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

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(?\DateTimeInterface $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }


}
