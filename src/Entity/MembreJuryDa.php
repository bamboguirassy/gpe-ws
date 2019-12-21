<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembreJuryDa
 *
 * @ORM\Table(name="membre_jury_da", indexes={@ORM\Index(name="iddeliberationannuelle", columns={"iddeliberationannuelle"}), @ORM\Index(name="idenseignant", columns={"idenseignant"})})
 * @ORM\Entity
 */
class MembreJuryDa
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
     * @ORM\Column(name="idenseignant", type="integer", nullable=false)
     */
    private $idenseignant;

    /**
     * @var int
     *
     * @ORM\Column(name="iddeliberationannuelle", type="integer", nullable=false)
     */
    private $iddeliberationannuelle;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ouverture", type="boolean", nullable=true)
     */
    private $ouverture = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=45, nullable=false)
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdenseignant(): ?int
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(int $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
    }

    public function getIddeliberationannuelle(): ?int
    {
        return $this->iddeliberationannuelle;
    }

    public function setIddeliberationannuelle(int $iddeliberationannuelle): self
    {
        $this->iddeliberationannuelle = $iddeliberationannuelle;

        return $this;
    }

    public function getOuverture(): ?bool
    {
        return $this->ouverture;
    }

    public function setOuverture(?bool $ouverture): self
    {
        $this->ouverture = $ouverture;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


}
