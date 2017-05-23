<?php

namespace Shop\Service\Factory;

use Interop\Container\ContainerInterface;
use Shop\Service\IndexManager;
use Zend\ServiceManager\Factory\FactoryInterface;



class IndexManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new IndexManager($entityManager);
    }
}