<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regimeinscription
 *
 * @ORM\Table(name="regimeinscription", uniqueConstraints={@ORM\UniqueConstraint(name="codeRegimeInscription_UNIQUE", columns={"codeRegimeInscription"})})
 * @ORM\Entity
 */
class Regimeinscription
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
     * @ORM\Column(name="codeRegimeInscription", type="string", length=45, nullable=false)
     */
    private $coderegimeinscription;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleRegimeInscription", type="string", length=255, nullable=false)
     */
    private $libelleregimeinscription;

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

    public function getCoderegimeinscription(): ?string
    {
        return $this->coderegimeinscription;
    }

    public function setCoderegimeinscription(string $coderegimeinscription): self
    {
        $this->coderegimeinscription = $coderegimeinscription;

        return $this;
    }

    public function getLibelleregimeinscription(): ?string
    {
        return $this->libelleregimeinscription;
    }

    public function setLibelleregimeinscription(string $libelleregimeinscription): self
    {
        $this->libelleregimeinscription = $libelleregimeinscription;

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
