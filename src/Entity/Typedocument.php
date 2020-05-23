<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typedocument
 *
 * @ORM\Table(name="typedocument")
 * @ORM\Entity
 */
class Typedocument
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
     * @ORM\Column(name="codetypedocument", type="string", length=45, nullable=false)
     */
    private $codetypedocument;

    /**
     * @var string
     *
     * @ORM\Column(name="libelletypedocument", type="string", length=255, nullable=false)
     */
    private $libelletypedocument;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=45, nullable=false)
     */
    private $source;

    public function getId()
    {
        return $this->id;
    }

    public function getCodetypedocument()
    {
        return $this->codetypedocument;
    }

    public function setCodetypedocument(string $codetypedocument): self
    {
        $this->codetypedocument = $codetypedocument;

        return $this;
    }

    public function getLibelletypedocument()
    {
        return $this->libelletypedocument;
    }

    public function setLibelletypedocument(string $libelletypedocument): self
    {
        $this->libelletypedocument = $libelletypedocument;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }


}
