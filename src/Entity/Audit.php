<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="audit", indexes={@ORM\Index(name="fk_Audit_User1_idx", columns={"idUser"})})
 * @ORM\Entity
 */
class Audit
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
     * @var string|null
     *
     * @ORM\Column(name="actionAudit", type="string", length=45, nullable=true)
     */
    private $actionaudit;

    /**
     * @var string
     *
     * @ORM\Column(name="entite", type="string", length=255, nullable=false)
     */
    private $entite;

    /**
     * @var int
     *
     * @ORM\Column(name="identite", type="integer", nullable=false)
     */
    private $identite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="oldvalue", type="string", length=255, nullable=true)
     */
    private $oldvalue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="newvalue", type="string", length=255, nullable=true)
     */
    private $newvalue;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresseIPUtilisateur", type="string", length=45, nullable=true)
     */
    private $adresseiputilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateActionAudit", type="datetime", nullable=false)
     */
    private $dateactionaudit;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionaudit(): ?string
    {
        return $this->actionaudit;
    }

    public function setActionaudit(?string $actionaudit): self
    {
        $this->actionaudit = $actionaudit;

        return $this;
    }

    public function getEntite(): ?string
    {
        return $this->entite;
    }

    public function setEntite(string $entite): self
    {
        $this->entite = $entite;

        return $this;
    }

    public function getIdentite(): ?int
    {
        return $this->identite;
    }

    public function setIdentite(int $identite): self
    {
        $this->identite = $identite;

        return $this;
    }

    public function getOldvalue(): ?string
    {
        return $this->oldvalue;
    }

    public function setOldvalue(?string $oldvalue): self
    {
        $this->oldvalue = $oldvalue;

        return $this;
    }

    public function getNewvalue(): ?string
    {
        return $this->newvalue;
    }

    public function setNewvalue(?string $newvalue): self
    {
        $this->newvalue = $newvalue;

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

    public function getAdresseiputilisateur(): ?string
    {
        return $this->adresseiputilisateur;
    }

    public function setAdresseiputilisateur(?string $adresseiputilisateur): self
    {
        $this->adresseiputilisateur = $adresseiputilisateur;

        return $this;
    }

    public function getDateactionaudit(): ?\DateTimeInterface
    {
        return $this->dateactionaudit;
    }

    public function setDateactionaudit(\DateTimeInterface $dateactionaudit): self
    {
        $this->dateactionaudit = $dateactionaudit;

        return $this;
    }

    public function getIduser(): ?FosUser
    {
        return $this->iduser;
    }

    public function setIduser(?FosUser $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
