<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeDocument
 *
 * @ORM\Table(name="demande_document", indexes={@ORM\Index(name="fk_demande_document_etat_demande_document1_idx", columns={"etat_actuel"}), @ORM\Index(name="fk_demande_document_inscriptionacad1_idx", columns={"inscriptionacad"}), @ORM\Index(name="typedocument", columns={"typedocument"})})
 * @ORM\Entity
 */
class DemandeDocument
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
     * @ORM\Column(name="intitule", type="string", length=145, nullable=false)
     */
    private $intitule;
    
        /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=45, nullable=false)
     */
    private $nature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Typedocument
     *
     * @ORM\ManyToOne(targetEntity="Typedocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typedocument", referencedColumnName="id")
     * })
     */
    private $typedocument;

    /**
     * @var \EtatDemandeDocument
     *
     * @ORM\ManyToOne(targetEntity="EtatDemandeDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_actuel", referencedColumnName="id")
     * })
     */
    private $etatActuel;

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

    public function getIntitule()
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypedocument()
    {
        return $this->typedocument;
    }

    public function setTypedocument($typedocument): self
    {
        $this->typedocument = $typedocument;

        return $this;
    }

    public function getEtatActuel()
    {
        return $this->etatActuel;
    }

    public function setEtatActuel($etatActuel): self
    {
        $this->etatActuel = $etatActuel;

        return $this;
    }

    public function getInscriptionacad()
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad($inscriptionacad): self
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }

    public function getNature()
    {
        return $this->nature;
    }

    public function setNature(string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }


}
