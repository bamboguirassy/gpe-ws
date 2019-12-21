<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entiteenseignant
 *
 * @ORM\Table(name="entiteenseignant", uniqueConstraints={@ORM\UniqueConstraint(name="idEnseignant", columns={"idEnseignant", "idEntite"})}, indexes={@ORM\Index(name="fk_EntiteEnseignant_Entite1_idx", columns={"idEntite"}), @ORM\Index(name="fk_EntiteEnseignant_Enseignant1_idx", columns={"idEnseignant"})})
 * @ORM\Entity
 */
class Entiteenseignant
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
     * @var \Enseignant
     *
     * @ORM\ManyToOne(targetEntity="Enseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEnseignant", referencedColumnName="id")
     * })
     */
    private $idenseignant;

    /**
     * @var \Entite
     *
     * @ORM\ManyToOne(targetEntity="Entite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEntite", referencedColumnName="id")
     * })
     */
    private $identite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdenseignant(): ?Enseignant
    {
        return $this->idenseignant;
    }

    public function setIdenseignant(?Enseignant $idenseignant): self
    {
        $this->idenseignant = $idenseignant;

        return $this;
    }

    public function getIdentite(): ?Entite
    {
        return $this->identite;
    }

    public function setIdentite(?Entite $identite): self
    {
        $this->identite = $identite;

        return $this;
    }


}
