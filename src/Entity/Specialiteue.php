<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialiteue
 *
 * @ORM\Table(name="specialiteue", uniqueConstraints={@ORM\UniqueConstraint(name="idSpecialite", columns={"idSpecialite", "idUe"})}, indexes={@ORM\Index(name="fk_SpecialiteUe_Specialite1_idx", columns={"idSpecialite"}), @ORM\Index(name="fk_SpecialiteUe_Ue1_idx", columns={"idUe"})})
 * @ORM\Entity
 */
class Specialiteue
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
     * @ORM\Column(name="idSpecialite", type="integer", nullable=false)
     */
    private $idspecialite;

    /**
     * @var int
     *
     * @ORM\Column(name="idUe", type="integer", nullable=false)
     */
    private $idue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdspecialite(): ?int
    {
        return $this->idspecialite;
    }

    public function setIdspecialite(int $idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }

    public function getIdue(): ?int
    {
        return $this->idue;
    }

    public function setIdue(int $idue): self
    {
        $this->idue = $idue;

        return $this;
    }


}
