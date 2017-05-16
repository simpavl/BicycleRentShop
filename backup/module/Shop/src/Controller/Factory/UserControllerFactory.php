<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\UserController;
use Shop\Service\AuthManager;
use Shop\Service\UserManager;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $userManager = $container->get(UserManager::class);

        return new UserController($entityManager,$authManager,$authService,$userManager);
    }
}