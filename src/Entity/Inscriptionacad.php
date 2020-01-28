<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscriptionacad
 *
 * @ORM\Table(name="inscriptionacad", uniqueConstraints={@ORM\UniqueConstraint(name="idClasse", columns={"idClasse", "idEtudiant"})}, indexes={@ORM\Index(name="encadreur", columns={"encadreur"}), @ORM\Index(name="fk_InscriptionAcad_Specialite1_idx", columns={"idSpecialite"}), @ORM\Index(name="fk_InscriptionAcad_ModaliteEnseignement1_idx", columns={"idModaliteEnseignement"}), @ORM\Index(name="fk_InscriptionAcad_ModePaiement1_idx", columns={"idModePaiement"}), @ORM\Index(name="idfosuser_index", columns={"idFosuser"}), @ORM\Index(name="fk_Inscription_Bourse1_idx", columns={"idBourse"}), @ORM\Index(name="fk_inscriptionacad_etudiant1_idx", columns={"idEtudiant"}), @ORM\Index(name="fk_InscriptionAcad_RegimeInscription1_idx", columns={"idRegimeInscription"}), @ORM\Index(name="fk_InscriptionAcad_Classe1_idx", columns={"idClasse"})})
 * @ORM\Entity
 */
class Inscriptionacad
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
     * @ORM\Column(name="dateInscAcad", type="datetime", nullable=false)
     */
    private $dateinscacad;

    /**
     * @var string
     *
     * @ORM\Column(name="passage", type="string", length=45, nullable=false)
     */
    private $passage;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=45, nullable=false)
     */
    private $etat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="montantInscriptionAcad", type="integer", nullable=true)
     */
    private $montantinscriptionacad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="coutformation", type="integer", nullable=true)
     */
    private $coutformation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numQuittance", type="string", length=45, nullable=true)
     */
    private $numquittance;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="carteTiree", type="boolean", nullable=true)
     */
    private $cartetiree = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="certificatTire", type="boolean", nullable=true)
     */
    private $certificattire = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true)
     */
    private $valide = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="quitus_bu", type="boolean", nullable=false)
     */
    private $quitusBu = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="quitus_social", type="boolean", nullable=false)
     */
    private $quitusSocial = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="quitus_medical", type="boolean", nullable=false)
     */
    private $quitusMedical = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="quitus_comptabilite", type="boolean", nullable=false)
     */
    private $quitusComptabilite = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="quitus_vie_universitaire", type="boolean", nullable=false)
     */
    private $quitusVieUniversitaire = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="universitepartenaire", type="string", length=255, nullable=true)
     */
    private $universitepartenaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sourcefinancement", type="string", length=255, nullable=true)
     */
    private $sourcefinancement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coencadreur", type="string", length=255, nullable=true)
     */
    private $coencadreur;

    /**
     * @var int|null
     *
     * @ORM\Column(name="premiereanneeinscription", type="integer", nullable=true)
     */
    private $premiereanneeinscription;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datemodification", type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @var float|null
     *
     * @ORM\Column(name="moyenne_annuelle", type="float", precision=10, scale=0, nullable=true)
     */
    private $moyenneAnnuelle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="total_credit", type="integer", nullable=true)
     */
    private $totalCredit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="credit_capitalise", type="integer", nullable=true)
     */
    private $creditCapitalise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="decision_conseil", type="string", length=100, nullable=true)
     */
    private $decisionConseil;

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClasse", referencedColumnName="id")
     * })
     */
    private $idclasse;

    /**
     * @var \Modaliteenseignement
     *
     * @ORM\ManyToOne(targetEntity="Modaliteenseignement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idModaliteEnseignement", referencedColumnName="id")
     * })
     */
    private $idmodaliteenseignement;

    /**
     * @var \Modepaiement
     *
     * @ORM\ManyToOne(targetEntity="Modepaiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idModePaiement", referencedColumnName="id")
     * })
     */
    private $idmodepaiement;

    /**
     * @var \Regimeinscription
     *
     * @ORM\ManyToOne(targetEntity="Regimeinscription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRegimeInscription", referencedColumnName="id")
     * })
     */
    private $idregimeinscription;

    /**
     * @var \Specialite
     *
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSpecialite", referencedColumnName="id")
     * })
     */
    private $idspecialite;

    /**
     * @var \Bourse
     *
     * @ORM\ManyToOne(targetEntity="Bourse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBourse", referencedColumnName="id")
     * })
     */
    private $idbourse;

    /**
     * @var \Etudiant
     *
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtudiant", referencedColumnName="id")
     * })
     */
    private $idetudiant;

    /**
     * @var \Enseignant
     *
     * @ORM\ManyToOne(targetEntity="Enseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="encadreur", referencedColumnName="id")
     * })
     */
    private $encadreur;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFosuser", referencedColumnName="id")
     * })
     */
    private $idfosuser;

    public function getId()
    {
        return $this->id;
    }

    public function getDateinscacad()
    {
        return $this->dateinscacad;
    }

    public function setDateinscacad($dateinscacad): self
    {
        $this->dateinscacad = $dateinscacad;

        return $this;
    }

    public function getPassage()
    {
        return $this->passage;
    }

    public function setPassage(string $passage): self
    {
        $this->passage = $passage;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontantinscriptionacad()
    {
        return $this->montantinscriptionacad;
    }

    public function setMontantinscriptionacad($montantinscriptionacad): self
    {
        $this->montantinscriptionacad = $montantinscriptionacad;

        return $this;
    }

    public function getCoutformation()
    {
        return $this->coutformation;
    }

    public function setCoutformation($coutformation): self
    {
        $this->coutformation = $coutformation;

        return $this;
    }

    public function getNumquittance()
    {
        return $this->numquittance;
    }

    public function setNumquittance($numquittance): self
    {
        $this->numquittance = $numquittance;

        return $this;
    }

    public function getCartetiree()
    {
        return $this->cartetiree;
    }

    public function setCartetiree($cartetiree): self
    {
        $this->cartetiree = $cartetiree;

        return $this;
    }

    public function getCertificattire()
    {
        return $this->certificattire;
    }

    public function setCertificattire($certificattire): self
    {
        $this->certificattire = $certificattire;

        return $this;
    }

    public function getValide()
    {
        return $this->valide;
    }

    public function setValide($valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getQuitusBu()
    {
        return $this->quitusBu;
    }

    public function setQuitusBu(bool $quitusBu): self
    {
        $this->quitusBu = $quitusBu;

        return $this;
    }

    public function getQuitusSocial()
    {
        return $this->quitusSocial;
    }

    public function setQuitusSocial(bool $quitusSocial): self
    {
        $this->quitusSocial = $quitusSocial;

        return $this;
    }

    public function getQuitusMedical()
    {
        return $this->quitusMedical;
    }

    public function setQuitusMedical(bool $quitusMedical): self
    {
        $this->quitusMedical = $quitusMedical;

        return $this;
    }

    public function getQuitusComptabilite()
    {
        return $this->quitusComptabilite;
    }

    public function setQuitusComptabilite(bool $quitusComptabilite): self
    {
        $this->quitusComptabilite = $quitusComptabilite;

        return $this;
    }

    public function getQuitusVieUniversitaire()
    {
        return $this->quitusVieUniversitaire;
    }

    public function setQuitusVieUniversitaire(bool $quitusVieUniversitaire): self
    {
        $this->quitusVieUniversitaire = $quitusVieUniversitaire;

        return $this;
    }

    public function getUniversitepartenaire()
    {
        return $this->universitepartenaire;
    }

    public function setUniversitepartenaire($universitepartenaire): self
    {
        $this->universitepartenaire = $universitepartenaire;

        return $this;
    }

    public function getSourcefinancement()
    {
        return $this->sourcefinancement;
    }

    public function setSourcefinancement($sourcefinancement): self
    {
        $this->sourcefinancement = $sourcefinancement;

        return $this;
    }

    public function getCoencadreur()
    {
        return $this->coencadreur;
    }

    public function setCoencadreur($coencadreur): self
    {
        $this->coencadreur = $coencadreur;

        return $this;
    }

    public function getPremiereanneeinscription()
    {
        return $this->premiereanneeinscription;
    }

    public function setPremiereanneeinscription($premiereanneeinscription): self
    {
        $this->premiereanneeinscription = $premiereanneeinscription;

        return $this;
    }

    public function getDatemodification()
    {
        return $this->datemodification;
    }

    public function setDatemodification($datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getMoyenneAnnuelle()
    {
        return $this->moyenneAnnuelle;
    }

    public function setMoyenneAnnuelle($moyenneAnnuelle): self
    {
        $this->moyenneAnnuelle = $moyenneAnnuelle;

        return $this;
    }

    public function getTotalCredit()
    {
        return $this->totalCredit;
    }

    public function setTotalCredit($totalCredit): self
    {
        $this->totalCredit = $totalCredit;

        return $this;
    }

    public function getCreditCapitalise()
    {
        return $this->creditCapitalise;
    }

    public function setCreditCapitalise($creditCapitalise): self
    {
        $this->creditCapitalise = $creditCapitalise;

        return $this;
    }

    public function getDecisionConseil()
    {
        return $this->decisionConseil;
    }

    public function setDecisionConseil($decisionConseil): self
    {
        $this->decisionConseil = $decisionConseil;

        return $this;
    }

    public function getIdclasse()
    {
        return $this->idclasse;
    }

    public function setIdclasse($idclasse): self
    {
        $this->idclasse = $idclasse;

        return $this;
    }

    public function getIdmodaliteenseignement()
    {
        return $this->idmodaliteenseignement;
    }

    public function setIdmodaliteenseignement($idmodaliteenseignement): self
    {
        $this->idmodaliteenseignement = $idmodaliteenseignement;

        return $this;
    }

    public function getIdmodepaiement()
    {
        return $this->idmodepaiement;
    }

    public function setIdmodepaiement($idmodepaiement): self
    {
        $this->idmodepaiement = $idmodepaiement;

        return $this;
    }

    public function getIdregimeinscription()
    {
        return $this->idregimeinscription;
    }

    public function setIdregimeinscription($idregimeinscription): self
    {
        $this->idregimeinscription = $idregimeinscription;

        return $this;
    }

    public function getIdspecialite()
    {
        return $this->idspecialite;
    }

    public function setIdspecialite($idspecialite): self
    {
        $this->idspecialite = $idspecialite;

        return $this;
    }

    public function getIdbourse()
    {
        return $this->idbourse;
    }

    public function setIdbourse($idbourse): self
    {
        $this->idbourse = $idbourse;

        return $this;
    }

    public function getIdetudiant()
    {
        return $this->idetudiant;
    }

    public function setIdetudiant($idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getEncadreur()
    {
        return $this->encadreur;
    }

    public function setEncadreur($encadreur): self
    {
        $this->encadreur = $encadreur;

        return $this;
    }

    public function getIdfosuser()
    {
        return $this->idfosuser;
    }

    public function setIdfosuser($idfosuser): self
    {
        $this->idfosuser = $idfosuser;

        return $this;
    }


}
