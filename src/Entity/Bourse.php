<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bourse
 *
 * @ORM\Table(name="bourse", uniqueConstraints={@ORM\UniqueConstraint(name="codeBourse_UNIQUE", columns={"codeBourse"})})
 * @ORM\Entity
 */
class Bourse
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
     * @ORM\Column(name="codeBourse", type="string", length=45, nullable=false)
     */
    private $codebourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelleBourse", type="string", length=255, nullable=true)
     */
    private $libellebourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="natureBourse", type="string", length=255, nullable=true)
     */
    private $naturebourse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montantBourse", type="integer", nullable=true)
     */
    private $montantbourse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="periodicite", type="string", length=45, nullable=true)
     */
    private $periodicite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dureeMois", type="integer", nullable=true)
     */
    private $dureemois;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodebourse(): ?string
    {
        return $this->codebourse;
    }

    public function setCodebourse(string $codebourse): self
    {
        $this->codebourse = $codebourse;

        return $this;
    }

    public function getLibellebourse(): ?string
    {
        return $this->libellebourse;
    }

    public function setLibellebourse(?string $libellebourse): self
    {
        $this->libellebourse = $libellebourse;

        return $this;
    }

    public function getNaturebourse(): ?string
    {
        return $this->naturebourse;
    }

    public function setNaturebourse(?string $naturebourse): self
    {
        $this->naturebourse = $naturebourse;

        return $this;
    }

    public function getMontantbourse(): ?int
    {
        return $this->montantbourse;
    }

    public function setMontantbourse(?int $montantbourse): self
    {
        $this->montantbourse = $montantbourse;

        return $this;
    }

    public function getPeriodicite(): ?string
    {
        return $this->periodicite;
    }

    public function setPeriodicite(?string $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getDureemois(): ?int
    {
        return $this->dureemois;
    }

    public function setDureemois(?int $dureemois): self
    {
        $this->dureemois = $dureemois;

        return $this;
    }


}
