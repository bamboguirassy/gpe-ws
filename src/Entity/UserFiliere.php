<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFiliere
 *
 * @ORM\Table(name="user_filiere", uniqueConstraints={@ORM\UniqueConstraint(name="idUser", columns={"idUser", "idFiliere"})}, indexes={@ORM\Index(name="idFiliere", columns={"idFiliere"})})
 * @ORM\Entity
 */
class UserFiliere
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
     * @ORM\Column(name="idFiliere", type="integer", nullable=true)
     */
    private $idfiliere;

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

    public function getIdfiliere(): ?int
    {
        return $this->idfiliere;
    }

    public function setIdfiliere(?int $idfiliere): self
    {
        $this->idfiliere = $idfiliere;

        return $this;
    }


}
