<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Filiereniveau
 *
 * @ORM\Table(name="filiereniveau", uniqueConstraints={@ORM\UniqueConstraint(name="idfiliere_2", columns={"idfiliere", "idniveau"})}, indexes={@ORM\Index(name="idniveau", columns={"idniveau"}), @ORM\Index(name="idfiliere", columns={"idfiliere"})})
 * @ORM\Entity
 */
class Filiereniveau
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
     * @var \Filiere
     *
     * @ORM\ManyToOne(targetEntity="Filiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfiliere", referencedColumnName="id")
     * })
     */
    private $idfiliere;

    /**
     * @var \Niveau
     *
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idniveau", referencedColumnName="id")
     * })
     */
    private $idniveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdfiliere(): ?Filiere
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(?Filiere $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    public function getIdniveau(): ?Niveau
    {
        return $this->idniveau;
    }

    public function setIdniveau(?Niveau $idniveau): self
    {
        $this->idniveau = $idniveau;

        return $this;
    }


}
