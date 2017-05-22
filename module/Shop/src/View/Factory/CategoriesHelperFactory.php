<?php

namespace Shop\View\Factory;
use Interop\Container\ContainerInterface;
use Shop\View\Helper\CategoriesHelper;
use Shop\View\Helper\UserIdentity;
use Zend\ServiceManager\Factory\FactoryInterface;


class CategoriesHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new CategoriesHelper($entityManager);
    }
}