<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typefiliere
 *
 * @ORM\Table(name="typefiliere", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeFiliere_UNIQUE", columns={"codeTypeFiliere"})})
 * @ORM\Entity
 */
class Typefiliere
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
     * @ORM\Column(name="codeTypeFiliere", type="string", length=45, nullable=false)
     */
    private $codetypefiliere;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeFiliere", type="string", length=255, nullable=false)
     */
    private $libelletypefiliere;

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

    public function getCodetypefiliere(): ?string
    {
        return $this->codetypefiliere;
    }

    public function setCodetypefiliere(string $codetypefiliere): self
    {
        $this->codetypefiliere = $codetypefiliere;

        return $this;
    }

    public function getLibelletypefiliere(): ?string
    {
        return $this->libelletypefiliere;
    }

    public function setLibelletypefiliere(string $libelletypefiliere): self
    {
        $this->libelletypefiliere = $libelletypefiliere;

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
