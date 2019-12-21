<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class FosUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $prenom;
	
	/**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nom;
	
	/**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $sexe;
	
	/**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $titre;
      /**
     * @var \Profil
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profession", referencedColumnName="id")
     * })
     */
    private $profession;
	
	/**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true)
     */
    private $statut;
	
	/**
     * @ORM\ManyToMany(targetEntity="App\Entity\FosGroup")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * @var \FosGroup
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FosGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idGroup", referencedColumnName="id")
     * })
     */
    private $idgroup;
    
    /**
     * @var \Entite
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Entite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entiteprincipale", referencedColumnName="id")
     * })
     */
    private $entiteprincipale;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_activity;
	
	/**
     * Is online (if the last activity was within the last 5 minutes)
     *
     * @return boolean
     */
    public function isOnline()
    {
        $now = new \DateTime();
        $now->modify('-5 minutes');
        return $this->getLastActivity() > $now;
    }
 
    

	
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
	
	/**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }
	
	/**
     * Set titre
     *
     * @param string $titre
     *
     * @return User
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
	

     /**
     * Set profession
     *
     * @param \App\Entity\Profil $profession
     *
     * @return FosUser
     */
    public function setProfession(\App\Entity\Profil $profession = null)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return \App\Entity\Profil
     */
    public function getProfession()
    {
        return $this->profession;
    }
    
	/**
     * Set photo
     *
     * @param string $photo
     *
     * @return FosUser
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    
    /**
     * Set idgroup
     *
     * @param \App\Entity\FosGroup $idgroup
     *
     * @return FosUser
     */
    public function setIdgroup(\App\Entity\FosGroup $idgroup = null)
    {
        $this->idgroup = $idgroup;

        return $this;
    }

    /**
     * Get idgroup
     *
     * @return \App\Entity\FosGroup
     */
    public function getIdgroup()
    {
        return $this->idgroup;
    }
    
    /**
     * Set entiteprincipale
     *
     * @param \App\Entity\Entite $entiteprincipale
     *
     * @return FosUser
     */
    public function setEntiteprincipale(\App\Entity\Entite $entiteprincipale = null)
    {
        $this->entiteprincipale = $entiteprincipale;

        return $this;
    }

    /**
     * Get entiteprincipale
     *
     * @return \App\Entity\Entite
     */
    public function getEntiteprincipale()
    {
        return $this->entiteprincipale;
    }
    
    
    /**
     * Set last_activity
     *
     * @param \DateTime $lastActivity
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->last_activity = $lastActivity;
     
        return $this;
    }
 
    /**
     * Get last_activity
     *
     * @return \DateTime
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }
    
    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return FosUser
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean
     */
    public function getStatut()
    {
        return $this->statut;
    }
	
}