<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deliberationec
 *
 * @ORM\Table(name="deliberationec", uniqueConstraints={@ORM\UniqueConstraint(name="DeliberationEcUnique", columns={"idec", "idsession", "idanneeacad"})}, indexes={@ORM\Index(name="idec", columns={"idec"}), @ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idsession", columns={"idsession"}), @ORM\Index(name="idanneeacad", columns={"idanneeacad"})})
 * @ORM\Entity
 */
class Deliberationec
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
     * @ORM\Column(name="datedeliberation", type="datetime", nullable=false)
     */
    private $datedeliberation;

    /**
     * @var \Ec
     *
     * @ORM\ManyToOne(targetEntity="Ec")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idec", referencedColumnName="id")
     * })
     */
    private $idec;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsession", referencedColumnName="id")
     * })
     */
    private $idsession;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

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

    public function getDatedeliberation(): ?\DateTimeInterface
    {
        return $this->datedeliberation;
    }

    public function setDatedeliberation(\DateTimeInterface $datedeliberation): self
    {
        $this->datedeliberation = $datedeliberation;

        return $this;
    }

    public function getIdec(): ?Ec
    {
        return $this->idec;
    }

    public function setIdec(?Ec $idec): self
    {
        $this->idec = $idec;

        return $this;
    }

    public function getIdsession(): ?Session
    {
        return $this->idsession;
    }

    public function setIdsession(?Session $idsession): self
    {
        $this->idsession = $idsession;

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
