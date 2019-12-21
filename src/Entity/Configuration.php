<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration", indexes={@ORM\Index(name="anneeacad", columns={"anneeacad"})})
 * @ORM\Entity
 */
class Configuration
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
     * @var int
     *
     * @ORM\Column(name="montant_horaire_complementaire_td", type="integer", nullable=false)
     */
    private $montantHoraireComplementaireTd;

    /**
     * @var float
     *
     * @ORM\Column(name="equivalence_horaire_cm_en_td", type="float", precision=10, scale=0, nullable=false)
     */
    private $equivalenceHoraireCmEnTd;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_credit_passage_conditionnel", type="integer", nullable=false)
     */
    private $nombreCreditPassageConditionnel;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_credit_validation_niveau", type="integer", nullable=false)
     */
    private $nombreCreditValidationNiveau;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_credit_validation_semestre", type="integer", nullable=false)
     */
    private $nombreCreditValidationSemestre;

    /**
     * @var string
     *
     * @ORM\Column(name="email_deipvu", type="string", length=50, nullable=false)
     */
    private $emailDeipvu;

    /**
     * @var string
     *
     * @ORM\Column(name="email_acp", type="string", length=50, nullable=false)
     */
    private $emailAcp;

    /**
     * @var string
     *
     * @ORM\Column(name="email_drh", type="string", length=50, nullable=false)
     */
    private $emailDrh;

    /**
     * @var string
     *
     * @ORM\Column(name="email_dfc", type="string", length=50, nullable=false)
     */
    private $emailDfc;

    /**
     * @var string
     *
     * @ORM\Column(name="email_recteur", type="string", length=50, nullable=false)
     */
    private $emailRecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="email_alerte_systeme", type="string", length=50, nullable=false)
     */
    private $emailAlerteSysteme;

    /**
     * @var string
     *
     * @ORM\Column(name="liste_email_notification_instantanee_inscriptionacad", type="string", length=255, nullable=false)
     */
    private $listeEmailNotificationInstantaneeInscriptionacad;

    /**
     * @var \Anneeacad
     *
     * @ORM\ManyToOne(targetEntity="Anneeacad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anneeacad", referencedColumnName="id")
     * })
     */
    private $anneeacad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantHoraireComplementaireTd(): ?int
    {
        return $this->montantHoraireComplementaireTd;
    }

    public function setMontantHoraireComplementaireTd(int $montantHoraireComplementaireTd): self
    {
        $this->montantHoraireComplementaireTd = $montantHoraireComplementaireTd;

        return $this;
    }

    public function getEquivalenceHoraireCmEnTd(): ?float
    {
        return $this->equivalenceHoraireCmEnTd;
    }

    public function setEquivalenceHoraireCmEnTd(float $equivalenceHoraireCmEnTd): self
    {
        $this->equivalenceHoraireCmEnTd = $equivalenceHoraireCmEnTd;

        return $this;
    }

    public function getNombreCreditPassageConditionnel(): ?int
    {
        return $this->nombreCreditPassageConditionnel;
    }

    public function setNombreCreditPassageConditionnel(int $nombreCreditPassageConditionnel): self
    {
        $this->nombreCreditPassageConditionnel = $nombreCreditPassageConditionnel;

        return $this;
    }

    public function getNombreCreditValidationNiveau(): ?int
    {
        return $this->nombreCreditValidationNiveau;
    }

    public function setNombreCreditValidationNiveau(int $nombreCreditValidationNiveau): self
    {
        $this->nombreCreditValidationNiveau = $nombreCreditValidationNiveau;

        return $this;
    }

    public function getNombreCreditValidationSemestre(): ?int
    {
        return $this->nombreCreditValidationSemestre;
    }

    public function setNombreCreditValidationSemestre(int $nombreCreditValidationSemestre): self
    {
        $this->nombreCreditValidationSemestre = $nombreCreditValidationSemestre;

        return $this;
    }

    public function getEmailDeipvu(): ?string
    {
        return $this->emailDeipvu;
    }

    public function setEmailDeipvu(string $emailDeipvu): self
    {
        $this->emailDeipvu = $emailDeipvu;

        return $this;
    }

    public function getEmailAcp(): ?string
    {
        return $this->emailAcp;
    }

    public function setEmailAcp(string $emailAcp): self
    {
        $this->emailAcp = $emailAcp;

        return $this;
    }

    public function getEmailDrh(): ?string
    {
        return $this->emailDrh;
    }

    public function setEmailDrh(string $emailDrh): self
    {
        $this->emailDrh = $emailDrh;

        return $this;
    }

    public function getEmailDfc(): ?string
    {
        return $this->emailDfc;
    }

    public function setEmailDfc(string $emailDfc): self
    {
        $this->emailDfc = $emailDfc;

        return $this;
    }

    public function getEmailRecteur(): ?string
    {
        return $this->emailRecteur;
    }

    public function setEmailRecteur(string $emailRecteur): self
    {
        $this->emailRecteur = $emailRecteur;

        return $this;
    }

    public function getEmailAlerteSysteme(): ?string
    {
        return $this->emailAlerteSysteme;
    }

    public function setEmailAlerteSysteme(string $emailAlerteSysteme): self
    {
        $this->emailAlerteSysteme = $emailAlerteSysteme;

        return $this;
    }

    public function getListeEmailNotificationInstantaneeInscriptionacad(): ?string
    {
        return $this->listeEmailNotificationInstantaneeInscriptionacad;
    }

    public function setListeEmailNotificationInstantaneeInscriptionacad(string $listeEmailNotificationInstantaneeInscriptionacad): self
    {
        $this->listeEmailNotificationInstantaneeInscriptionacad = $listeEmailNotificationInstantaneeInscriptionacad;

        return $this;
    }

    public function getAnneeacad(): ?Anneeacad
    {
        return $this->anneeacad;
    }

    public function setAnneeacad(?Anneeacad $anneeacad): self
    {
        $this->anneeacad = $anneeacad;

        return $this;
    }


}
