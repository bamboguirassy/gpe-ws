<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 *
 * @ORM\Table(name="cycle", uniqueConstraints={@ORM\UniqueConstraint(name="codeGrade_UNIQUE", columns={"codeCycle"})})
 * @ORM\Entity
 */
class Cycle
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
     * @ORM\Column(name="codeCycle", type="string", length=45, nullable=false)
     */
    private $codecycle;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleCycle", type="string", length=255, nullable=false)
     */
    private $libellecycle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodecycle(): ?string
    {
        return $this->codecycle;
    }

    public function setCodecycle(string $codecycle): self
    {
        $this->codecycle = $codecycle;

        return $this;
    }

    public function getLibellecycle(): ?string
    {
        return $this->libellecycle;
    }

    public function setLibellecycle(string $libellecycle): self
    {
        $this->libellecycle = $libellecycle;

        return $this;
    }


}
