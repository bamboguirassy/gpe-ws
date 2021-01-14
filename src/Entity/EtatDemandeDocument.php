<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatDemandeDocument
 *
 * @ORM\Table(name="etat_demande_document", indexes={@ORM\Index(name="fk_etat_demande_document_etat_demande_document1_idx", columns={"etat_suivant"})})
 * @ORM\Entity
 */
class EtatDemandeDocument
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
     * @ORM\Column(name="code", type="string", length=20, nullable=false)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code_couleur", type="string", length=45, nullable=false)
     */
    private $codeCouleur;

    /**
     * @var \EtatDemandeDocument
     *
     * @ORM\ManyToOne(targetEntity="EtatDemandeDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_suivant", referencedColumnName="id")
     * })
     */
    private $etatSuivant;

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCodeCouleur()
    {
        return $this->codeCouleur;
    }

    public function setCodeCouleur(string $codeCouleur): self
    {
        $this->codeCouleur = $codeCouleur;

        return $this;
    }
    
    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getEtatSuivant()
    {
        return $this->etatSuivant;
    }

    public function setEtatSuivant($etatSuivant): self
    {
        $this->etatSuivant = $etatSuivant;

        return $this;
    }


}
