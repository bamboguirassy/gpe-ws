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
    private $notifmail;

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

    /**
     * @ORM\Column(type="string", length=115, nullable=true)
     */
    private $typeHabitation;

    /**
     * @ORM\Column(type="string", length=115, nullable=true)
     */
    private $campusSocial;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroChambre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quartierEtudiant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoLink;

    public function getId()
    {
        return $this->id;
    }

    public function getCni()
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getIne()
    {
        return $this->ine;
    }

    public function setIne($ine): self
    {
        $this->ine = $ine;

        return $this;
    }

    public function getNuminterne()
    {
        return $this->numinterne;
    }

    public function setNuminterne(string $numinterne): self
    {
        $this->numinterne = $numinterne;

        return $this;
    }

    public function getNometudiant()
    {
        return $this->nometudiant;
    }

    public function setNometudiant(string $nometudiant): self
    {
        $this->nometudiant = $nometudiant;

        return $this;
    }

    public function getPrenometudiant()
    {
        return $this->prenometudiant;
    }

    public function setPrenometudiant(string $prenometudiant): self
    {
        $this->prenometudiant = $prenometudiant;

        return $this;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDatenaiss()
    {
        return $this->datenaiss;
    }

    public function setDatenaiss($datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss()
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getRegionnaiss()
    {
        return $this->regionnaiss;
    }

    public function setRegionnaiss($regionnaiss): self
    {
        $this->regionnaiss = $regionnaiss;

        return $this;
    }

    public function getAdville()
    {
        return $this->adville;
    }

    public function setAdville($adville): self
    {
        $this->adville = $adville;

        return $this;
    }

    public function getAdquartier()
    {
        return $this->adquartier;
    }

    public function setAdquartier(string $adquartier): self
    {
        $this->adquartier = $adquartier;

        return $this;
    }

    public function getAdruevilla()
    {
        return $this->adruevilla;
    }

    public function setAdruevilla($adruevilla): self
    {
        $this->adruevilla = $adruevilla;

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

    public function getEmailUniv()
    {
        return $this->emailUniv;
    }

    public function setEmailUniv($emailUniv): self
    {
        $this->emailUniv = $emailUniv;

        return $this;
    }

    public function getNotifmail()
    {
        return $this->notifmail;
    }

    public function setNotifmail($notifmail): self
    {
        $this->notifmail = $notifmail;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLyceedeprovenance()
    {
        return $this->lyceedeprovenance;
    }

    public function setLyceedeprovenance($lyceedeprovenance): self
    {
        $this->lyceedeprovenance = $lyceedeprovenance;

        return $this;
    }

    public function getTeletudiant()
    {
        return $this->teletudiant;
    }

    public function setTeletudiant($teletudiant): self
    {
        $this->teletudiant = $teletudiant;

        return $this;
    }

    public function getTeletudiant2()
    {
        return $this->teletudiant2;
    }

    public function setTeletudiant2($teletudiant2): self
    {
        $this->teletudiant2 = $teletudiant2;

        return $this;
    }

    public function getSeriebac()
    {
        return $this->seriebac;
    }

    public function setSeriebac($seriebac): self
    {
        $this->seriebac = $seriebac;

        return $this;
    }

    public function getDiplomeentree()
    {
        return $this->diplomeentree;
    }

    public function setDiplomeentree($diplomeentree): self
    {
        $this->diplomeentree = $diplomeentree;

        return $this;
    }

    public function getMoyennebac()
    {
        return $this->moyennebac;
    }

    public function setMoyennebac($moyennebac): self
    {
        $this->moyennebac = $moyennebac;

        return $this;
    }

    public function getMentionbac()
    {
        return $this->mentionbac;
    }

    public function setMentionbac($mentionbac): self
    {
        $this->mentionbac = $mentionbac;

        return $this;
    }

    public function getGroupepassage()
    {
        return $this->groupepassage;
    }

    public function setGroupepassage($groupepassage): self
    {
        $this->groupepassage = $groupepassage;

        return $this;
    }

    public function getAnneeBac()
    {
        return $this->anneeBac;
    }

    public function setAnneeBac(int $anneeBac): self
    {
        $this->anneeBac = $anneeBac;

        return $this;
    }

    public function getHandicap()
    {
        return $this->handicap;
    }

    public function setHandicap(string $handicap): self
    {
        $this->handicap = $handicap;

        return $this;
    }

    public function getTypeHandicap()
    {
        return $this->typeHandicap;
    }

    public function setTypeHandicap($typeHandicap): self
    {
        $this->typeHandicap = $typeHandicap;

        return $this;
    }

    public function getDescriptionHandicap()
    {
        return $this->descriptionHandicap;
    }

    public function setDescriptionHandicap($descriptionHandicap): self
    {
        $this->descriptionHandicap = $descriptionHandicap;

        return $this;
    }

    public function getOrphelin()
    {
        return $this->orphelin;
    }

    public function setOrphelin(string $orphelin): self
    {
        $this->orphelin = $orphelin;

        return $this;
    }

    public function getSituationMatrimoniale()
    {
        return $this->situationMatrimoniale;
    }

    public function setSituationMatrimoniale(string $situationMatrimoniale): self
    {
        $this->situationMatrimoniale = $situationMatrimoniale;

        return $this;
    }

    public function getNomconjoint()
    {
        return $this->nomconjoint;
    }

    public function setNomconjoint($nomconjoint): self
    {
        $this->nomconjoint = $nomconjoint;

        return $this;
    }

    public function getNbreenfant()
    {
        return $this->nbreenfant;
    }

    public function setNbreenfant($nbreenfant): self
    {
        $this->nbreenfant = $nbreenfant;

        return $this;
    }

    public function getNomcontact()
    {
        return $this->nomcontact;
    }

    public function setNomcontact($nomcontact): self
    {
        $this->nomcontact = $nomcontact;

        return $this;
    }

    public function getTelcontact()
    {
        return $this->telcontact;
    }

    public function setTelcontact($telcontact): self
    {
        $this->telcontact = $telcontact;

        return $this;
    }

    public function getIdpays()
    {
        return $this->idpays;
    }

    public function setIdpays($idpays): self
    {
        $this->idpays = $idpays;

        return $this;
    }

    public function getAdpays()
    {
        return $this->adpays;
    }

    public function setAdpays($adpays): self
    {
        $this->adpays = $adpays;

        return $this;
    }

    public function getNationalite()
    {
        return $this->nationalite;
    }

    public function setNationalite($nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getTypeOrphelin()
    {
        return $this->typeOrphelin;
    }

    public function setTypeOrphelin($typeOrphelin): self
    {
        $this->typeOrphelin = $typeOrphelin;

        return $this;
    }

    public function getEmailPersoUpdated()
    {
        return $this->emailPersoUpdated;
    }

    public function setEmailPersoUpdated($emailPersoUpdated): self
    {
        $this->emailPersoUpdated = $emailPersoUpdated;

        return $this;
    }

    public function getTypeHabitation()
    {
        return $this->typeHabitation;
    }

    public function setTypeHabitation($typeHabitation): self
    {
        $this->typeHabitation = $typeHabitation;

        return $this;
    }

    public function getCampusSocial()
    {
        return $this->campusSocial;
    }

    public function setCampusSocial($campusSocial): self
    {
        $this->campusSocial = $campusSocial;

        return $this;
    }

    public function getNumeroChambre()
    {
        return $this->numeroChambre;
    }

    public function setNumeroChambre($numeroChambre): self
    {
        $this->numeroChambre = $numeroChambre;

        return $this;
    }

    public function getQuartierEtudiant()
    {
        return $this->quartierEtudiant;
    }

    public function setQuartierEtudiant($quartierEtudiant): self
    {
        $this->quartierEtudiant = $quartierEtudiant;

        return $this;
    }

    public function getPhotoLink()
    {
        return $this->photoLink;
    }

    public function setPhotoLink($photoLink): self
    {
        $this->photoLink = $photoLink;

        return $this;
    }


}
