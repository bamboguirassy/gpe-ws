<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArreteEnseignant
 *
 * @ORM\Table(name="arrete_enseignant", uniqueConstraints={@ORM\UniqueConstraint(name="enseignant_arrete_unique", columns={"enseignant", "arrete_vacation"})}, indexes={@ORM\Index(name="arrete_vacation", columns={"arrete_vacation"}), @ORM\Index(name="enseignant", columns={"enseignant"})})
 * @ORM\Entity
 */
class ArreteEnseignant
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
     *   @ORM\JoinColumn(name="enseignant", referencedColumnName="id")
     * })
     */
    private $enseignant;

    /**
     * @var \ArreteVacation
     *
     * @ORM\ManyToOne(targetEntity="ArreteVacation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arrete_vacation", referencedColumnName="id")
     * })
     */
    private $arreteVacation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getArreteVacation(): ?ArreteVacation
    {
        return $this->arreteVacation;
    }

    public function setArreteVacation(?ArreteVacation $arreteVacation): self
    {
        $this->arreteVacation = $arreteVacation;

        return $this;
    }


}
