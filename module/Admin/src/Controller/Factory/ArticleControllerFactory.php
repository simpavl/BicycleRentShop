<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 09.04.2017
 * Time: 19:46
 */
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\ArticleController;


/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */

class ArticleControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        // Instantiate the controller and inject dependencies
        return new ArticleController($entityManager);
    }
}
