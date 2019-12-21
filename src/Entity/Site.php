<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site", uniqueConstraints={@ORM\UniqueConstraint(name=" codeSiteUnique", columns={"codeSite"})})
 * @ORM\Entity
 */
class Site
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
     * @ORM\Column(name="codeSite", type="string", length=45, nullable=false)
     */
    private $codesite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleSite", type="string", length=255, nullable=false)
     */
    private $libellesite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descritpion", type="text", length=0, nullable=true)
     */
    private $descritpion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodesite(): ?string
    {
        return $this->codesite;
    }

    public function setCodesite(string $codesite): self
    {
        $this->codesite = $codesite;

        return $this;
    }

    public function getLibellesite(): ?string
    {
        return $this->libellesite;
    }

    public function setLibellesite(string $libellesite): self
    {
        $this->libellesite = $libellesite;

        return $this;
    }

    public function getDescritpion(): ?string
    {
        return $this->descritpion;
    }

    public function setDescritpion(?string $descritpion): self
    {
        $this->descritpion = $descritpion;

        return $this;
    }


}
