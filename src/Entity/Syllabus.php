<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Syllabus
 *
 * @ORM\Table(name="syllabus", indexes={@ORM\Index(name="fk_Syllabus_ElementConstitutif1_idx", columns={"idEc"})})
 * @ORM\Entity
 */
class Syllabus
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
     * @var int
     *
     * @ORM\Column(name="idEc", type="integer", nullable=false)
     */
    private $idec;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleSyllabus", type="string", length=45, nullable=false)
     */
    private $libellesyllabus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeb", type="date", nullable=false)
     */
    private $datedeb;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var bool
     *
     * @ORM\Column(name="etatActif", type="boolean", nullable=false)
     */
    private $etatactif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdec(): ?int
    {
        return $this->idec;
    }

    public function setIdec(int $idec): self
    {
        $this->idec = $idec;

        return $this;
    }

    public function getLibellesyllabus(): ?string
    {
        return $this->libellesyllabus;
    }

    public function setLibellesyllabus(string $libellesyllabus): self
    {
        $this->libellesyllabus = $libellesyllabus;

        return $this;
    }

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(\DateTimeInterface $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getEtatactif(): ?bool
    {
        return $this->etatactif;
    }

    public function setEtatactif(bool $etatactif): self
    {
        $this->etatactif = $etatactif;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
