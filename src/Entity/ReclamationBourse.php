<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReclamationBourse
 *
 * @ORM\Table(name="reclamation_bourse", indexes={@ORM\Index(name="etudiant", columns={"etudiant"}), @ORM\Index(name="fk_reclamation_bourse_bourse_etudiant1_idx", columns={"bourse_etudiant"}), @ORM\Index(name="fk_reclamation_bourse_etat_reclamation_bourse1_idx", columns={"etat_actuel"})})
 * @ORM\Entity
 */
class ReclamationBourse
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
     * @ORM\Column(name="objet", type="string", length=45, nullable=false)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var \BourseEtudiant
     *
     * @ORM\ManyToOne(targetEntity="BourseEtudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bourse_etudiant", referencedColumnName="id")
     * })
     */
    private $bourseEtudiant;

    /**
     * @var \EtatReclamationBourse
     *
     * @ORM\ManyToOne(targetEntity="EtatReclamationBourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_actuel", referencedColumnName="id")
     * })
     */
    private $etatActuel;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etudiant", referencedColumnName="id")
     * })
     */
    private $etudiant;

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

    public function getObjet()
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getBourseEtudiant()
    {
        return $this->bourseEtudiant;
    }

    public function setBourseEtudiant($bourseEtudiant): self
    {
        $this->bourseEtudiant = $bourseEtudiant;

        return $this;
    }

    public function getEtatActuel()
    {
        return $this->etatActuel;
    }

    public function setEtatActuel($etatActuel): self
    {
        $this->etatActuel = $etatActuel;

        return $this;
    }

    public function getEtudiant()
    {
        return $this->etudiant;
    }

    public function setEtudiant($etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }


}
