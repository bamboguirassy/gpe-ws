<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seancecours
 *
 * @ORM\Table(name="seancecours", indexes={@ORM\Index(name="idAffectationcours", columns={"idAffectationcours"}), @ORM\Index(name="fk_SeanceCours_Salle1_idx", columns={"idSalle"})})
 * @ORM\Entity
 */
class Seancecours
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
     * @ORM\Column(name="idAffectationcours", type="integer", nullable=false)
     */
    private $idaffectationcours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idSalle", type="integer", nullable=true)
     */
    private $idsalle;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="heureDeb", type="datetime", nullable=true)
     */
    private $heuredeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="heureFin", type="datetime", nullable=true)
     */
    private $heurefin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observation", type="text", length=65535, nullable=true)
     */
    private $observation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_seance", type="date", nullable=false)
     */
    private $dateSeance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cadre_et_theme", type="text", length=65535, nullable=true)
     */
    private $cadreEtTheme;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_heure", type="integer", nullable=false)
     */
    private $nombreHeure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdaffectationcours(): ?int
    {
        return $this->idaffectationcours;
    }

    public function setIdaffectationcours(int $idaffectationcours): self
    {
        $this->idaffectationcours = $idaffectationcours;

        return $this;
    }

    public function getIdsalle(): ?int
    {
        return $this->idsalle;
    }

    public function setIdsalle(?int $idsalle): self
    {
        $this->idsalle = $idsalle;

        return $this;
    }

    public function getHeuredeb(): ?\DateTimeInterface
    {
        return $this->heuredeb;
    }

    public function setHeuredeb(?\DateTimeInterface $heuredeb): self
    {
        $this->heuredeb = $heuredeb;

        return $this;
    }

    public function getHeurefin(): ?\DateTimeInterface
    {
        return $this->heurefin;
    }

    public function setHeurefin(?\DateTimeInterface $heurefin): self
    {
        $this->heurefin = $heurefin;

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

    public function getDateSeance(): ?\DateTimeInterface
    {
        return $this->dateSeance;
    }

    public function setDateSeance(\DateTimeInterface $dateSeance): self
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getCadreEtTheme(): ?string
    {
        return $this->cadreEtTheme;
    }

    public function setCadreEtTheme(?string $cadreEtTheme): self
    {
        $this->cadreEtTheme = $cadreEtTheme;

        return $this;
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


}
