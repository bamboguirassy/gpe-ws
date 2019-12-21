<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ec
 *
 * @ORM\Table(name="ec", uniqueConstraints={@ORM\UniqueConstraint(name="idUe", columns={"idUe", "codeEc"})}, indexes={@ORM\Index(name="fk_Ec_Ue1_idx", columns={"idUe"})})
 * @ORM\Entity
 */
class Ec
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
     * @var string|null
     *
     * @ORM\Column(name="sigleEc", type="string", length=45, nullable=true)
     */
    private $sigleec;

    /**
     * @var string
     *
     * @ORM\Column(name="codeEc", type="string", length=45, nullable=false)
     */
    private $codeec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelleEc", type="string", length=255, nullable=true)
     */
    private $libelleec;

    /**
     * @var int
     *
     * @ORM\Column(name="coef", type="integer", nullable=false)
     */
    private $coef;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreHeureCours", type="integer", nullable=true)
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
     * @var int|null
     *
     * @ORM\Column(name="nbreHeureTotal", type="integer", nullable=true)
     */
    private $nbreheuretotal;

    /**
     * @var \Ue
     *
     * @ORM\ManyToOne(targetEntity="Ue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUe", referencedColumnName="id")
     * })
     */
    private $idue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSigleec(): ?string
    {
        return $this->sigleec;
    }

    public function setSigleec(?string $sigleec): self
    {
        $this->sigleec = $sigleec;

        return $this;
    }

    public function getCodeec(): ?string
    {
        return $this->codeec;
    }

    public function setCodeec(string $codeec): self
    {
        $this->codeec = $codeec;

        return $this;
    }

    public function getLibelleec(): ?string
    {
        return $this->libelleec;
    }

    public function setLibelleec(?string $libelleec): self
    {
        $this->libelleec = $libelleec;

        return $this;
    }

    public function getCoef(): ?int
    {
        return $this->coef;
    }

    public function setCoef(int $coef): self
    {
        $this->coef = $coef;

        return $this;
    }

    public function getNbreheurecours(): ?int
    {
        return $this->nbreheurecours;
    }

    public function setNbreheurecours(?int $nbreheurecours): self
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

    public function setNbreheuretotal(?int $nbreheuretotal): self
    {
        $this->nbreheuretotal = $nbreheuretotal;

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


}
