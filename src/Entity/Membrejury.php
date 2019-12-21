<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membrejury
 *
 * @ORM\Table(name="membrejury", indexes={@ORM\Index(name="idDeliberation", columns={"idDeliberation"}), @ORM\Index(name="fk_jurymembrejury_Enseignant1_idx", columns={"idEnseignant"})})
 * @ORM\Entity
 */
class Membrejury
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
     * @var bool
     *
     * @ORM\Column(name="ouverture", type="boolean", nullable=false)
     */
    private $ouverture = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=45, nullable=false)
     */
    private $role;

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
     * @var \Deliberation
     *
     * @ORM\ManyToOne(targetEntity="Deliberation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDeliberation", referencedColumnName="id")
     * })
     */
    private $iddeliberation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOuverture(): ?bool
    {
        return $this->ouverture;
    }

    public function setOuverture(bool $ouverture): self
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

    public function getIdenseignant(): ?Enseignant
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(?Enseignant $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
    }

    public function getIddeliberation(): ?Deliberation
    {
        return $this->iddeliberation;
    }

    public function setIddeliberation(?Deliberation $iddeliberation): self
    {
        $this->iddeliberation = $iddeliberation;

        return $this;
    }


}
