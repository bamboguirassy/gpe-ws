<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisiteMedicale
 *
 * @ORM\Table(name="visite_medicale", indexes={@ORM\Index(name="inscriptionacad", columns={"inscriptionacad"})})
 * @ORM\Entity
 */
class VisiteMedicale
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
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;


    /**
     * @var \Inscriptionacad
     * @ORM\OneToOne(targetEntity=Inscriptionacad::class, inversedBy="visiteMedicale", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="inscriptionacad", referencedColumnName="id",nullable=false)
     */
    private $inscriptionacad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=45, nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $resultat;

    /**
     * @ORM\Column(name="maladie_chroniques", type="string", length=255, nullable=true)
     */
    private $maladieChroniques;

    public function getId(): ?int
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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getInscriptionacad(): ?Inscriptionacad
    {
        return $this->inscriptionacad;
    }

    public function setInscriptionacad(?Inscriptionacad $inscriptionacad): self
    {
        $this->inscriptionacad = $inscriptionacad;

        return $this;
    }
    
   
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getMaladieChroniques(): ?string
    {
        return $this->maladieChroniques;
    }

    public function setMaladieChroniques(?string $maladieChroniques): self
    {
        $this->maladieChroniques = $maladieChroniques;

        return $this;
    }

}
