<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe", indexes={@ORM\Index(name="fk_Groupe_Ec1_idx", columns={"idEc"}), @ORM\Index(name="fk_Groupe_TypeCours1_idx", columns={"idTypeCours"}), @ORM\Index(name="fk_Groupe_AnneeAcad1_idx", columns={"idAnneeAcad"})})
 * @ORM\Entity
 */
class Groupe
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
     * @var string|null
     *
     * @ORM\Column(name="libelleGroupe", type="string", length=45, nullable=true)
     */
    private $libellegroupe;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeAcad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    /**
     * @var \Ec
     *
     * @ORM\ManyToOne(targetEntity="Ec")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEc", referencedColumnName="id")
     * })
     */
    private $idec;

    /**
     * @var \Typecours
     *
     * @ORM\ManyToOne(targetEntity="Typecours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeCours", referencedColumnName="id")
     * })
     */
    private $idtypecours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellegroupe(): ?string
    {
        return $this->libellegroupe;
    }

    public function setLibellegroupe(?string $libellegroupe): self
    {
        $this->libellegroupe = $libellegroupe;

        return $this;
    }

    public function getIdanneeacad(): ?Anneeacad
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(?Anneeacad $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }

    public function getIdec(): ?Ec
    {
        return $this->idec;
    }

    public function setIdec(?Ec $idec): self
    {
        $this->idec = $idec;

        return $this;
    }

    public function getIdtypecours(): ?Typecours
    {
        return $this->idtypecours;
    }

    public function setIdtypecours(?Typecours $idtypecours): self
    {
        $this->idtypecours = $idtypecours;

        return $this;
    }


}
