<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatReclamationBourse
 *
 * @ORM\Table(name="etat_reclamation_bourse", indexes={@ORM\Index(name="fk_etat_reclamation_bourse_etat_reclamation_bourse1_idx", columns={"etat_suivant"})})
 * @ORM\Entity
 */
class EtatReclamationBourse
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
     * @ORM\Column(name="libelle", type="string", length=45, nullable=false)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="code_couleur", type="string", length=45, nullable=false)
     */
    private $codeCouleur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \EtatReclamationBourse
     *
     * @ORM\ManyToOne(targetEntity="EtatReclamationBourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_suivant", referencedColumnName="id")
     * })
     */
    private $etatSuivant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCodeCouleur(): ?string
    {
        return $this->codeCouleur;
    }

    public function setCodeCouleur(string $codeCouleur): self
    {
        $this->codeCouleur = $codeCouleur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtatSuivant(): ?self
    {
        return $this->etatSuivant;
    }

    public function setEtatSuivant(?self $etatSuivant): self
    {
        $this->etatSuivant = $etatSuivant;

        return $this;
    }


}
