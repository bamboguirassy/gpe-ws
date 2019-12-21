<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domaine
 *
 * @ORM\Table(name="domaine", uniqueConstraints={@ORM\UniqueConstraint(name="codeDomaine_UNIQUE", columns={"codeDomaine"})})
 * @ORM\Entity
 */
class Domaine
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
     * @ORM\Column(name="codeDomaine", type="string", length=45, nullable=false)
     */
    private $codedomaine;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleDomaine", type="string", length=255, nullable=false)
     */
    private $libelledomaine;

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

    public function getCodedomaine(): ?string
    {
        return $this->codedomaine;
    }

    public function setCodedomaine(string $codedomaine): self
    {
        $this->codedomaine = $codedomaine;

        return $this;
    }

    public function getLibelledomaine(): ?string
    {
        return $this->libelledomaine;
    }

    public function setLibelledomaine(string $libelledomaine): self
    {
        $this->libelledomaine = $libelledomaine;

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
