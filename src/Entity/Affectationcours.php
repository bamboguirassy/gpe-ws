<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affectationcours
 *
 * @ORM\Table(name="affectationcours", uniqueConstraints={@ORM\UniqueConstraint(name="AffectationEnseignantGrpUnique", columns={"idGroupe", "idEnseignant"})}, indexes={@ORM\Index(name="idGroupe", columns={"idGroupe"}), @ORM\Index(name="idEnseignant", columns={"idEnseignant"})})
 * @ORM\Entity
 */
class Affectationcours
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
     * @ORM\Column(name="dateAffectationCours", type="date", nullable=true)
     */
    private $dateaffectationcours;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="validee", type="boolean", nullable=true)
     */
    private $validee;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_validation", type="datetime", nullable=true)
     */
    private $dateValidation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_validation", type="string", length=200, nullable=true)
     */
    private $userValidation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nombre_heure", type="integer", nullable=true)
     */
    private $nombreHeure;

    /**
     * @var \Enseignant
     *
     * @ORM\ManyToOne(targetEntity="Enseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEnseignant", referencedColumnName="id")
     * })
     */
    private $idenseignant;

    /**
     * @var \Groupe
     *
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idGroupe", referencedColumnName="id")
     * })
     */
    private $idgroupe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateaffectationcours(): ?\DateTimeInterface
    {
        return $this->dateaffectationcours;
    }

    public function setDateaffectationcours(?\DateTimeInterface $dateaffectationcours): self
    {
        $this->dateaffectationcours = $dateaffectationcours;

        return $this;
    }

    public function getValidee(): ?bool
    {
        return $this->validee;
    }

    public function setValidee(?bool $validee): self
    {
        $this->validee = $validee;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $dateValidation): self
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function getUserValidation(): ?string
    {
        return $this->userValidation;
    }

    public function setUserValidation(?string $userValidation): self
    {
        $this->userValidation = $userValidation;

        return $this;
    }

    public function getNombreHeure(): ?int
    {
        return $this->nombreHeure;
    }

    public function setNombreHeure(?int $nombreHeure): self
    {
        $this->nombreHeure = $nombreHeure;

        return $this;
    }

    public function getIdenseignant(): ?Enseignant
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(?Enseignant $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
    }

    public function getIdgroupe(): ?Groupe
    {
        return $this->idgroupe;
    }

    public function setIdgroupe(?Groupe $idgroupe): self
    {
        $this->idgroupe = $idgroupe;

        return $this;
    }


}
