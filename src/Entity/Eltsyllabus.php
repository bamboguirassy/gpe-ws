<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eltsyllabus
 *
 * @ORM\Table(name="eltsyllabus", indexes={@ORM\Index(name="fk_EltSyllabus_Syllabus1_idx", columns={"idSyllabus"}), @ORM\Index(name="fk_EltSyllabus_EltSyllabus1_idx", columns={"idEltSyllabusParent"})})
 * @ORM\Entity
 */
class Eltsyllabus
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
     * @ORM\Column(name="libelleEltSyllabus", type="text", length=0, nullable=false)
     */
    private $libelleeltsyllabus;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauElt", type="integer", nullable=false)
     */
    private $niveauelt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \Eltsyllabus
     *
     * @ORM\ManyToOne(targetEntity="Eltsyllabus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEltSyllabusParent", referencedColumnName="id")
     * })
     */
    private $ideltsyllabusparent;

    /**
     * @var \Syllabus
     *
     * @ORM\ManyToOne(targetEntity="Syllabus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSyllabus", referencedColumnName="id")
     * })
     */
    private $idsyllabus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleeltsyllabus(): ?string
    {
        return $this->libelleeltsyllabus;
    }

    public function setLibelleeltsyllabus(string $libelleeltsyllabus): self
    {
        $this->libelleeltsyllabus = $libelleeltsyllabus;

        return $this;
    }

    public function getNiveauelt(): ?int
    {
        return $this->niveauelt;
    }

    public function setNiveauelt(int $niveauelt): self
    {
        $this->niveauelt = $niveauelt;

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

    public function getIdeltsyllabusparent(): ?self
    {
        return $this->ideltsyllabusparent;
    }

    public function setIdeltsyllabusparent(?self $ideltsyllabusparent): self
    {
        $this->ideltsyllabusparent = $ideltsyllabusparent;

        return $this;
    }

    public function getIdsyllabus(): ?Syllabus
    {
        return $this->idsyllabus;
    }

    public function setIdsyllabus(?Syllabus $idsyllabus): self
    {
        $this->idsyllabus = $idsyllabus;

        return $this;
    }


}
