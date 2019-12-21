<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semestre
 *
 * @ORM\Table(name="semestre", uniqueConstraints={@ORM\UniqueConstraint(name="codeSemestre_UNIQUE", columns={"codeSemestre"})}, indexes={@ORM\Index(name="FK_semestre_niveau", columns={"idNiveau"})})
 * @ORM\Entity
 */
class Semestre
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
     * @ORM\Column(name="idNiveau", type="integer", nullable=false)
     */
    private $idniveau;

    /**
     * @var string
     *
     * @ORM\Column(name="codeSemestre", type="string", length=255, nullable=false)
     */
    private $codesemestre;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleSemestre", type="string", length=255, nullable=false)
     */
    private $libellesemestre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdniveau(): ?int
    {
        return $this->idniveau;
    }

    public function setIdniveau(int $idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }

    public function getCodesemestre(): ?string
    {
        return $this->codesemestre;
    }

    public function setCodesemestre(string $codesemestre): self
    {
        $this->codesemestre = $codesemestre;

        return $this;
    }

    public function getLibellesemestre(): ?string
    {
        return $this->libellesemestre;
    }

    public function setLibellesemestre(string $libellesemestre): self
    {
        $this->libellesemestre = $libellesemestre;

        return $this;
    }


}
