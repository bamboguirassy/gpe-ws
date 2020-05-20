<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BourseEtudiant
 *
 * @ORM\Table(name="bourse_etudiant")
 * @ORM\Entity
 */
class BourseEtudiant
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
     * @ORM\Column(name="prenoms", type="string", length=100, nullable=false)
     */
    private $prenoms;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="date_naissance", type="string", length=10, nullable=false)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_naissance", type="string", length=50, nullable=false)
     */
    private $lieuNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="cni", type="string", length=20, nullable=false)
     */
    private $cni;

    /**
     * @var string
     *
     * @ORM\Column(name="taux_bourse", type="string", length=20, nullable=false)
     */
    private $tauxBourse;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_bourse", type="bigint", nullable=false)
     */
    private $montantBourse;

    /**
     * @var string
     *
     * @ORM\Column(name="mois", type="text", length=65535, nullable=false)
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     */
    private $annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getTauxBourse(): ?string
    {
        return $this->tauxBourse;
    }

    public function setTauxBourse(string $tauxBourse): self
    {
        $this->tauxBourse = $tauxBourse;

        return $this;
    }

    public function getMontantBourse(): ?string
    {
        return $this->montantBourse;
    }

    public function setMontantBourse(string $montantBourse): self
    {
        $this->montantBourse = $montantBourse;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }


}
