<?php

namespace Testmodule\Controller\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Testmodule\Controller\UserController;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AccessService;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userMapper = $container->get(UserMapper::class);
        $accessService = $container->get(AccessService::class);

        return new UserController($accessService,$userMapper);
    }
}