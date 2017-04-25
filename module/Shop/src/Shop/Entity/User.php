<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="useractive", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $useractive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $password;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set useractive
     *
     * @param boolean $useractive
     *
     * @return User
     */
    public function setUseractive($useractive)
    {
        $this->useractive = $useractive;

        return $this;
    }

    /**
     * Get useractive
     *
     * @return boolean
     */
    public function getUseractive()
    {
        return $this->useractive;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}

