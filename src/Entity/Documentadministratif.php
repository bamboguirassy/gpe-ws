<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documentadministratif
 *
 * @ORM\Table(name="documentadministratif", indexes={@ORM\Index(name="idFosuser", columns={"idFosuser"}), @ORM\Index(name="idAnneeacad", columns={"idAnneeacad"}), @ORM\Index(name="idEtudiant_2", columns={"idEtudiant"}), @ORM\Index(name="idFosuser_2", columns={"idFosuser"}), @ORM\Index(name="idTypedocument", columns={"idTypedocument"}), @ORM\Index(name="idEtudiant", columns={"idEtudiant", "idFosuser"})})
 * @ORM\Entity
 */
class Documentadministratif
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
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=false)
     */
    private $etat;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFosuser", referencedColumnName="id")
     * })
     */
    private $idfosuser;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeacad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    /**
     * @var \Typedocument
     *
     * @ORM\ManyToOne(targetEntity="Typedocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypedocument", referencedColumnName="id")
     * })
     */
    private $idtypedocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

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

    public function getIdfosuser(): ?FosUser
    {
        return $this->idfosuser;
    }

    public function setIdfosuser(?FosUser $idfosuser): self
    {
        $this->idfosuser = $idfosuser;

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

    public function getIdtypedocument(): ?Typedocument
    {
        return $this->idtypedocument;
    }

    public function setIdtypedocument(?Typedocument $idtypedocument): self
    {
        $this->idtypedocument = $idtypedocument;

        return $this;
    }


}
