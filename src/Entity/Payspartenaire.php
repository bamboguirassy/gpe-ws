<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payspartenaire
 *
 * @ORM\Table(name="payspartenaire", uniqueConstraints={@ORM\UniqueConstraint(name="idpays", columns={"idpays", "idpart"})}, indexes={@ORM\Index(name="idpart", columns={"idpart"}), @ORM\Index(name="idpays_2", columns={"idpays"})})
 * @ORM\Entity
 */
class Payspartenaire
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
     * @ORM\Column(name="idpays", type="integer", nullable=false)
     */
    private $idpays;

    /**
     * @var int
     *
     * @ORM\Column(name="idpart", type="integer", nullable=false)
     */
    private $idpart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdpays(): ?int
    {
        return $this->idpays;
    }

    public function setIdpays(int $idpays): self
    {
        $this->idpays = $idpays;

        return $this;
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


}
