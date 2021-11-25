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
     * @ORM\ManyToOne(targetEntity=Inscriptionacad::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscriptionacad;

    /**
     * @ORM\OneToOne(targetEntity=Modepaiement::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $methodePaiement;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operateur;

    public function getId()
    {
        return $this->id;
    }

    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    public function setDatePaiement($datePaiement)
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

    public function setMethodePaiement($methodePaiement)
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperateur()
    {
        return $this->operateur;
    }

    /**
     * @param mixed $operateur
     */
    public function setOperateur($operateur): void
    {
        $this->operateur = $operateur;
    }
}
