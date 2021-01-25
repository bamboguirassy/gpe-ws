<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InformationPaiementInscription
 *
 * @ORM\Table(name="information_paiement_inscription", indexes={@ORM\Index(name="idInscriptionacad", columns={"inscriptionacad"})})
 * @ORM\Entity
 */
class InformationPaiementInscription
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
     * @ORM\Column(name="numero_transaction", type="string", length=45, nullable=false)
     */
    private $numeroTransaction;

    /**
     * @var string
     *
     * @ORM\Column(name="operateur", type="string", length=45, nullable=false)
     */
    private $operateur;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \Inscriptionacad
     *
     * @ORM\ManyToOne(targetEntity="Inscriptionacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inscriptionacad", referencedColumnName="id")
     * })
     */
    private $inscriptionacad;

    public function getId()
    {
        return $this->id;
    }

    public function getNumeroTransaction()
    {
        return $this->numeroTransaction;
    }

    public function setNumeroTransaction(string $numeroTransaction): self
    {
        $this->numeroTransaction = $numeroTransaction;

        return $this;
    }

    public function getOperateur()
    {
        return $this->operateur;
    }

    public function setOperateur(string $operateur): self
    {
        $this->operateur = $operateur;

        return $this;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInscriptionacad()
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad(Inscriptionacad $inscriptionacad): self
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }


}
