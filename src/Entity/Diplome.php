<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diplome
 *
 * @ORM\Table(name="diplome", uniqueConstraints={@ORM\UniqueConstraint(name="idFiliere", columns={"idFiliere", "idSpecialite", "codeDiplome"})}, indexes={@ORM\Index(name="fk_Diplome_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="langueutilisee", columns={"langueutilisee"}), @ORM\Index(name="fk_Diplome_Specialite1_idx", columns={"idSpecialite"})})
 * @ORM\Entity
 */
class Diplome
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
     * @ORM\Column(name="codeDiplome", type="string", length=255, nullable=false)
     */
    private $codediplome;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleDiplome", type="string", length=255, nullable=false)
     */
    private $libellediplome;

    /**
     * @var string
     *
     * @ORM\Column(name="type_accreditation", type="string", length=255, nullable=false)
     */
    private $typeAccreditation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \Filiere
     *
     * @ORM\ManyToOne(targetEntity="Filiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFiliere", referencedColumnName="id")
     * })
     */
    private $idfiliere;

    /**
     * @var \Langue
     *
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="langueutilisee", referencedColumnName="id")
     * })
     */
    private $langueutilisee;

    /**
     * @var \Specialite
     *
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSpecialite", referencedColumnName="id")
     * })
     */
    private $idspecialite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodediplome(): ?string
    {
        return $this->codediplome;
    }

    public function setCodediplome(string $codediplome): self
    {
        $this->codediplome = $codediplome;

        return $this;
    }

    public function getLibellediplome(): ?string
    {
        return $this->libellediplome;
    }

    public function setLibellediplome(string $libellediplome): self
    {
        $this->libellediplome = $libellediplome;

        return $this;
    }

    public function getTypeAccreditation(): ?string
    {
        return $this->typeAccreditation;
    }

    public function setTypeAccreditation(string $typeAccreditation): self
    {
        $this->typeAccreditation = $typeAccreditation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdfiliere(): ?Filiere
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(?Filiere $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getLangueutilisee(): ?Langue
    {
        return $this->langueutilisee;
    }

    public function setLangueutilisee(?Langue $langueutilisee): self
    {
        $this->langueutilisee = $langueutilisee;

        return $this;
    }

    public function getIdspecialite(): ?Specialite
    {
        return $this->idspecialite;
    }

    public function setIdspecialite(?Specialite $idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }


}
