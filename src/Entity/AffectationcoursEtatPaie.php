<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AffectationcoursEtatPaie
 *
 * @ORM\Table(name="affectationcours_etat_paie", indexes={@ORM\Index(name="affectationcours", columns={"affectationcours"}), @ORM\Index(name="etat_paie_ec", columns={"etat_paie_ec"})})
 * @ORM\Entity
 */
class AffectationcoursEtatPaie
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
     * @var \EtatPaieEc
     *
     * @ORM\ManyToOne(targetEntity="EtatPaieEc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_paie_ec", referencedColumnName="id")
     * })
     */
    private $etatPaieEc;

    /**
     * @var \Affectationcours
     *
     * @ORM\ManyToOne(targetEntity="Affectationcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="affectationcours", referencedColumnName="id")
     * })
     */
    private $affectationcours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatPaieEc(): ?EtatPaieEc
    {
        return $this->etatPaieEc;
    }

    public function setEtatPaieEc(?EtatPaieEc $etatPaieEc): self
    {
        $this->etatPaieEc = $etatPaieEc;

        return $this;
    }

    public function getAffectationcours(): ?Affectationcours
    {
        return $this->affectationcours;
    }

    public function setAffectationcours(?Affectationcours $affectationcours): self
    {
        $this->affectationcours = $affectationcours;

        return $this;
    }


}
