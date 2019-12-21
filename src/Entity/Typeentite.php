<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeentite
 *
 * @ORM\Table(name="typeentite", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeEntite_UNIQUE", columns={"codeTypeEntite"})})
 * @ORM\Entity
 */
class Typeentite
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
     * @ORM\Column(name="codeTypeEntite", type="string", length=45, nullable=false)
     */
    private $codetypeentite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeEntite", type="string", length=255, nullable=false)
     */
    private $libelletypeentite;

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

    public function getCodetypeentite(): ?string
    {
        return $this->codetypeentite;
    }

    public function setCodetypeentite(string $codetypeentite): self
    {
        $this->codetypeentite = $codetypeentite;

        return $this;
    }

    public function getLibelletypeentite(): ?string
    {
        return $this->libelletypeentite;
    }

    public function setLibelletypeentite(string $libelletypeentite): self
    {
        $this->libelletypeentite = $libelletypeentite;

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
