<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantOld
 *
 * @ORM\Table(name="etudiant_old", uniqueConstraints={@ORM\UniqueConstraint(name="numInterne_UNIQUE", columns={"numInterne"}), @ORM\UniqueConstraint(name="ine_UNIQUE", columns={"ine"}), @ORM\UniqueConstraint(name="cni_UNIQUE", columns={"cni"})})
 * @ORM\Entity
 */
class EtudiantOld
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
     * @var int
     *
     * @ORM\Column(name="idPays", type="integer", nullable=false)
     */
    private $idpays;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=45, nullable=false)
     */
    private $nationalite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="adPays", type="integer", nullable=true)
     */
    private $adpays;

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
     * @var string
     *
     * @ORM\Column(name="adRueVilla", type="string", length=100, nullable=false)
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

    public function getIdpays(): ?int
    {
        return $this->idpays;
    }

    public function setIdpays(int $idpays): self
    {
        $this->idpays = $idpays;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getAdpays(): ?int
    {
        return $this->adpays;
    }

    public function setAdpays(?int $adpays): self
    {
        $this->adpays = $adpays;

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

    public function setAdruevilla(string $adruevilla): self
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


}
