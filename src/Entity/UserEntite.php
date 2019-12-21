<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEntite
 *
 * @ORM\Table(name="user_entite", uniqueConstraints={@ORM\UniqueConstraint(name="idUser", columns={"idUser", "idEntite"})}, indexes={@ORM\Index(name="idEntite", columns={"idEntite"})})
 * @ORM\Entity
 */
class UserEntite
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
     * @var int|null
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idEntite", type="integer", nullable=true)
     */
    private $identite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdentite(): ?int
    {
        return $this->identite;
    }

    public function setIdentite(?int $identite): self
    {
        $this->identite = $identite;

        return $this;
    }


}
