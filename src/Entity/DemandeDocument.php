<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeDocument
 *
 * @ORM\Table(name="demande_document", indexes={@ORM\Index(name="fk_demande_document_etat_demande_document1_idx", columns={"etat_actuel"}), @ORM\Index(name="fk_demande_document_inscriptionacad1_idx", columns={"inscriptionacad"})})
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
     * @ORM\Column(name="type", type="string", length=45, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=145, nullable=false)
     */
    private $intitule;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getEtatActuel(): ?EtatDemandeDocument
    {
        return $this->etatActuel;
    }

    public function setEtatActuel(?EtatDemandeDocument $etatActuel): self
    {
        $this->etatActuel = $etatActuel;

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
