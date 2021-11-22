<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementFraisEncadrement
 *
 * @ORM\Table(name="paiement_frais_encadrement")
 * @ORM\Entity
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
     * @ORM\Column(name="methode_paiement_id" ,type="string", length=255)
     */
    private $methodePaiement;

    /**
     * @ORM\ManyToOne(targetEntity=Inscriptionacad::class)
     * @ORM\JoinColumn(name="inscriptionacad_id", nullable=false)
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
