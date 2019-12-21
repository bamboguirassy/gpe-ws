<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parampaiement
 *
 * @ORM\Table(name="parampaiement", uniqueConstraints={@ORM\UniqueConstraint(name="idpart_2", columns={"idpart", "idniveau"})}, indexes={@ORM\Index(name="idniveau", columns={"idniveau"}), @ORM\Index(name="idpart", columns={"idpart"})})
 * @ORM\Entity
 */
class Parampaiement
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
     * @ORM\Column(name="idpart", type="integer", nullable=false)
     */
    private $idpart;

    /**
     * @var int
     *
     * @ORM\Column(name="idniveau", type="integer", nullable=false)
     */
    private $idniveau;

    /**
     * @var int
     *
     * @ORM\Column(name="dip", type="bigint", nullable=false)
     */
    private $dip;

    /**
     * @var int
     *
     * @ORM\Column(name="dia", type="bigint", nullable=false)
     */
    private $dia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdpart(): ?int
    {
        return $this->idpart;
    }

    public function setIdpart(int $idpart): self
    {
        $this->idpart = $idpart;

        return $this;
    }

    public function getIdniveau(): ?int
    {
        return $this->idniveau;
    }

    public function setIdniveau(int $idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }

    public function getDip(): ?string
    {
        return $this->dip;
    }

    public function setDip(string $dip): self
    {
        $this->dip = $dip;

        return $this;
    }

    public function getDia(): ?string
    {
        return $this->dia;
    }

    public function setDia(string $dia): self
    {
        $this->dia = $dia;

        return $this;
    }


}
