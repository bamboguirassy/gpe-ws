<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFiliere
 *
 * @ORM\Table(name="user_filiere", uniqueConstraints={@ORM\UniqueConstraint(name="idUser", columns={"idUser", "idFiliere"})}, indexes={@ORM\Index(name="idFiliere", columns={"idFiliere"})})
 * @ORM\Entity
 */
class UserFiliere
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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Filiere
     *
     * @ORM\ManyToOne(targetEntity="Filiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFiliere", referencedColumnName="id")
     * })
     */
    private $idfiliere;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set iduser
     *
     * @param \App\Entity\FosUser $iduser
     *
     * @return UserFiliere
     */
    public function setIduser(\App\Entity\FosUser $iduser = null) {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \App\Entity\FosUser
     */
    public function getIduser() {
        return $this->iduser;
    }

    /**
     * Set idfiliere
     *
     * @param \App\Entity\Filiere $idfiliere
     *
     * @return UserFiliere
     */
    public function setIdfiliere(\App\Entity\Filiere $idfiliere = null) {
        $this->idfiliere = $idfiliere;

        return $this;
    }

    /**
     * Get idfiliere
     *
     * @return \App\Entity\Filiere
     */
    public function getIdfiliere() {

        return $this->idfiliere;
    }


}
