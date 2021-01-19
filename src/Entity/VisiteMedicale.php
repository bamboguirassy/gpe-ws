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
     * @var bool
     *
     * @ORM\Column(name="apte", type="boolean", nullable=false)
     */
    private $apte;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getApte(): ?bool
    {
        return $this->apte;
    }

    public function setApte(bool $apte): self
    {
        $this->apte = $apte;

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


}
