<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FosUserUserGroup
 *
 * @ORM\Table(name="fos_user_user_group", uniqueConstraints={@ORM\UniqueConstraint(name="user_id", columns={"user_id", "group_id"})}, indexes={@ORM\Index(name="group_id", columns={"group_id"}), @ORM\Index(name="IDX_B3C77447A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class FosUserUserGroup
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
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \FosGroup
     *
     * @ORM\ManyToOne(targetEntity="FosGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?FosUser
    {
        return $this->user;
    }

    public function setUser(?FosUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGroup(): ?FosGroup
    {
        return $this->group;
    }

    public function setGroup(?FosGroup $group): self
    {
        $this->group = $group;

        return $this;
    }


}
