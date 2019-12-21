<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responsabilite
 *
 * @ORM\Table(name="responsabilite", indexes={@ORM\Index(name="fk_Responsabilite_Enseignant1_idx", columns={"idEnseignant"}), @ORM\Index(name="fk_Responsabilite_Entite1_idx", columns={"idEntite"})})
 * @ORM\Entity
 */
class Responsabilite
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
     * @ORM\Column(name="idEntite", type="integer", nullable=false)
     */
    private $identite;

    /**
     * @var int
     *
     * @ORM\Column(name="idEnseignant", type="integer", nullable=false)
     */
    private $idenseignant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeb", type="date", nullable=false)
     */
    private $datedeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="titreResponsabilite", type="string", length=45, nullable=false)
     */
    private $titreresponsabilite;

    /**
     * @var bool
     *
     * @ORM\Column(name="enCours", type="boolean", nullable=false)
     */
    private $encours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentite(): ?int
    {
        return $this->identite;
    }

    public function setIdentite(int $identite): self
    {
        $this->identite = $identite;

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

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(\DateTimeInterface $datedeb): self
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

    public function getTitreresponsabilite(): ?string
    {
        return $this->titreresponsabilite;
    }

    public function setTitreresponsabilite(string $titreresponsabilite): self
    {
        $this->titreresponsabilite = $titreresponsabilite;

        return $this;
    }

    public function getEncours(): ?bool
    {
        return $this->encours;
    }

    public function setEncours(bool $encours): self
    {
        $this->encours = $encours;

        return $this;
    }


}
