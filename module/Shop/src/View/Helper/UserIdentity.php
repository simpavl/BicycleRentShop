<?php
namespace Shop\View\Helper;

use Shop\Entity\User;
use Zend\View\Helper\AbstractHelper;


class UserIdentity extends AbstractHelper
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    private $user;


    public function __construct($entityManager, $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->user = $this->entityManager->getRepository(User::class)->findOneByEmail($this->authService->getIdentity());
    }

    public function getFirstName(){
        return $this->user->getFirstname();
    }

    public function getLastName(){
        return $this->user->getSurname();
    }

    public function getFullName(){
        return $this->getFirstName() . ' ' . $this->getLastName();
    }



}