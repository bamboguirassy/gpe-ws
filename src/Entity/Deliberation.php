<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deliberation
 *
 * @ORM\Table(name="deliberation", uniqueConstraints={@ORM\UniqueConstraint(name="idAnneeAcad", columns={"idAnneeAcad", "idSemestre", "idSession", "idFiliere"})}, indexes={@ORM\Index(name="fk_Deliberation_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="fk_Deliberation_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_Deliberation_Semestre1_idx", columns={"idSemestre"}), @ORM\Index(name="fk_Deliberation_Session1_idx", columns={"idSession"})})
 * @ORM\Entity
 */
class Deliberation
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
     * @var bool
     *
     * @ORM\Column(name="finalisee", type="boolean", nullable=false)
     */
    private $finalisee = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDeliberation", type="date", nullable=true)
     */
    private $datedeliberation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remarque", type="text", length=0, nullable=true)
     */
    private $remarque;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="anonymiser", type="boolean", nullable=true)
     */
    private $anonymiser;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnneeAcad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    /**
     * @var \Filiere
     *
     * @ORM\ManyToOne(targetEntity="Filiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFiliere", referencedColumnName="id")
     * })
     */
    private $idfiliere;

    /**
     * @var \Semestre
     *
     * @ORM\ManyToOne(targetEntity="Semestre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSemestre", referencedColumnName="id")
     * })
     */
    private $idsemestre;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSession", referencedColumnName="id")
     * })
     */
    private $idsession;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinalisee(): ?bool
    {
        return $this->finalisee;
    }

    public function setFinalisee(bool $finalisee): self
    {
        $this->finalisee = $finalisee;

        return $this;
    }

    public function getDatedeliberation(): ?\DateTimeInterface
    {
        return $this->datedeliberation;
    }

    public function setDatedeliberation(?\DateTimeInterface $datedeliberation): self
    {
        $this->datedeliberation = $datedeliberation;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getAnonymiser(): ?bool
    {
        return $this->anonymiser;
    }

    public function setAnonymiser(?bool $anonymiser): self
    {
        $this->anonymiser = $anonymiser;

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

    public function getIdfiliere(): ?Filiere
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(?Filiere $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getIdsemestre(): ?Semestre
    {
        return $this->idsemestre;
    }

    public function setIdsemestre(?Semestre $idsemestre): self
    {
        $this->idsemestre = $idsemestre;

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


}
