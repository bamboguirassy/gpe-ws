<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typecours
 *
 * @ORM\Table(name="typecours", uniqueConstraints={@ORM\UniqueConstraint(name="codeTypeCours_UNIQUE", columns={"codeTypeCours"})})
 * @ORM\Entity
 */
class Typecours
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
     * @ORM\Column(name="codeTypeCours", type="string", length=45, nullable=false)
     */
    private $codetypecours;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTypeCours", type="string", length=255, nullable=false)
     */
    private $libelletypecours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodetypecours(): ?string
    {
        return $this->codetypecours;
    }

    public function setCodetypecours(string $codetypecours): self
    {
        $this->codetypecours = $codetypecours;

        return $this;
    }

    public function getLibelletypecours(): ?string
    {
        return $this->libelletypecours;
    }

    public function setLibelletypecours(string $libelletypecours): self
    {
        $this->libelletypecours = $libelletypecours;

        return $this;
    }


}
