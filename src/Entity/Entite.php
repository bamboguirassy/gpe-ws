<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entite
 *
 * @ORM\Table(name="entite", uniqueConstraints={@ORM\UniqueConstraint(name="fkUniqueCoupleodeNumidEntiteParent", columns={"codeNum", "idEntiteParent"}), @ORM\UniqueConstraint(name="codeEntite_UNIQUE", columns={"codeEntite"})}, indexes={@ORM\Index(name="fk_Entite_TypeEntite1_idx", columns={"idTypeEntite"}), @ORM\Index(name="fk_Entite_Entite1_idx", columns={"idEntiteParent"})})
 * @ORM\Entity
 */
class Entite
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
     * @var \Typeentite
     *
     * @ORM\ManyToOne(targetEntity="Typeentite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeEntite", referencedColumnName="id")
     * })
     */
    private $idtypeentite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codeNum", type="string", length=3, nullable=true)
     */
    private $codenum;

    /**
     * @var string
     *
     * @ORM\Column(name="codeEntite", type="string", length=45, nullable=false)
     */
    private $codeentite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleEntite", type="string", length=255, nullable=false)
     */
    private $libelleentite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="statut", type="string", length=45, nullable=true)
     */
    private $statut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="couleur", type="string", length=7, nullable=true)
     */
    private $couleur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logo", type="string", length=250, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=250, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=50, nullable=false)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="siteweb", type="string", length=250, nullable=true)
     */
    private $siteweb;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=250, nullable=false)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=255, nullable=true)
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
     *   @ORM\JoinColumn(name="idEntiteParent", referencedColumnName="id")
     * })
     */
    private $identiteparent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdtypeentite(): ?int
    {
        return $this->idtypeentite;
    }

    public function setIdtypeentite(int $idtypeentite): self
    {
        $this->idtypeentite = $idtypeentite;

        return $this;
    }

    public function getCodenum(): ?string
    {
        return $this->codenum;
    }

    public function setCodenum(?string $codenum): self
    {
        $this->codenum = $codenum;

        return $this;
    }

    public function getCodeentite(): ?string
    {
        return $this->codeentite;
    }

    public function setCodeentite(string $codeentite): self
    {
        $this->codeentite = $codeentite;

        return $this;
    }

    public function getLibelleentite(): ?string
    {
        return $this->libelleentite;
    }

    public function setLibelleentite(string $libelleentite): self
    {
        $this->libelleentite = $libelleentite;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(?string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getIdentiteparent(): ?self
    {
        return $this->identiteparent;
    }

    public function setIdentiteparent(?self $identiteparent): self
    {
        $this->identiteparent = $identiteparent;

        return $this;
    }


}
