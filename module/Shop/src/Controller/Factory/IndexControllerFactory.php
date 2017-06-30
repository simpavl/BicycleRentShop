<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Shop\Service\IndexManager;
use Shop\Service\ProductManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $indexManager = $container->get(IndexManager::class);
        $productManager = $container->get(ProductManager::class);
        return new IndexController($entityManager,$indexManager,$productManager);
    }
}