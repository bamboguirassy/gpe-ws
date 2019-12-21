<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays", uniqueConstraints={@ORM\UniqueConstraint(name="alpha3", columns={"alpha3"}), @ORM\UniqueConstraint(name="alpha2", columns={"alpha2"}), @ORM\UniqueConstraint(name="code_unique", columns={"code"})})
 * @ORM\Entity
 */
class Pays
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
     * @var int
     *
     * @ORM\Column(name="code", type="integer", nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha2", type="string", length=2, nullable=false)
     */
    private $alpha2;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha3", type="string", length=3, nullable=false)
     */
    private $alpha3;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_en_gb", type="string", length=45, nullable=false)
     */
    private $nomEnGb;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_fr_fr", type="string", length=45, nullable=false)
     */
    private $nomFrFr;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255, nullable=false)
     */
    private $nationalite;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_inscription_licence", type="integer", nullable=false)
     */
    private $montantInscriptionLicence;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_inscription_master", type="integer", nullable=false)
     */
    private $montantInscriptionMaster;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_inscription_doctorat", type="integer", nullable=false)
     */
    private $montantInscriptionDoctorat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): self
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    public function getAlpha3(): ?string
    {
        return $this->alpha3;
    }

    public function setAlpha3(string $alpha3): self
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    public function getNomEnGb(): ?string
    {
        return $this->nomEnGb;
    }

    public function setNomEnGb(string $nomEnGb): self
    {
        $this->nomEnGb = $nomEnGb;

        return $this;
    }

    public function getNomFrFr(): ?string
    {
        return $this->nomFrFr;
    }

    public function setNomFrFr(string $nomFrFr): self
    {
        $this->nomFrFr = $nomFrFr;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getMontantInscriptionLicence(): ?int
    {
        return $this->montantInscriptionLicence;
    }

    public function setMontantInscriptionLicence(int $montantInscriptionLicence): self
    {
        $this->montantInscriptionLicence = $montantInscriptionLicence;

        return $this;
    }

    public function getMontantInscriptionMaster(): ?int
    {
        return $this->montantInscriptionMaster;
    }

    public function setMontantInscriptionMaster(int $montantInscriptionMaster): self
    {
        $this->montantInscriptionMaster = $montantInscriptionMaster;

        return $this;
    }

    public function getMontantInscriptionDoctorat(): ?int
    {
        return $this->montantInscriptionDoctorat;
    }

    public function setMontantInscriptionDoctorat(int $montantInscriptionDoctorat): self
    {
        $this->montantInscriptionDoctorat = $montantInscriptionDoctorat;

        return $this;
    }


}
