<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Noteevaluation
 *
 * @ORM\Table(name="noteevaluation", uniqueConstraints={@ORM\UniqueConstraint(name="idEtudiant", columns={"idEtudiant", "idEvaluation"})}, indexes={@ORM\Index(name="fk_noteevaluation_etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_Note_Evaluation1", columns={"idEvaluation"})})
 * @ORM\Entity
 */
class Noteevaluation
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
     * @var bool|null
     *
     * @ORM\Column(name="presence", type="boolean", nullable=true)
     */
    private $presence;

    /**
     * @var float|null
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeabsence", type="string", length=50, nullable=true)
     */
    private $typeabsence;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="notifier", type="boolean", nullable=true)
     */
    private $notifier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_anonymat", type="string", length=10, nullable=true)
     */
    private $codeAnonymat;

    /**
     * @var \Evaluation
     *
     * @ORM\ManyToOne(targetEntity="Evaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvaluation", referencedColumnName="id")
     * })
     */
    private $idevaluation;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresence(): ?bool
    {
        return $this->presence;
    }

    public function setPresence(?bool $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTypeabsence(): ?string
    {
        return $this->typeabsence;
    }

    public function setTypeabsence(?string $typeabsence): self
    {
        $this->typeabsence = $typeabsence;

        return $this;
    }

    public function getNotifier(): ?bool
    {
        return $this->notifier;
    }

    public function setNotifier(?bool $notifier): self
    {
        $this->notifier = $notifier;

        return $this;
    }

    public function getCodeAnonymat(): ?string
    {
        return $this->codeAnonymat;
    }

    public function setCodeAnonymat(?string $codeAnonymat): self
    {
        $this->codeAnonymat = $codeAnonymat;

        return $this;
    }

    public function getIdevaluation(): ?Evaluation
    {
        return $this->idevaluation;
    }

    public function setIdevaluation(?Evaluation $idevaluation): self
    {
        $this->idevaluation = $idevaluation;

        return $this;
    }

    public function getIdetudiant(): ?Etudiant
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(?Etudiant $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }


}
