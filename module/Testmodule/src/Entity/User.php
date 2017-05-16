<?php

namespace Testmodule\Entity;

use CirclicalUser\Provider\RoleInterface;
use CirclicalUser\Provider\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Testmodule\Entity\User
 *
 * Sample user entity that I use in my own projects.  Might help?
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 */
class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     */
    protected $id;


    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;


    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $first_name;


    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $last_name;


    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true, options={"default"=null,"unsigned"=true})
     */
    protected $company_id;


    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $address;


    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $city;


    /**
     * @var string
     * @ORM\Column(type="string", length=2)
     */
    protected $country;


    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    protected $zip;


    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    protected $phone;


    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    protected $state;


    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     */
    protected $language;


    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    protected $currency;


    /**
     * @ORM\Column(type="datetime")
     */
    protected $time_registered;


    /**
     * A day of month that represents their billing anniversary day
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $billing_anniversary;


    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true, options={"default"=null,"unsigned"=true})
     */
    protected $has_profile_image;


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="CirclicalUser\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;


    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles[] = $role;
    }

    /**
     * @return mixed
     */
    public function getTimeRegistered()
    {
        return $this->time_registered;
    }

    /**
     * @param mixed $time_registered
     */
    public function setTimeRegistered($time_registered)
    {
        $this->time_registered = $time_registered;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param string $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getBillingAnniversary()
    {
        return $this->billing_anniversary;
    }

    /**
     * @param int $billing_anniversary
     */
    public function setBillingAnniversary($billing_anniversary)
    {
        $this->billing_anniversary = $billing_anniversary;
    }

    /**
     * @return int
     */
    public function getHasProfileImage()
    {
        return $this->has_profile_image;
    }

    /**
     * @param int $has_profile_image
     */
    public function setHasProfileImage($has_profile_image)
    {
        $this->has_profile_image = $has_profile_image;
    }

    public function getProfileImage()
    {
        return $this->id . '_' . substr(md5($this->getTimeRegistered()->format(\DateTime::RFC3339) . $this->getId()), 0, 8) . '.png';
    }

}