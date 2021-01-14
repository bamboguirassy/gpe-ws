<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueEtatReclamation
 *
 * @ORM\Table(name="historique_etat_reclamation", indexes={@ORM\Index(name="fk_historique_etat_reclamation_etat_reclamation_bourse1_idx", columns={"etat"}), @ORM\Index(name="fk_historique_etat_reclamation_reclamation_bourse1_idx", columns={"reclamation"})})
 * @ORM\Entity
 */
class HistoriqueEtatReclamation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=45, nullable=false)
     */
    private $userEmail;

    /**
     * @var \EtatReclamationBourse
     *
     * @ORM\ManyToOne(targetEntity="EtatReclamationBourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat", referencedColumnName="id")
     * })
     */
    private $etat;

    /**
     * @var \ReclamationBourse
     *
     * @ORM\ManyToOne(targetEntity="ReclamationBourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reclamation", referencedColumnName="id")
     * })
     */
    private $reclamation;

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getReclamation()
    {
        return $this->reclamation;
    }

    public function setReclamation($reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }


}
