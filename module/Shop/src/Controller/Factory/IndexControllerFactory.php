<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Shop\Service\IndexManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $indexManager = $container->get(IndexManager::class);

        return new IndexController($entityManager,$indexManager);
    }
}