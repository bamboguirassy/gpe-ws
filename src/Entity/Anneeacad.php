<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anneeacad
 *
 * @ORM\Table(name="anneeacad", uniqueConstraints={@ORM\UniqueConstraint(name="codeanneecacad_UNIQUE", columns={"codeAnneeAcad"})}, indexes={@ORM\Index(name="anneeSuivante", columns={"anneeSuivante"})})
 * @ORM\Entity
 */
class Anneeacad
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
     * @ORM\Column(name="codeAnneeAcad", type="string", length=45, nullable=true)
     */
    private $codeanneeacad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelleAnneeAcad", type="string", length=45, nullable=true)
     */
    private $libelleanneeacad;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="enCours", type="boolean", nullable=true)
     */
    private $encours = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateOuvert", type="date", nullable=true)
     */
    private $dateouvert;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFerm", type="date", nullable=true)
     */
    private $dateferm;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_inscrits", type="integer", nullable=false)
     */
    private $nbreInscrits = '0';

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anneeSuivante", referencedColumnName="id")
     * })
     */
    private $anneesuivante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeanneeacad(): ?string
    {
        return $this->codeanneeacad;
    }

    public function setCodeanneeacad(?string $codeanneeacad): self
    {
        $this->codeanneeacad = $codeanneeacad;

        return $this;
    }

    public function getLibelleanneeacad(): ?string
    {
        return $this->libelleanneeacad;
    }

    public function setLibelleanneeacad(?string $libelleanneeacad): self
    {
        $this->libelleanneeacad = $libelleanneeacad;

        return $this;
    }

    public function getEncours(): ?bool
    {
        return $this->encours;
    }

    public function setEncours(?bool $encours): self
    {
        $this->encours = $encours;

        return $this;
    }

    public function getDateouvert(): ?\DateTimeInterface
    {
        return $this->dateouvert;
    }

    public function setDateouvert(?\DateTimeInterface $dateouvert): self
    {
        $this->dateouvert = $dateouvert;

        return $this;
    }

    public function getDateferm(): ?\DateTimeInterface
    {
        return $this->dateferm;
    }

    public function setDateferm(?\DateTimeInterface $dateferm): self
    {
        $this->dateferm = $dateferm;

        return $this;
    }

    public function getNbreInscrits(): ?int
    {
        return $this->nbreInscrits;
    }

    public function setNbreInscrits(int $nbreInscrits): self
    {
        $this->nbreInscrits = $nbreInscrits;

        return $this;
    }

    public function getAnneesuivante(): ?self
    {
        return $this->anneesuivante;
    }

    public function setAnneesuivante(?self $anneesuivante): self
    {
        $this->anneesuivante = $anneesuivante;

        return $this;
    }


}
