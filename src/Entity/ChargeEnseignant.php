<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChargeEnseignant
 *
 * @ORM\Table(name="charge_enseignant", uniqueConstraints={@ORM\UniqueConstraint(name="UC_charge_enseignant", columns={"id_titre_enseignant", "id_annee_academique"})}, indexes={@ORM\Index(name="id__titre_enseignant", columns={"id_titre_enseignant"}), @ORM\Index(name="id_annee_academique", columns={"id_annee_academique"})})
 * @ORM\Entity
 */
class ChargeEnseignant
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
     * @var float|null
     *
     * @ORM\Column(name="vhs_standard_cm", type="float", precision=10, scale=0, nullable=true)
     */
    private $vhsStandardCm;

    /**
     * @var float|null
     *
     * @ORM\Column(name="vhs_standard_tp", type="float", precision=10, scale=0, nullable=true)
     */
    private $vhsStandardTp;

    /**
     * @var float|null
     *
     * @ORM\Column(name="vhs_standard_td", type="float", precision=10, scale=0, nullable=true)
     */
    private $vhsStandardTd;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annee_academique", referencedColumnName="id")
     * })
     */
    private $idAnneeAcademique;

    /**
     * @var \Titreenseignant
     *
     * @ORM\ManyToOne(targetEntity="Titreenseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_titre_enseignant", referencedColumnName="id")
     * })
     */
    private $idTitreEnseignant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVhsStandardCm(): ?float
    {
        return $this->vhsStandardCm;
    }

    public function setVhsStandardCm(?float $vhsStandardCm): self
    {
        $this->vhsStandardCm = $vhsStandardCm;

        return $this;
    }

    public function getVhsStandardTp(): ?float
    {
        return $this->vhsStandardTp;
    }

    public function setVhsStandardTp(?float $vhsStandardTp): self
    {
        $this->vhsStandardTp = $vhsStandardTp;

        return $this;
    }

    public function getVhsStandardTd(): ?float
    {
        return $this->vhsStandardTd;
    }

    public function setVhsStandardTd(?float $vhsStandardTd): self
    {
        $this->vhsStandardTd = $vhsStandardTd;

        return $this;
    }

    public function getIdAnneeAcademique(): ?Anneeacad
    {
        return $this->idAnneeAcademique;
    }

    public function setIdAnneeAcademique(?Anneeacad $idAnneeAcademique): self
    {
        $this->idAnneeAcademique = $idAnneeAcademique;

        return $this;
    }

    public function getIdTitreEnseignant(): ?Titreenseignant
    {
        return $this->idTitreEnseignant;
    }

    public function setIdTitreEnseignant(?Titreenseignant $idTitreEnseignant): self
    {
        $this->idTitreEnseignant = $idTitreEnseignant;

        return $this;
    }


}
