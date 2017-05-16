<?php

namespace Shop\Controller\Factory;
use Interop\Container\ContainerInterface;
use Shop\Service\OrderManager;
use Shop\Service\ProductManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Shop\Controller\OrderController;

class OrderControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $orderManager = $container->get(OrderManager::class);
        $productManager = $container->get(ProductManager::class);

        return new OrderController($entityManager,$orderManager,$productManager);
    }
}