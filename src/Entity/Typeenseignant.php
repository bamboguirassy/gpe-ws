<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeenseignant
 *
 * @ORM\Table(name="typeenseignant", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeEnseignant_UNIQUE", columns={"codeTypeEnseignant"})})
 * @ORM\Entity
 */
class Typeenseignant
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
     * @ORM\Column(name="codeTypeEnseignant", type="string", length=45, nullable=false)
     */
    private $codetypeenseignant;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeEnseignant", type="string", length=255, nullable=false)
     */
    private $libelletypeenseignant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodetypeenseignant(): ?string
    {
        return $this->codetypeenseignant;
    }

    public function setCodetypeenseignant(string $codetypeenseignant): self
    {
        $this->codetypeenseignant = $codetypeenseignant;

        return $this;
    }

    public function getLibelletypeenseignant(): ?string
    {
        return $this->libelletypeenseignant;
    }

    public function setLibelletypeenseignant(string $libelletypeenseignant): self
    {
        $this->libelletypeenseignant = $libelletypeenseignant;

        return $this;
    }


}
