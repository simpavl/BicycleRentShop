<?php

namespace Shop\Service\Factory;

use Interop\Container\ContainerInterface;
use Shop\Service\OrderManager;
use Zend\ServiceManager\Factory\FactoryInterface;



class OrderManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authenticationService = $container->get(\Zend\Authentication\AuthenticationService::class);

        return new OrderManager($authenticationService, $entityManager );
    }
}