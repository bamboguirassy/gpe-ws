<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeadmission
 *
 * @ORM\Table(name="typeadmission", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeAdmission_UNIQUE", columns={"codeTypeAdmission"})})
 * @ORM\Entity
 */
class Typeadmission
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
     * @ORM\Column(name="codeTypeAdmission", type="string", length=255, nullable=false)
     */
    private $codetypeadmission;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeAdmission", type="string", length=255, nullable=false)
     */
    private $libelletypeadmission;

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

    public function getCodetypeadmission(): ?string
    {
        return $this->codetypeadmission;
    }

    public function setCodetypeadmission(string $codetypeadmission): self
    {
        $this->codetypeadmission = $codetypeadmission;

        return $this;
    }

    public function getLibelletypeadmission(): ?string
    {
        return $this->libelletypeadmission;
    }

    public function setLibelletypeadmission(string $libelletypeadmission): self
    {
        $this->libelletypeadmission = $libelletypeadmission;

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
