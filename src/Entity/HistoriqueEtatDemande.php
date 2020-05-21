<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriqueEtatDemande
 *
 * @ORM\Table(name="historique_etat_demande", indexes={@ORM\Index(name="fk_demande_document_has_etat_demande_document_demande_docum_idx", columns={"demande"}), @ORM\Index(name="fk_demande_document_has_etat_demande_document_etat_demande__idx", columns={"etat"})})
 * @ORM\Entity
 */
class HistoriqueEtatDemande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="user_mail", type="string", length=45, nullable=false)
     */
    private $userMail;

    /**
     * @var \DemandeDocument
     *
     * @ORM\ManyToOne(targetEntity="DemandeDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="demande", referencedColumnName="id")
     * })
     */
    private $demande;

    /**
     * @var \EtatDemandeDocument
     *
     * @ORM\ManyToOne(targetEntity="EtatDemandeDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat", referencedColumnName="id")
     * })
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->userMail;
    }

    public function setUserMail(string $userMail): self
    {
        $this->userMail = $userMail;

        return $this;
    }

    public function getDemande(): ?DemandeDocument
    {
        return $this->demande;
    }

    public function setDemande(?DemandeDocument $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getEtat(): ?EtatDemandeDocument
    {
        return $this->etat;
    }

    public function setEtat(?EtatDemandeDocument $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


}
