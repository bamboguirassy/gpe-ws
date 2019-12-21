<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ue
 *
 * @ORM\Table(name="ue", uniqueConstraints={@ORM\UniqueConstraint(name="idSpecialite_2", columns={"idSpecialite", "codeUe"})}, indexes={@ORM\Index(name="idSpecialite", columns={"idSpecialite", "codeUe"}), @ORM\Index(name="fk_Ue_Semestre1_idx", columns={"idSemestre"}), @ORM\Index(name="indexSpecialite", columns={"idSpecialite"}), @ORM\Index(name="fk_Ue_TypeUe1_idx", columns={"idTypeUe"})})
 * @ORM\Entity
 */
class Ue
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
     * @ORM\Column(name="idTypeUe", type="integer", nullable=false)
     */
    private $idtypeue;

    /**
     * @var int
     *
     * @ORM\Column(name="idSemestre", type="integer", nullable=false)
     */
    private $idsemestre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idSpecialite", type="integer", nullable=true)
     */
    private $idspecialite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SigleUe", type="string", length=45, nullable=true)
     */
    private $sigleue;

    /**
     * @var string
     *
     * @ORM\Column(name="codeUe", type="string", length=45, nullable=false)
     */
    private $codeue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelleUe", type="string", length=255, nullable=true)
     */
    private $libelleue;

    /**
     * @var int|null
     *
     * @ORM\Column(name="credit", type="integer", nullable=true)
     */
    private $credit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="coef", type="integer", nullable=true)
     */
    private $coef;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdtypeue(): ?int
    {
        return $this->idtypeue;
    }

    public function setIdtypeue(int $idtypeue): self
    {
        $this->idtypeue = $idtypeue;

        return $this;
    }

    public function getIdsemestre(): ?int
    {
        return $this->idsemestre;
    }

    public function setIdsemestre(int $idsemestre): self
    {
        $this->idsemestre = $idsemestre;

        return $this;
    }

    public function getIdspecialite(): ?int
    {
        return $this->idspecialite;
    }

    public function setIdspecialite(?int $idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }

    public function getSigleue(): ?string
    {
        return $this->sigleue;
    }

    public function setSigleue(?string $sigleue): self
    {
        $this->sigleue = $sigleue;

        return $this;
    }

    public function getCodeue(): ?string
    {
        return $this->codeue;
    }

    public function setCodeue(string $codeue): self
    {
        $this->codeue = $codeue;

        return $this;
    }

    public function getLibelleue(): ?string
    {
        return $this->libelleue;
    }

    public function setLibelleue(?string $libelleue): self
    {
        $this->libelleue = $libelleue;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(?int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getCoef(): ?int
    {
        return $this->coef;
    }

    public function setCoef(?int $coef): self
    {
        $this->coef = $coef;

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


}
