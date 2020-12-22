<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssistanceEmail
 *
 * @ORM\Table(name="assistance_email")
 * @ORM\Entity
 */
class AssistanceEmail
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
     * @ORM\Column(name="type_assistance", type="string", length=245, nullable=false)
     */
    private $typeAssistance;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=145, nullable=false)
     */
    private $email;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="destination_app", type="string", length=45, nullable=false)
     */
    private $destinationApp;

    public function getId()
    {
        return $this->id;
    }

    public function getTypeAssistance()
    {
        return $this->typeAssistance;
    }

    public function setTypeAssistance(string $typeAssistance): self
    {
        $this->typeAssistance = $typeAssistance;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDestinationApp()
    {
        return $this->destinationApp;
    }

    public function setDestinationApp(string $destinationApp): self
    {
        $this->destinationApp = $destinationApp;

        return $this;
    }


}
