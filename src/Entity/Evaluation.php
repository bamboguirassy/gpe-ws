<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation", indexes={@ORM\Index(name="fk_Evaluation_Ec1_idx", columns={"idEc"}), @ORM\Index(name="fk_Evaluation_Session1_idx", columns={"idSession"}), @ORM\Index(name="fk_Evaluation_TypeEvaluation1_idx", columns={"idTypeEvaluation"}), @ORM\Index(name="fk_Evaluation_AnneeAcad1_idx", columns={"idAnneeAcad"}), @ORM\Index(name="iduser", columns={"iduser"})})
 * @ORM\Entity
 */
class Evaluation
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
     * @ORM\Column(name="libelleEvaluation", type="string", length=255, nullable=true)
     */
    private $libelleevaluation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateEvaluation", type="datetime", nullable=true)
     */
    private $dateevaluation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ponderation", type="integer", nullable=true)
     */
    private $ponderation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="heureDeb", type="string", length=45, nullable=true)
     */
    private $heuredeb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="heureFin", type="string", length=45, nullable=true)
     */
    private $heurefin;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean", nullable=false)
     */
    private $etat = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="remarque", type="text", length=0, nullable=true)
     */
    private $remarque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="epreuve", type="string", length=255, nullable=true)
     */
    private $epreuve;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="anonymiser", type="boolean", nullable=true)
     */
    private $anonymiser;

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
     *   @ORM\JoinColumn(name="idAnneeAcad", referencedColumnName="id")
     * })
     */
    private $idanneeacad;

    /**
     * @var \Ec
     *
     * @ORM\ManyToOne(targetEntity="Ec")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEc", referencedColumnName="id")
     * })
     */
    private $idec;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSession", referencedColumnName="id")
     * })
     */
    private $idsession;

    /**
     * @var \Typeevaluation
     *
     * @ORM\ManyToOne(targetEntity="Typeevaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeEvaluation", referencedColumnName="id")
     * })
     */
    private $idtypeevaluation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleevaluation(): ?string
    {
        return $this->libelleevaluation;
    }

    public function setLibelleevaluation(?string $libelleevaluation): self
    {
        $this->libelleevaluation = $libelleevaluation;

        return $this;
    }

    public function getDateevaluation(): ?\DateTimeInterface
    {
        return $this->dateevaluation;
    }

    public function setDateevaluation(?\DateTimeInterface $dateevaluation): self
    {
        $this->dateevaluation = $dateevaluation;

        return $this;
    }

    public function getPonderation(): ?int
    {
        return $this->ponderation;
    }

    public function setPonderation(?int $ponderation): self
    {
        $this->ponderation = $ponderation;

        return $this;
    }

    public function getHeuredeb(): ?string
    {
        return $this->heuredeb;
    }

    public function setHeuredeb(?string $heuredeb): self
    {
        $this->heuredeb = $heuredeb;

        return $this;
    }

    public function getHeurefin(): ?string
    {
        return $this->heurefin;
    }

    public function setHeurefin(?string $heurefin): self
    {
        $this->heurefin = $heurefin;

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

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getEpreuve(): ?string
    {
        return $this->epreuve;
    }

    public function setEpreuve(?string $epreuve): self
    {
        $this->epreuve = $epreuve;

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

    public function getIdtypeevaluation(): ?Typeevaluation
    {
        return $this->idtypeevaluation;
    }

    public function setIdtypeevaluation(?Typeevaluation $idtypeevaluation): self
    {
        $this->idtypeevaluation = $idtypeevaluation;

        return $this;
    }


}
