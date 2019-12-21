<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responsabilitefiliere
 *
 * @ORM\Table(name="responsabilitefiliere", indexes={@ORM\Index(name="fk_Responsabilitefiliere_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="fk_Responsabilitefiliere_Enseignant1_idx", columns={"idEnseignant"})})
 * @ORM\Entity
 */
class Responsabilitefiliere
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
     * @ORM\Column(name="date_deb", type="date", nullable=false)
     */
    private $dateDeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var bool
     *
     * @ORM\Column(name="enCours", type="boolean", nullable=false, options={"default"="1"})
     */
    private $encours = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="idEnseignant", type="integer", nullable=false)
     */
    private $idenseignant;

    /**
     * @var int
     *
     * @ORM\Column(name="idFiliere", type="integer", nullable=false)
     */
    private $idfiliere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

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

    public function getIdenseignant(): ?int
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(int $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
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


}
