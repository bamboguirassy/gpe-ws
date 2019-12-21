<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArreteVacationDepartementEtablissement
 *
 * @ORM\Table(name="arrete_vacation_departement_etablissement", uniqueConstraints={@ORM\UniqueConstraint(name="arrete_departement_2", columns={"arrete_departement", "arrete_etablissement"})}, indexes={@ORM\Index(name="arrete_etablissement", columns={"arrete_etablissement"}), @ORM\Index(name="arrete_departement", columns={"arrete_departement"})})
 * @ORM\Entity
 */
class ArreteVacationDepartementEtablissement
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
     * @var \ArreteVacation
     *
     * @ORM\ManyToOne(targetEntity="ArreteVacation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arrete_etablissement", referencedColumnName="id")
     * })
     */
    private $arreteEtablissement;

    /**
     * @var \ArreteVacation
     *
     * @ORM\ManyToOne(targetEntity="ArreteVacation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arrete_departement", referencedColumnName="id")
     * })
     */
    private $arreteDepartement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArreteEtablissement(): ?ArreteVacation
    {
        return $this->arreteEtablissement;
    }

    public function setArreteEtablissement(?ArreteVacation $arreteEtablissement): self
    {
        $this->arreteEtablissement = $arreteEtablissement;

        return $this;
    }

    public function getArreteDepartement(): ?ArreteVacation
    {
        return $this->arreteDepartement;
    }

    public function setArreteDepartement(?ArreteVacation $arreteDepartement): self
    {
        $this->arreteDepartement = $arreteDepartement;

        return $this;
    }


}
