<?php

namespace Shop\Service\Factory;

use Interop\Container\ContainerInterface;
use Shop\Service\CategoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;



class CategoryManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new CategoryManager($entityManager);
    }
}