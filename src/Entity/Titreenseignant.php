<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Titreenseignant
 *
 * @ORM\Table(name="titreenseignant", uniqueConstraints={@ORM\UniqueConstraint(name="codeTitreEnseignant_UNIQUE", columns={"codeTitreEnseignant"})})
 * @ORM\Entity
 */
class Titreenseignant
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
     * @ORM\Column(name="codeTitreEnseignant", type="string", length=45, nullable=false)
     */
    private $codetitreenseignant;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTitreEnseignant", type="string", length=255, nullable=false)
     */
    private $libelletitreenseignant;

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

    public function getCodetitreenseignant(): ?string
    {
        return $this->codetitreenseignant;
    }

    public function setCodetitreenseignant(string $codetitreenseignant): self
    {
        $this->codetitreenseignant = $codetitreenseignant;

        return $this;
    }

    public function getLibelletitreenseignant(): ?string
    {
        return $this->libelletitreenseignant;
    }

    public function setLibelletitreenseignant(string $libelletitreenseignant): self
    {
        $this->libelletitreenseignant = $libelletitreenseignant;

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
