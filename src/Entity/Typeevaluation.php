<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeevaluation
 *
 * @ORM\Table(name="typeevaluation", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeEvaluation_UNIQUE", columns={"codeTypeEvaluation"})})
 * @ORM\Entity
 */
class Typeevaluation
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
     * @ORM\Column(name="codeTypeEvaluation", type="string", length=45, nullable=false)
     */
    private $codetypeevaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeEvaluation", type="string", length=255, nullable=false)
     */
    private $libelletypeevaluation;

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

    public function getCodetypeevaluation(): ?string
    {
        return $this->codetypeevaluation;
    }

    public function setCodetypeevaluation(string $codetypeevaluation): self
    {
        $this->codetypeevaluation = $codetypeevaluation;

        return $this;
    }

    public function getLibelletypeevaluation(): ?string
    {
        return $this->libelletypeevaluation;
    }

    public function setLibelletypeevaluation(string $libelletypeevaluation): self
    {
        $this->libelletypeevaluation = $libelletypeevaluation;

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
