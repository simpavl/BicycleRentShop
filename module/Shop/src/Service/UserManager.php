<?php
namespace Shop\Service;
use Shop\Entity\User;
use Shop\Entity\UserRole;
use Shop\Entity\UserRoleLinker;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{

    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addUser($data)
    {
        // Do not allow several users with the same email address.
        if($this->checkUserExists($data['email'])) {
            throw new \Exception("User with email address " . $data['$email'] . " already exists");
        }

        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFirstname($data['first_name']);
        $user->setSurname($data['last_name']);
        // Encrypt password and store the password in encrypted state.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->setPassword($passwordHash);

        $user->setUseractive($data['status']);
        $user->setGender($data['gender']);
        /*$currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);*/

        // Add the entity to the entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();

        return $user;
    }

    public function registerUser($data)
    {
        // Do not allow several users with the same email address.
        if($this->checkUserExists($data['email'])) {
            throw new \Exception("User with email address " . $data['$email'] . " already exists");
        }
        $linker = new UserRoleLinker();
        $userrole = $this->entityManager->getRepository(UserRole::class)->findOneByRoleId('user');
        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFirstname($data['first_name']);
        $user->setSurname($data['last_name']);
        // Encrypt password and store the password in encrypted state.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->setPassword($passwordHash);

        $user->setUseractive('1');
        $user->setRole('user');
        /*$currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);*/
        // Add the entity to the entity manager.
        $this->entityManager->persist($user);
        $linker->setUserid($user);
        $linker->setRoleid($userrole);
        $this->entityManager->persist($linker);
        // Apply changes to database.
        $this->entityManager->flush();

        return $user;
    }

    /**
     * This method updates data of an existing user.
     */
    public function updateUser($user, $data)
    {
        // Do not allow to change user email if another user with such email already exits.
        if($user->getEmail()!=$data['email'] && $this->checkUserExists($data['email'])) {
            throw new \Exception("Another user with email address " . $data['email'] . " already exists");
        }

        $user->setEmail($data['email']);
        $user->setFirstname($data['first_name']);
        $user->setSurname($data['last_name']);
        $user->setUseractive($data['status']);
        $user->setGender($data['gender']);
        // Apply changes to database.
        $this->entityManager->flush();
        return true;
    }

    public function checkUserExists($email) {

        $user = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($email);

        return $user !== null;
    }

    public function editUser($user, $data)
    {
        $user->setFirstname($data['first_name']);
        $user->setSurname($data['last_name']);
        $user->setGender($data['gender']);
        $this->entityManager->flush();
    }

}