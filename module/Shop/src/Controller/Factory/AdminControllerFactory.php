<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\AdminController;
use Shop\Service\CategoryManager;
use Shop\Service\UserManager;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $categoryManager = $container->get(CategoryManager::class);
        $userManager = $container->get(UserManager::class);

        return new AdminController($entityManager, $categoryManager, $userManager);
    }
}