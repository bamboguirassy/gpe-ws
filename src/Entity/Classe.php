<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe", uniqueConstraints={@ORM\UniqueConstraint(name="codeClasse_UNIQUE", columns={"codeClasse"}), @ORM\UniqueConstraint(name="idFiliere", columns={"idFiliere", "idAnneeAcad", "idNiveau"})}, indexes={@ORM\Index(name="fk_Classe_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="fk_Classe_Filiere1_idx", columns={"idFiliere"}), @ORM\Index(name="fk_Classe_Niveau1_idx", columns={"idNiveau"})})
 * @ORM\Entity
 */
class Classe
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
     * @ORM\Column(name="codeClasse", type="string", length=45, nullable=false)
     */
    private $codeclasse;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleClasse", type="string", length=255, nullable=false)
     */
    private $libelleclasse;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true, options={"default"="1"})
     */
    private $etat = '1';

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
     * @var \Niveau
     *
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idNiveau", referencedColumnName="id")
     * })
     */
    private $idniveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeclasse(): ?string
    {
        return $this->codeclasse;
    }

    public function setCodeclasse(string $codeclasse): self
    {
        $this->codeclasse = $codeclasse;

        return $this;
    }

    public function getLibelleclasse(): ?string
    {
        return $this->libelleclasse;
    }

    public function setLibelleclasse(string $libelleclasse): self
    {
        $this->libelleclasse = $libelleclasse;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

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

    public function getIdniveau(): ?Niveau
    {
        return $this->idniveau;
    }

    public function setIdniveau(?Niveau $idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }


}
