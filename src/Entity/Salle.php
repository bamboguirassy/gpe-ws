<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle", uniqueConstraints={@ORM\UniqueConstraint(name="codeSalle_UNIQUE", columns={"codeSalle"})}, indexes={@ORM\Index(name="fk_Salle_Site1_idx", columns={"idSite"})})
 * @ORM\Entity
 */
class Salle
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
     * @ORM\Column(name="idSite", type="integer", nullable=false)
     */
    private $idsite;

    /**
     * @var string
     *
     * @ORM\Column(name="codeSalle", type="string", length=45, nullable=false)
     */
    private $codesalle;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleSalle", type="string", length=255, nullable=false)
     */
    private $libellesalle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbrePlaceMax", type="integer", nullable=true)
     */
    private $nbreplacemax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdsite(): ?int
    {
        return $this->idsite;
    }

    public function setIdsite(int $idsite): self
    {
        $this->idsite = $idsite;

        return $this;
    }

    public function getCodesalle(): ?string
    {
        return $this->codesalle;
    }

    public function setCodesalle(string $codesalle): self
    {
        $this->codesalle = $codesalle;

        return $this;
    }

    public function getLibellesalle(): ?string
    {
        return $this->libellesalle;
    }

    public function setLibellesalle(string $libellesalle): self
    {
        $this->libellesalle = $libellesalle;

        return $this;
    }

    public function getNbreplacemax(): ?int
    {
        return $this->nbreplacemax;
    }

    public function setNbreplacemax(?int $nbreplacemax): self
    {
        $this->nbreplacemax = $nbreplacemax;

        return $this;
    }


}
