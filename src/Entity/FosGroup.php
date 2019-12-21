<?php
namespace App\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class FosGroup extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="codegroupe", type="string", length=45, nullable=false)
     */
    private $codegroupe;

    public function __construct() {
    }
    
    /**
     * Set codegroupe
     *
     * @param string $codegroupe
     *
     * @return FosGroup
     */
    public function setCodegroupe($codegroupe)
    {
        $this->codegroupe = $codegroupe;

        return $this;
    }

    /**
     * Get codegroupe
     *
     * @return string
     */
    public function getCodegroupe()
    {
        return $this->codegroupe;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return FosGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
	public function __toString() 
    {
        return $this->name;
    }
}
