<?php

namespace App\Entity;

use App\Repository\PaiementFraisEncadrementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaiementFraisEncadrementRepository::class)
 */
class PaiementFraisEncadrement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePaiement;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantPaye;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $methodePaiement;

    /**
     * @ORM\ManyToOne(targetEntity=Inscriptionacad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscriptionacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getMontantPaye(): ?int
    {
        return $this->montantPaye;
    }

    public function setMontantPaye(int $montantPaye): self
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    public function getMethodePaiement(): ?string
    {
        return $this->methodePaiement;
    }

    public function setMethodePaiement(string $methodePaiement): self
    {
        $this->methodePaiement = $methodePaiement;

        return $this;
    }

    public function getInscriptionacad(): ?Inscriptionacad
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad(?Inscriptionacad $inscriptionacad): self
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }
}
