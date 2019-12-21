<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParamPayementVacataire
 *
 * @ORM\Table(name="param_payement_vacataire", uniqueConstraints={@ORM\UniqueConstraint(name="UC_ParamPayementVacataire", columns={"idanneeacad", "idtypecours"})}, indexes={@ORM\Index(name="idanneeacad", columns={"idanneeacad", "idtypecours"}), @ORM\Index(name="idtypecours", columns={"idtypecours"})})
 * @ORM\Entity
 */
class ParamPayementVacataire
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
     * @ORM\Column(name="idanneeacad", type="integer", nullable=false)
     */
    private $idanneeacad;

    /**
     * @var int
     *
     * @ORM\Column(name="idtypecours", type="integer", nullable=false)
     */
    private $idtypecours;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdanneeacad(): ?int
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(int $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }

    public function getIdtypecours(): ?int
    {
        return $this->idtypecours;
    }

    public function setIdtypecours(int $idtypecours): self
    {
        $this->idtypecours = $idtypecours;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }


}
