<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeliberationAnnuelle
 *
 * @ORM\Table(name="deliberation_annuelle", indexes={@ORM\Index(name="idClasse", columns={"idClasse"})})
 * @ORM\Entity
 */
class DeliberationAnnuelle
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
     * @var bool
     *
     * @ORM\Column(name="finalisee", type="boolean", nullable=false)
     */
    private $finalisee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClasse", referencedColumnName="id")
     * })
     */
    private $idclasse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinalisee(): ?bool
    {
        return $this->finalisee;
    }

    public function setFinalisee(bool $finalisee): self
    {
        $this->finalisee = $finalisee;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getIdclasse(): ?Classe
    {
        return $this->idclasse;
    }

    public function setIdclasse(?Classe $idclasse): self
    {
        $this->idclasse = $idclasse;

        return $this;
    }


}
