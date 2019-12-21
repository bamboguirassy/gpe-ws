<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau", uniqueConstraints={@ORM\UniqueConstraint(name="codeNiveauEtude_UNIQUE", columns={"codeNiveau"})}, indexes={@ORM\Index(name="fk_niveau_cycle1", columns={"idCycle"}), @ORM\Index(name="niveauSuivant", columns={"niveauSuivant"})})
 * @ORM\Entity
 */
class Niveau
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
     * @var string
     *
     * @ORM\Column(name="codeNiveau", type="string", length=255, nullable=false)
     */
    private $codeniveau;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_sigesr", type="string", length=30, nullable=true)
     */
    private $codeSigesr;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleNiveau", type="string", length=255, nullable=false)
     */
    private $libelleniveau;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DDC", type="string", length=255, nullable=true)
     */
    private $ddc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var \Cycle
     *
     * @ORM\ManyToOne(targetEntity="Cycle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCycle", referencedColumnName="id")
     * })
     */
    private $idcycle;

    /**
     * @var \Niveau
     *
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveauSuivant", referencedColumnName="id")
     * })
     */
    private $niveausuivant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeniveau(): ?string
    {
        return $this->codeniveau;
    }

    public function setCodeniveau(string $codeniveau): self
    {
        $this->codeniveau = $codeniveau;

        return $this;
    }

    public function getCodeSigesr(): ?string
    {
        return $this->codeSigesr;
    }

    public function setCodeSigesr(?string $codeSigesr): self
    {
        $this->codeSigesr = $codeSigesr;

        return $this;
    }

    public function getLibelleniveau(): ?string
    {
        return $this->libelleniveau;
    }

    public function setLibelleniveau(string $libelleniveau): self
    {
        $this->libelleniveau = $libelleniveau;

        return $this;
    }

    public function getDdc(): ?string
    {
        return $this->ddc;
    }

    public function setDdc(?string $ddc): self
    {
        $this->ddc = $ddc;

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

    public function getIdcycle(): ?Cycle
    {
        return $this->idcycle;
    }

    public function setIdcycle(?Cycle $idcycle): self
    {
        $this->idcycle = $idcycle;

        return $this;
    }

    public function getNiveausuivant(): ?self
    {
        return $this->niveausuivant;
    }

    public function setNiveausuivant(?self $niveausuivant): self
    {
        $this->niveausuivant = $niveausuivant;

        return $this;
    }


}
