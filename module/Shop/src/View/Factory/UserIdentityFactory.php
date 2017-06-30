<?php

namespace Shop\View\Factory;
use Interop\Container\ContainerInterface;
use Shop\View\Helper\UserIdentity;
use Zend\ServiceManager\Factory\FactoryInterface;


class UserIdentityFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        return new UserIdentity($entityManager,$authService);
    }
}