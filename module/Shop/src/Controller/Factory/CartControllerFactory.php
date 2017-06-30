<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Shop\Service\OrderManager;
use Shop\Service\ProductManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\CartController;

class CartControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productManager = $container->get(ProductManager::class);
        $orderManager = $container->get(OrderManager::class);
        return new CartController($entityManager,$orderManager,$productManager);
    }
}