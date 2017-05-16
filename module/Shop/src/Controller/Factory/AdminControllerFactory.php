<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\AdminController;
use Shop\Service\CategoryManager;
use Shop\Service\UserManager;
use Shop\Service\ProductManager;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $categoryManager = $container->get(CategoryManager::class);
        $userManager = $container->get(UserManager::class);
        $productManager = $container->get(ProductManager::class);
        $authenticationService = $container->get(\Zend\Authentication\AuthenticationService::class);
        return new AdminController($entityManager, $categoryManager, $userManager, $productManager, $authenticationService);
    }
}