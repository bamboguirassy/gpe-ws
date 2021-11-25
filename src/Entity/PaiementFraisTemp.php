<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementFraisTemp
 *
 * @ORM\Table(name="paiement_frais_temp")
 * @ORM\Entity
 */
class PaiementFraisTemp
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
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="ref_command", type="string", length=150, nullable=false)
     */
    private $refCommand;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var Inscriptionacad
     *
     * @ORM\ManyToOne(targetEntity="Inscriptionacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inscriptionacad", referencedColumnName="id")
     * })
     */
    private $inscriptionacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRefCommand(): ?string
    {
        return $this->refCommand;
    }

    public function setRefCommand(string $refCommand): self
    {
        $this->refCommand = $refCommand;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getInscriptionacad(): ?Inscriptionacad
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad(int $inscriptionacad): self
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }


}
