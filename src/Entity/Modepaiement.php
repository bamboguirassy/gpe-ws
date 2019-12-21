<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modepaiement
 *
 * @ORM\Table(name="modepaiement", uniqueConstraints={@ORM\UniqueConstraint(name="codeModePaiement_UNIQUE", columns={"codeModePaiement"})})
 * @ORM\Entity
 */
class Modepaiement
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
     * @ORM\Column(name="codeModePaiement", type="string", length=45, nullable=false)
     */
    private $codemodepaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleModePaiement", type="string", length=255, nullable=false)
     */
    private $libellemodepaiement;

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

    public function getCodemodepaiement(): ?string
    {
        return $this->codemodepaiement;
    }

    public function setCodemodepaiement(string $codemodepaiement): self
    {
        $this->codemodepaiement = $codemodepaiement;

        return $this;
    }

    public function getLibellemodepaiement(): ?string
    {
        return $this->libellemodepaiement;
    }

    public function setLibellemodepaiement(string $libellemodepaiement): self
    {
        $this->libellemodepaiement = $libellemodepaiement;

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
