<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ueanneeacad
 *
 * @ORM\Table(name="ueanneeacad", uniqueConstraints={@ORM\UniqueConstraint(name="idue_2", columns={"idue", "idanneeacad"})}, indexes={@ORM\Index(name="idanneeacad", columns={"idanneeacad"}), @ORM\Index(name="idue", columns={"idue"})})
 * @ORM\Entity
 */
class Ueanneeacad
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
     * @ORM\Column(name="idue", type="integer", nullable=false)
     */
    private $idue;

    /**
     * @var int
     *
     * @ORM\Column(name="idanneeacad", type="integer", nullable=false)
     */
    private $idanneeacad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SigleUe", type="string", length=45, nullable=true)
     */
    private $sigleue;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleUe", type="string", length=255, nullable=false)
     */
    private $libelleue;

    /**
     * @var int
     *
     * @ORM\Column(name="credit", type="integer", nullable=false)
     */
    private $credit;

    /**
     * @var int
     *
     * @ORM\Column(name="coef", type="integer", nullable=false)
     */
    private $coef;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdue(): ?int
    {
        return $this->idue;
    }

    public function setIdue(int $idue): self
    {
        $this->idue = $idue;

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

    public function getSigleue(): ?string
    {
        return $this->sigleue;
    }

    public function setSigleue(?string $sigleue): self
    {
        $this->sigleue = $sigleue;

        return $this;
    }

    public function getLibelleue(): ?string
    {
        return $this->libelleue;
    }

    public function setLibelleue(string $libelleue): self
    {
        $this->libelleue = $libelleue;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
