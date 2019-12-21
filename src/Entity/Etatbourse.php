<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etatbourse
 *
 * @ORM\Table(name="etatbourse", uniqueConstraints={@ORM\UniqueConstraint(name="uniquekey", columns={"idbourse", "idetudiant", "idanneeacad"})}, indexes={@ORM\Index(name="idetudiant", columns={"idetudiant"}), @ORM\Index(name="idanneeacad", columns={"idanneeacad"}), @ORM\Index(name="idbourse", columns={"idbourse"})})
 * @ORM\Entity
 */
class Etatbourse
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
     * @ORM\Column(name="dateajout", type="date", nullable=false)
     */
    private $dateajout;

    /**
     * @var \Bourse
     *
     * @ORM\ManyToOne(targetEntity="Bourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbourse", referencedColumnName="id")
     * })
     */
    private $idbourse;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idetudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idanneeacad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateajout(): ?\DateTimeInterface
    {
        return $this->dateajout;
    }

    public function setDateajout(\DateTimeInterface $dateajout): self
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    public function getIdbourse(): ?Bourse
    {
        return $this->idbourse;
    }

    public function setIdbourse(?Bourse $idbourse): self
    {
        $this->idbourse = $idbourse;

        return $this;
    }

    public function getIdetudiant(): ?Etudiant
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(?Etudiant $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getIdanneeacad(): ?Anneeacad
    {
        return $this->idanneeacad;
    }

    public function setIdanneeacad(?Anneeacad $idanneeacad): self
    {
        $this->idanneeacad = $idanneeacad;

        return $this;
    }


}
