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

    public function getId()
    {
        return $this->id;
    }

    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getMontantPaye()
    {
        return $this->montantPaye;
    }

    public function setMontantPaye(int $montantPaye)
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    public function getMethodePaiement()
    {
        return $this->methodePaiement;
    }

    public function setMethodePaiement(string $methodePaiement)
    {
        $this->methodePaiement = $methodePaiement;

        return $this;
    }

    public function getInscriptionacad()
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad($inscriptionacad)
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }
}
