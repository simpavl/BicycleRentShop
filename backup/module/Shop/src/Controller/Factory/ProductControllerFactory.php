<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\ProductController;
use Shop\Service\ProductManager;

class ProductControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productManager = $container->get(ProductManager::class);


        return new ProductController($entityManager, $productManager);
    }
}