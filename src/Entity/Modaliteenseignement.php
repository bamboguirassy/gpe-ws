<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modaliteenseignement
 *
 * @ORM\Table(name="modaliteenseignement", uniqueConstraints={@ORM\UniqueConstraint(name="codeModaliteEnseignement_UNIQUE", columns={"codeModaliteEnseignement"})})
 * @ORM\Entity
 */
class Modaliteenseignement
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
     * @ORM\Column(name="codeModaliteEnseignement", type="string", length=45, nullable=false)
     */
    private $codemodaliteenseignement;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleModaliteEnseignement", type="string", length=45, nullable=false)
     */
    private $libellemodaliteenseignement;

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

    public function getCodemodaliteenseignement(): ?string
    {
        return $this->codemodaliteenseignement;
    }

    public function setCodemodaliteenseignement(string $codemodaliteenseignement): self
    {
        $this->codemodaliteenseignement = $codemodaliteenseignement;

        return $this;
    }

    public function getLibellemodaliteenseignement(): ?string
    {
        return $this->libellemodaliteenseignement;
    }

    public function setLibellemodaliteenseignement(string $libellemodaliteenseignement): self
    {
        $this->libellemodaliteenseignement = $libellemodaliteenseignement;

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
