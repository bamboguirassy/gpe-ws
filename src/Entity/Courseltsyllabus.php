<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courseltsyllabus
 *
 * @ORM\Table(name="courseltsyllabus", uniqueConstraints={@ORM\UniqueConstraint(name="idSeanceCours", columns={"idSeanceCours", "idEltSyllabus"})}, indexes={@ORM\Index(name="fk_CoursEltSyllabus_EltSyllabus1_idx", columns={"idEltSyllabus"}), @ORM\Index(name="fk_CoursEltSyllabus_SeanceCours1_idx", columns={"idSeanceCours"})})
 * @ORM\Entity
 */
class Courseltsyllabus
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
     * @var \Eltsyllabus
     *
     * @ORM\ManyToOne(targetEntity="Eltsyllabus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEltSyllabus", referencedColumnName="id")
     * })
     */
    private $ideltsyllabus;

    /**
     * @var \Seancecours
     *
     * @ORM\ManyToOne(targetEntity="Seancecours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSeanceCours", referencedColumnName="id")
     * })
     */
    private $idseancecours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdeltsyllabus(): ?Eltsyllabus
    {
        return $this->ideltsyllabus;
    }

    public function setIdeltsyllabus(?Eltsyllabus $ideltsyllabus): self
    {
        $this->ideltsyllabus = $ideltsyllabus;

        return $this;
    }

    public function getIdseancecours(): ?Seancecours
    {
        return $this->idseancecours;
    }

    public function setIdseancecours(?Seancecours $idseancecours): self
    {
        $this->idseancecours = $idseancecours;

        return $this;
    }


}
