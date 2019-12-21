<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeue
 *
 * @ORM\Table(name="typeue", uniqueConstraints={@ORM\UniqueConstraint(name="codeTyeUe_UNIQUE", columns={"codeTypeUe"})})
 * @ORM\Entity
 */
class Typeue
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
     * @ORM\Column(name="codeTypeUe", type="string", length=255, nullable=false)
     */
    private $codetypeue;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeUe", type="string", length=255, nullable=false)
     */
    private $libelletypeue;

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

    public function getCodetypeue(): ?string
    {
        return $this->codetypeue;
    }

    public function setCodetypeue(string $codetypeue): self
    {
        $this->codetypeue = $codetypeue;

        return $this;
    }

    public function getLibelletypeue(): ?string
    {
        return $this->libelletypeue;
    }

    public function setLibelletypeue(string $libelletypeue): self
    {
        $this->libelletypeue = $libelletypeue;

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
