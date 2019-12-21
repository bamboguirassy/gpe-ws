<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity
 */
class Session
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
     * @ORM\Column(name="libelleSession", type="string", length=45, nullable=false)
     */
    private $libellesession;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellesession(): ?string
    {
        return $this->libellesession;
    }

    public function setLibellesession(string $libellesession): self
    {
        $this->libellesession = $libellesession;

        return $this;
    }


}
