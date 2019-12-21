<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity
 */
class Profil
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
     * @ORM\Column(name="libelleProfil", type="string", length=255, nullable=false)
     */
    private $libelleprofil;

    /**
     * @var string
     *
     * @ORM\Column(name="codeProfil", type="string", length=255, nullable=false)
     */
    private $codeprofil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleprofil(): ?string
    {
        return $this->libelleprofil;
    }

    public function setLibelleprofil(string $libelleprofil): self
    {
        $this->libelleprofil = $libelleprofil;

        return $this;
    }

    public function getCodeprofil(): ?string
    {
        return $this->codeprofil;
    }

    public function setCodeprofil(string $codeprofil): self
    {
        $this->codeprofil = $codeprofil;

        return $this;
    }


}
