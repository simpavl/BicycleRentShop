<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Shop\Service\ProductManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\CartController;

class CartControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productManager = $container->get(ProductManager::class);

        return new CartController($entityManager,$productManager);
    }
}