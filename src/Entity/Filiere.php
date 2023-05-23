<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiere
 *
 * @ORM\Table(name="filiere", uniqueConstraints={@ORM\UniqueConstraint(name="codeFiliere_UNIQUE", columns={"codeFiliere"})}, indexes={@ORM\Index(name="fk_Filiere_Mention1_idx", columns={"idMention"}), @ORM\Index(name="fk_Filiere_Grade1_idx", columns={"idCycle"}), @ORM\Index(name="fk_Filiere_TypeFiliere1_idx", columns={"idTypeFiliere"}), @ORM\Index(name="fk_Filiere_Entite1_idx", columns={"idEntite"})})
 * @ORM\Entity
 */
class Filiere
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
     * @ORM\Column(name="codeFiliere", type="string", length=255, nullable=false)
     */
    private $codefiliere;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleFiliere", type="string", length=255, nullable=false)
     */
    private $libellefiliere;

    /**
     * @var string
     *
     * @ORM\Column(name="codeNum", type="string", length=255, nullable=false)
     */
    private $codenum;

    /**
     * @var string
     *
     * @ORM\Column(name="type_formation", type="string", length=100, nullable=false)
     * rajouté le 23 Mai 2023 pour FOPA
     */
    private $typeFormation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code_sigesr", type="string", length=30, nullable=false)
     */
    private $codeSigesr;

    /**
     * @var \Entite
     *
     * @ORM\ManyToOne(targetEntity="Entite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEntite", referencedColumnName="id")
     * })
     */
    private $identite;

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
     * @var \Mention
     *
     * @ORM\ManyToOne(targetEntity="Mention")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMention", referencedColumnName="id")
     * })
     */
    private $idmention;

    /**
     * @var \Typefiliere
     *
     * @ORM\ManyToOne(targetEntity="Typefiliere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeFiliere", referencedColumnName="id")
     * })
     */
    private $idtypefiliere;

    /**
     * @ORM\OneToOne(targetEntity=ParamFraisEncadrement::class, mappedBy="filiere")
     */
    private $paramFraisEncadrement;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodefiliere(): ?string
    {
        return $this->codefiliere;
    }

    public function setCodefiliere(string $codefiliere): self
    {
        $this->codefiliere = $codefiliere;

        return $this;
    }

    public function getLibellefiliere(): ?string
    {
        return $this->libellefiliere;
    }

    public function setLibellefiliere(string $libellefiliere): self
    {
        $this->libellefiliere = $libellefiliere;

        return $this;
    }

    public function getCodenum(): ?string
    {
        return $this->codenum;
    }

    public function setCodenum(string $codenum): self
    {
        $this->codenum = $codenum;

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

    public function getCodeSigesr(): ?string
    {
        return $this->codeSigesr;
    }

    public function setCodeSigesr(string $codeSigesr): self
    {
        $this->codeSigesr = $codeSigesr;

        return $this;
    }

    public function getIdentite(): ?Entite
    {
        return $this->identite;
    }

    public function setIdentite(?Entite $identite): self
    {
        $this->identite = $identite;

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

    public function getIdmention(): ?Mention
    {
        return $this->idmention;
    }

    public function setIdmention(?Mention $idmention): self
    {
        $this->idmention = $idmention;

        return $this;
    }

    public function getIdtypefiliere(): ?Typefiliere
    {
        return $this->idtypefiliere;
    }

    public function setIdtypefiliere(?Typefiliere $idtypefiliere): self
    {
        $this->idtypefiliere = $idtypefiliere;

        return $this;
    }

    public function getParamFraisEncadrement(): ?ParamFraisEncadrement
    {
        return $this->paramFraisEncadrement;
    }

    public function setParamFraisEncadrement(?ParamFraisEncadrement $paramFraisEncadrement): self
    {
        $this->paramFraisEncadrement = $paramFraisEncadrement;

        return $this;
    }

    // definir les accesseurs pour le champ typeFormation
    // rajouté le 23 Mai 2023 pour FOPA
    public function getTypeFormation(): ?string
    {
        return $this->typeFormation;
    }

    public function setTypeFormation(string $typeFormation): self
    {
        $this->typeFormation = $typeFormation;

        return $this;
    }



}
