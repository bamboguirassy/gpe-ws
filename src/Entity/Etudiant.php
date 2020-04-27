<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant", uniqueConstraints={@ORM\UniqueConstraint(name="cni_UNIQUE", columns={"cni"}), @ORM\UniqueConstraint(name="numInterne_UNIQUE", columns={"numInterne"})}, indexes={@ORM\Index(name="adPays", columns={"adPays"}), @ORM\Index(name="idPays", columns={"idPays"}), @ORM\Index(name="nationalite", columns={"nationalite"})})
 * @ORM\Entity
 */
class Etudiant
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
     * @ORM\Column(name="cni", type="string", length=25, nullable=false)
     */
    private $cni;

    /**
     * @var string
     *
     * @ORM\Column(name="ine", type="string", length=255, nullable=false)
     */
    private $ine;

    /**
     * @var string
     *
     * @ORM\Column(name="numInterne", type="string", length=255, nullable=false)
     */
    private $numinterne;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEtudiant", type="string", length=255, nullable=false)
     */
    private $nometudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomEtudiant", type="string", length=255, nullable=false)
     */
    private $prenometudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=45, nullable=false)
     */
    private $genre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaiss", type="date", nullable=false)
     */
    private $datenaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="lieunaiss", type="string", length=255, nullable=false)
     */
    private $lieunaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="regionNaiss", type="string", length=255, nullable=true)
     */
    private $regionnaiss;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adVille", type="string", length=100, nullable=true)
     */
    private $adville;

    /**
     * @var string
     *
     * @ORM\Column(name="adQuartier", type="string", length=100, nullable=false)
     */
    private $adquartier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adRueVilla", type="string", length=100, nullable=true)
     */
    private $adruevilla;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_univ", type="string", length=255, nullable=true)
     */
    private $emailUniv;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="notifMail", type="boolean", nullable=true)
     */
    private $notifmail = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lyceeDeProvenance", type="string", length=45, nullable=true)
     */
    private $lyceedeprovenance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telEtudiant", type="string", length=45, nullable=true)
     */
    private $teletudiant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telEtudiant2", type="string", length=255, nullable=true)
     */
    private $teletudiant2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="serieBac", type="string", length=45, nullable=true)
     */
    private $seriebac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="diplomeEntree", type="string", length=30, nullable=true)
     */
    private $diplomeentree;

    /**
     * @var float|null
     *
     * @ORM\Column(name="moyenneBac", type="float", precision=10, scale=0, nullable=true)
     */
    private $moyennebac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mentionBac", type="string", length=255, nullable=true)
     */
    private $mentionbac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="groupePassage", type="string", length=15, nullable=true)
     */
    private $groupepassage;

    /**
     * @var int
     *
     * @ORM\Column(name="annee_bac", type="integer", nullable=false)
     */
    private $anneeBac;

    /**
     * @var string
     *
     * @ORM\Column(name="handicap", type="string", length=255, nullable=false, options={"default"="Non"})
     */
    private $handicap = 'Non';

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_handicap", type="string", length=55, nullable=true)
     */
    private $typeHandicap;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_handicap", type="text", length=65535, nullable=true)
     */
    private $descriptionHandicap;

    /**
     * @var string
     *
     * @ORM\Column(name="orphelin", type="string", length=255, nullable=false, options={"default"="Non"})
     */
    private $orphelin = 'Non';

    /**
     * @var string
     *
     * @ORM\Column(name="situation_matrimoniale", type="string", length=255, nullable=false)
     */
    private $situationMatrimoniale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomConjoint", type="string", length=45, nullable=true)
     */
    private $nomconjoint;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreEnfant", type="integer", nullable=true)
     */
    private $nbreenfant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomContact", type="string", length=45, nullable=true)
     */
    private $nomcontact;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telContact", type="string", length=45, nullable=true)
     */
    private $telcontact;

    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPays", referencedColumnName="id")
     * })
     */
    private $idpays;

    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adPays", referencedColumnName="id")
     * })
     */
    private $adpays;

    /**
     * @var \Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nationalite", referencedColumnName="id")
     * })
     */
    private $nationalite;

    /**
     * @ORM\Column(name="type_orphelin",type="string", length=255, nullable=true)
     */
    private $typeOrphelin;

    /**
     * @ORM\Column(name="email_perso_updated",type="boolean", nullable=true)
     */
    private $emailPersoUpdated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getIne(): ?string
    {
        return $this->ine;
    }

    public function setIne(string $ine): self
    {
        $this->ine = $ine;

        return $this;
    }

    public function getNuminterne(): ?string
    {
        return $this->numinterne;
    }

    public function setNuminterne(string $numinterne): self
    {
        $this->numinterne = $numinterne;

        return $this;
    }

    public function getNometudiant(): ?string
    {
        return $this->nometudiant;
    }

    public function setNometudiant(string $nometudiant): self
    {
        $this->nometudiant = $nometudiant;

        return $this;
    }

    public function getPrenometudiant(): ?string
    {
        return $this->prenometudiant;
    }

    public function setPrenometudiant(string $prenometudiant): self
    {
        $this->prenometudiant = $prenometudiant;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss(): ?string
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getRegionnaiss(): ?string
    {
        return $this->regionnaiss;
    }

    public function setRegionnaiss(?string $regionnaiss): self
    {
        $this->regionnaiss = $regionnaiss;

        return $this;
    }

    public function getAdville(): ?string
    {
        return $this->adville;
    }

    public function setAdville(?string $adville): self
    {
        $this->adville = $adville;

        return $this;
    }

    public function getAdquartier(): ?string
    {
        return $this->adquartier;
    }

    public function setAdquartier(string $adquartier): self
    {
        $this->adquartier = $adquartier;

        return $this;
    }

    public function getAdruevilla(): ?string
    {
        return $this->adruevilla;
    }

    public function setAdruevilla(?string $adruevilla): self
    {
        $this->adruevilla = $adruevilla;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailUniv(): ?string
    {
        return $this->emailUniv;
    }

    public function setEmailUniv(?string $emailUniv): self
    {
        $this->emailUniv = $emailUniv;

        return $this;
    }

    public function getNotifmail(): ?bool
    {
        return $this->notifmail;
    }

    public function setNotifmail(?bool $notifmail): self
    {
        $this->notifmail = $notifmail;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLyceedeprovenance(): ?string
    {
        return $this->lyceedeprovenance;
    }

    public function setLyceedeprovenance(?string $lyceedeprovenance): self
    {
        $this->lyceedeprovenance = $lyceedeprovenance;

        return $this;
    }

    public function getTeletudiant(): ?string
    {
        return $this->teletudiant;
    }

    public function setTeletudiant(?string $teletudiant): self
    {
        $this->teletudiant = $teletudiant;

        return $this;
    }

    public function getTeletudiant2(): ?string
    {
        return $this->teletudiant2;
    }

    public function setTeletudiant2(?string $teletudiant2): self
    {
        $this->teletudiant2 = $teletudiant2;

        return $this;
    }

    public function getSeriebac(): ?string
    {
        return $this->seriebac;
    }

    public function setSeriebac(?string $seriebac): self
    {
        $this->seriebac = $seriebac;

        return $this;
    }

    public function getDiplomeentree(): ?string
    {
        return $this->diplomeentree;
    }

    public function setDiplomeentree(?string $diplomeentree): self
    {
        $this->diplomeentree = $diplomeentree;

        return $this;
    }

    public function getMoyennebac(): ?float
    {
        return $this->moyennebac;
    }

    public function setMoyennebac(?float $moyennebac): self
    {
        $this->moyennebac = $moyennebac;

        return $this;
    }

    public function getMentionbac(): ?string
    {
        return $this->mentionbac;
    }

    public function setMentionbac(?string $mentionbac): self
    {
        $this->mentionbac = $mentionbac;

        return $this;
    }

    public function getGroupepassage(): ?string
    {
        return $this->groupepassage;
    }

    public function setGroupepassage(?string $groupepassage): self
    {
        $this->groupepassage = $groupepassage;

        return $this;
    }

    public function getAnneeBac(): ?int
    {
        return $this->anneeBac;
    }

    public function setAnneeBac(int $anneeBac): self
    {
        $this->anneeBac = $anneeBac;

        return $this;
    }

    public function getHandicap(): ?string
    {
        return $this->handicap;
    }

    public function setHandicap(string $handicap): self
    {
        $this->handicap = $handicap;

        return $this;
    }

    public function getTypeHandicap(): ?string
    {
        return $this->typeHandicap;
    }

    public function setTypeHandicap(?string $typeHandicap): self
    {
        $this->typeHandicap = $typeHandicap;

        return $this;
    }

    public function getDescriptionHandicap(): ?string
    {
        return $this->descriptionHandicap;
    }

    public function setDescriptionHandicap(?string $descriptionHandicap): self
    {
        $this->descriptionHandicap = $descriptionHandicap;

        return $this;
    }

    public function getOrphelin(): ?string
    {
        return $this->orphelin;
    }

    public function setOrphelin(string $orphelin): self
    {
        $this->orphelin = $orphelin;

        return $this;
    }

    public function getSituationMatrimoniale(): ?string
    {
        return $this->situationMatrimoniale;
    }

    public function setSituationMatrimoniale(string $situationMatrimoniale): self
    {
        $this->situationMatrimoniale = $situationMatrimoniale;

        return $this;
    }

    public function getNomconjoint(): ?string
    {
        return $this->nomconjoint;
    }

    public function setNomconjoint(?string $nomconjoint): self
    {
        $this->nomconjoint = $nomconjoint;

        return $this;
    }

    public function getNbreenfant(): ?int
    {
        return $this->nbreenfant;
    }

    public function setNbreenfant(?int $nbreenfant): self
    {
        $this->nbreenfant = $nbreenfant;

        return $this;
    }

    public function getNomcontact(): ?string
    {
        return $this->nomcontact;
    }

    public function setNomcontact(?string $nomcontact): self
    {
        $this->nomcontact = $nomcontact;

        return $this;
    }

    public function getTelcontact(): ?string
    {
        return $this->telcontact;
    }

    public function setTelcontact(?string $telcontact): self
    {
        $this->telcontact = $telcontact;

        return $this;
    }

    public function getIdpays(): ?Pays
    {
        return $this->idpays;
    }

    public function setIdpays(?Pays $idpays): self
    {
        $this->idpays = $idpays;

        return $this;
    }

    public function getAdpays(): ?Pays
    {
        return $this->adpays;
    }

    public function setAdpays(?Pays $adpays): self
    {
        $this->adpays = $adpays;

        return $this;
    }

    public function getNationalite(): ?Pays
    {
        return $this->nationalite;
    }

    public function setNationalite(?Pays $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getTypeOrphelin(): ?string
    {
        return $this->typeOrphelin;
    }

    public function setTypeOrphelin(?string $typeOrphelin): self
    {
        $this->typeOrphelin = $typeOrphelin;

        return $this;
    }

    public function getEmailPersoUpdated(): ?bool
    {
        return $this->emailPersoUpdated;
    }

    public function setEmailPersoUpdated(?bool $emailPersoUpdated): self
    {
        $this->emailPersoUpdated = $emailPersoUpdated;

        return $this;
    }


}
