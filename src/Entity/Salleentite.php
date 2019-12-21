<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salleentite
 *
 * @ORM\Table(name="salleentite", indexes={@ORM\Index(name="idsalle", columns={"idsalle"}), @ORM\Index(name="identite", columns={"identite"})})
 * @ORM\Entity
 */
class Salleentite
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
     * @ORM\Column(name="identite", type="integer", nullable=false)
     */
    private $identite;

    /**
     * @var int
     *
     * @ORM\Column(name="idsalle", type="integer", nullable=false)
     */
    private $idsalle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentite(): ?int
    {
        return $this->identite;
    }

    public function setIdentite(int $identite): self
    {
        $this->identite = $identite;

        return $this;
    }

    public function getIdsalle(): ?int
    {
        return $this->idsalle;
    }

    public function setIdsalle(int $idsalle): self
    {
        $this->idsalle = $idsalle;

        return $this;
    }


}
