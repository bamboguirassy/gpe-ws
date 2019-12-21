<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartedelivree
 *
 * @ORM\Table(name="cartedelivree", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idInscription", columns={"idInscription"})})
 * @ORM\Entity
 */
class Cartedelivree
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
     * @var string|null
     *
     * @ORM\Column(name="numerocarte", type="string", length=17, nullable=true)
     */
    private $numerocarte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedelivrance", type="datetime", nullable=false)
     */
    private $datedelivrance;

    /**
     * @var \Inscriptionacad
     *
     * @ORM\ManyToOne(targetEntity="Inscriptionacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idInscription", referencedColumnName="id")
     * })
     */
    private $idinscription;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerocarte(): ?string
    {
        return $this->numerocarte;
    }

    public function setNumerocarte(?string $numerocarte): self
    {
        $this->numerocarte = $numerocarte;

        return $this;
    }

    public function getDatedelivrance(): ?\DateTimeInterface
    {
        return $this->datedelivrance;
    }

    public function setDatedelivrance(\DateTimeInterface $datedelivrance): self
    {
        $this->datedelivrance = $datedelivrance;

        return $this;
    }

    public function getIdinscription(): ?Inscriptionacad
    {
        return $this->idinscription;
    }

    public function setIdinscription(?Inscriptionacad $idinscription): self
    {
        $this->idinscription = $idinscription;

        return $this;
    }

    public function getIduser(): ?FosUser
    {
        return $this->iduser;
    }

    public function setIduser(?FosUser $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
