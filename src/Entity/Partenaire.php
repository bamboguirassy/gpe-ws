<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire
 *
 * @ORM\Table(name="partenaire", indexes={@ORM\Index(name="idanneeacad", columns={"idanneeacad"})})
 * @ORM\Entity
 */
class Partenaire
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
     * @ORM\Column(name="idanneeacad", type="integer", nullable=false)
     */
    private $idanneeacad;

    /**
     * @var string
     *
     * @ORM\Column(name="codepart", type="string", length=45, nullable=false)
     */
    private $codepart;

    /**
     * @var string
     *
     * @ORM\Column(name="libellepart", type="string", length=255, nullable=false)
     */
    private $libellepart;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCodepart(): ?string
    {
        return $this->codepart;
    }

    public function setCodepart(string $codepart): self
    {
        $this->codepart = $codepart;

        return $this;
    }

    public function getLibellepart(): ?string
    {
        return $this->libellepart;
    }

    public function setLibellepart(string $libellepart): self
    {
        $this->libellepart = $libellepart;

        return $this;
    }


}
