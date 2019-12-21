<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecanneeacad
 *
 * @ORM\Table(name="ecanneeacad", uniqueConstraints={@ORM\UniqueConstraint(name="unicite", columns={"idEc", "idAnneeacad"})}, indexes={@ORM\Index(name="idEc", columns={"idEc"}), @ORM\Index(name="idAnneeacad", columns={"idAnneeacad"})})
 * @ORM\Entity
 */
class Ecanneeacad
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
     * @ORM\Column(name="libelleEc", type="string", length=255, nullable=false)
     */
    private $libelleec;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreHeureCours", type="integer", nullable=false)
     */
    private $nbreheurecours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreHeureTP", type="integer", nullable=true)
     */
    private $nbreheuretp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreHeureTD", type="integer", nullable=true)
     */
    private $nbreheuretd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreTPE", type="integer", nullable=true)
     */
    private $nbretpe;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreHeureTotal", type="integer", nullable=false)
     */
    private $nbreheuretotal;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="validation_cours_ec", type="boolean", nullable=true)
     */
    private $validationCoursEc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sigle", type="string", length=30, nullable=true)
     */
    private $sigle;

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
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeacad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleec(): ?string
    {
        return $this->libelleec;
    }

    public function setLibelleec(string $libelleec): self
    {
        $this->libelleec = $libelleec;

        return $this;
    }

    public function getNbreheurecours(): ?int
    {
        return $this->nbreheurecours;
    }

    public function setNbreheurecours(int $nbreheurecours): self
    {
        $this->nbreheurecours = $nbreheurecours;

        return $this;
    }

    public function getNbreheuretp(): ?int
    {
        return $this->nbreheuretp;
    }

    public function setNbreheuretp(?int $nbreheuretp): self
    {
        $this->nbreheuretp = $nbreheuretp;

        return $this;
    }

    public function getNbreheuretd(): ?int
    {
        return $this->nbreheuretd;
    }

    public function setNbreheuretd(?int $nbreheuretd): self
    {
        $this->nbreheuretd = $nbreheuretd;

        return $this;
    }

    public function getNbretpe(): ?int
    {
        return $this->nbretpe;
    }

    public function setNbretpe(?int $nbretpe): self
    {
        $this->nbretpe = $nbretpe;

        return $this;
    }

    public function getNbreheuretotal(): ?int
    {
        return $this->nbreheuretotal;
    }

    public function setNbreheuretotal(int $nbreheuretotal): self
    {
        $this->nbreheuretotal = $nbreheuretotal;

        return $this;
    }

    public function getValidationCoursEc(): ?bool
    {
        return $this->validationCoursEc;
    }

    public function setValidationCoursEc(?bool $validationCoursEc): self
    {
        $this->validationCoursEc = $validationCoursEc;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(?string $sigle): self
    {
        $this->sigle = $sigle;

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

    public function getIdanneeacad(): ?Anneeacad
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(?Anneeacad $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }


}
