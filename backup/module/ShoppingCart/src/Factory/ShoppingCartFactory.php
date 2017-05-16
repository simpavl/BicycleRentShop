<?php
/**
 * ShoppingCart Factory
 * Initializate Shopping Cart
 * 
 * @package ShoppingCart
 * @subpackage Factory
 * @author Aleksander Cyrkulewski
 */
namespace ShoppingCart\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;
use Zend\Session\Container;
use ShoppingCart\Controller\Plugin\ShoppingCart;
use ShoppingCart\Hydrator\ShoppingCartHydrator;
use ShoppingCart\Entity\ShoppingCartEntity;

class ShoppingCartFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$allServices = $servicelocator->getServiceLocator();
        $config = $container->get('ServiceManager')->get('Configuration');

        if (! isset($config['shopping_cart'])) {
            throw new \Exception('Configuration ShoppingCart not set.');
        }

        $cart = new ShoppingCart();
        $cart->setHydrator(new ShoppingCartHydrator());
        $cart->setEntityPrototype(new ShoppingCartEntity());
        $cart->setSession(new Container($config['shopping_cart']['session_name']));
        $cart->setConfig($config['shopping_cart']);
        return $cart;
    }
}