<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialite
 *
 * @ORM\Table(name="specialite", uniqueConstraints={@ORM\UniqueConstraint(name="idFiliere", columns={"idFiliere", "codeSpecialite"})}, indexes={@ORM\Index(name="idTypeDiplome", columns={"idTypeDiplome"}), @ORM\Index(name="langueutilisee", columns={"langueutilisee"}), @ORM\Index(name="fk_Specialite_Filiere1_idx", columns={"idFiliere"})})
 * @ORM\Entity
 */
class Specialite
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
     * @ORM\Column(name="idFiliere", type="integer", nullable=false)
     */
    private $idfiliere;

    /**
     * @var string
     *
     * @ORM\Column(name="codeSpecialite", type="string", length=45, nullable=false)
     */
    private $codespecialite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleSpecialite", type="string", length=255, nullable=false)
     */
    private $libellespecialite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="langueutilisee", type="integer", nullable=false)
     */
    private $langueutilisee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeaccreditation", type="string", length=255, nullable=true)
     */
    private $typeaccreditation;

    /**
     * @var int
     *
     * @ORM\Column(name="idTypeDiplome", type="integer", nullable=false)
     */
    private $idtypediplome;

    /**
     * @var string
     *
     * @ORM\Column(name="code_sigesr_specialite", type="string", length=30, nullable=false)
     */
    private $codeSigesrSpecialite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdfiliere(): ?int
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(int $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getCodespecialite(): ?string
    {
        return $this->codespecialite;
    }

    public function setCodespecialite(string $codespecialite): self
    {
        $this->codespecialite = $codespecialite;

        return $this;
    }

    public function getLibellespecialite(): ?string
    {
        return $this->libellespecialite;
    }

    public function setLibellespecialite(string $libellespecialite): self
    {
        $this->libellespecialite = $libellespecialite;

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

    public function getLangueutilisee(): ?int
    {
        return $this->langueutilisee;
    }

    public function setLangueutilisee(int $langueutilisee): self
    {
        $this->langueutilisee = $langueutilisee;

        return $this;
    }

    public function getTypeaccreditation(): ?string
    {
        return $this->typeaccreditation;
    }

    public function setTypeaccreditation(?string $typeaccreditation): self
    {
        $this->typeaccreditation = $typeaccreditation;

        return $this;
    }

    public function getIdtypediplome(): ?int
    {
        return $this->idtypediplome;
    }

    public function setIdtypediplome(int $idtypediplome): self
    {
        $this->idtypediplome = $idtypediplome;

        return $this;
    }

    public function getCodeSigesrSpecialite(): ?string
    {
        return $this->codeSigesrSpecialite;
    }

    public function setCodeSigesrSpecialite(string $codeSigesrSpecialite): self
    {
        $this->codeSigesrSpecialite = $codeSigesrSpecialite;

        return $this;
    }


}
