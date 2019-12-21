<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence", indexes={@ORM\Index(name="idetudiant", columns={"idetudiant"}), @ORM\Index(name="idseance", columns={"idseance"})})
 * @ORM\Entity
 */
class Absence
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
     * @ORM\Column(name="nombre_heure", type="integer", nullable=false)
     */
    private $nombreHeure;

    /**
     * @var string
     *
     * @ORM\Column(name="type_absence", type="string", length=22, nullable=false)
     */
    private $typeAbsence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation", type="text", length=65535, nullable=true)
     */
    private $observation;

    /**
     * @var \Seancecours
     *
     * @ORM\ManyToOne(targetEntity="Seancecours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idseance", referencedColumnName="id")
     * })
     */
    private $idseance;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idetudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreHeure(): ?int
    {
        return $this->nombreHeure;
    }

    public function setNombreHeure(int $nombreHeure): self
    {
        $this->nombreHeure = $nombreHeure;

        return $this;
    }

    public function getTypeAbsence(): ?string
    {
        return $this->typeAbsence;
    }

    public function setTypeAbsence(string $typeAbsence): self
    {
        $this->typeAbsence = $typeAbsence;

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

    public function getIdseance(): ?Seancecours
    {
        return $this->idseance;
    }

    public function setIdseance(?Seancecours $idseance): self
    {
        $this->idseance = $idseance;

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


}
