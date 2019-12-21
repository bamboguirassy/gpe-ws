<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typediplome
 *
 * @ORM\Table(name="typediplome")
 * @ORM\Entity
 */
class Typediplome
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
     * @ORM\Column(name="idsigesr", type="integer", nullable=false)
     */
    private $idsigesr;

    /**
     * @var string
     *
     * @ORM\Column(name="codetypediplome", type="string", length=45, nullable=false)
     */
    private $codetypediplome;

    /**
     * @var string
     *
     * @ORM\Column(name="libelletypediplome", type="string", length=100, nullable=false)
     */
    private $libelletypediplome;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdsigesr(): ?int
    {
        return $this->idsigesr;
    }

    public function setIdsigesr(int $idsigesr): self
    {
        $this->idsigesr = $idsigesr;

        return $this;
    }

    public function getCodetypediplome(): ?string
    {
        return $this->codetypediplome;
    }

    public function setCodetypediplome(string $codetypediplome): self
    {
        $this->codetypediplome = $codetypediplome;

        return $this;
    }

    public function getLibelletypediplome(): ?string
    {
        return $this->libelletypediplome;
    }

    public function setLibelletypediplome(string $libelletypediplome): self
    {
        $this->libelletypediplome = $libelletypediplome;

        return $this;
    }


}
