<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affectationetudiantgroupe
 *
 * @ORM\Table(name="affectationetudiantgroupe", uniqueConstraints={@ORM\UniqueConstraint(name="UNIK_etudiantGroupe1", columns={"idGroupe", "idEtudiant"})}, indexes={@ORM\Index(name="fk_AffectationEtudiantGroupe_Etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_AffectationEtudiantGroupe_Groupe1_idx", columns={"idGroupe"})})
 * @ORM\Entity
 */
class Affectationetudiantgroupe
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
     * @ORM\Column(name="idGroupe", type="integer", nullable=false)
     */
    private $idgroupe;

    /**
     * @var int
     *
     * @ORM\Column(name="idEtudiant", type="integer", nullable=false)
     */
    private $idetudiant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdgroupe(): ?int
    {
        return $this->idgroupe;
    }

    public function setIdgroupe(int $idgroupe): self
    {
        $this->idgroupe = $idgroupe;

        return $this;
    }

    public function getIdetudiant(): ?int
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(int $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }


}
