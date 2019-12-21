<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mention
 *
 * @ORM\Table(name="mention", uniqueConstraints={@ORM\UniqueConstraint(name="codeMention_UNIQUE", columns={"codeMention"})}, indexes={@ORM\Index(name="fk_Mention_Domaine1_idx", columns={"idDomaine"})})
 * @ORM\Entity
 */
class Mention
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
     * @ORM\Column(name="codeMention", type="string", length=255, nullable=false)
     */
    private $codemention;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleMention", type="string", length=255, nullable=false)
     */
    private $libellemention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var \Domaine
     *
     * @ORM\ManyToOne(targetEntity="Domaine")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDomaine", referencedColumnName="id")
     * })
     */
    private $iddomaine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodemention(): ?string
    {
        return $this->codemention;
    }

    public function setCodemention(string $codemention): self
    {
        $this->codemention = $codemention;

        return $this;
    }

    public function getLibellemention(): ?string
    {
        return $this->libellemention;
    }

    public function setLibellemention(string $libellemention): self
    {
        $this->libellemention = $libellemention;

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

    public function getIddomaine(): ?Domaine
    {
        return $this->iddomaine;
    }

    public function setIddomaine(?Domaine $iddomaine): self
    {
        $this->iddomaine = $iddomaine;

        return $this;
    }


}
