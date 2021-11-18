<?php

namespace App\Entity;

use App\Repository\ParamFraisEncadrementRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * ParamFraisEncadrement
 *
 * @ORM\Table(name="param_frais_encadrement")
 * @ORM\Entity
 */
class ParamFraisEncadrement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisAnnuel;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    public function getId()
    {
        return $this->id;
    }

    public function getFraisAnnuel()
    {
        return $this->fraisAnnuel;
    }

    public function setFraisAnnuel(int $fraisAnnuel)
    {
        $this->fraisAnnuel = $fraisAnnuel;

        return $this;
    }

    public function getFiliere()
    {
        return $this->filiere;
    }

    public function setFiliere(Filiere $filiere)
    {
        $this->filiere = $filiere;

        return $this;
    }
}
