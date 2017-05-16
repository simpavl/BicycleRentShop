<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoleLinker
 *
 * @ORM\Table(name="user_role_linker", indexes={@ORM\Index(name="role_id", columns={"role_id"})})
 * @ORM\Entity
 */
class UserRoleLinker
{
    /**
     * @var \Shop\Entity\UserRole
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $role;

    /**
     * @var \Shop\Entity\User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Shop\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


    /**
     * Set role
     *
     * @param \Shop\Entity\UserRole $role
     *
     * @return UserRoleLinker
     */
    public function setRole(\Shop\Entity\UserRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Shop\Entity\UserRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set user
     *
     * @param \Shop\Entity\User $user
     *
     * @return UserRoleLinker
     */
    public function setUser(\Shop\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Shop\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

