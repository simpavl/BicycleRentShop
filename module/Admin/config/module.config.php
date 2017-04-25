<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Navigation\Service\NavigationAbstractServiceFactory;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'admin' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/admin/',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],

                'may_terminate' => true,
                'child_routes' => [
                    'category' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route' => 'category[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\CategoryController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'article' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route' => 'article[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ArticleController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ], //child routes
            ],

        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            NavigationAbstractServiceFactory::class,
        ],
    ],
    'navigation' => [

        'default'=> [
            [
                'label' => 'Главная',
                'route' => 'home',
            ],
        ],
        'admin_navigation' => [
            [
                'label' => 'Панель управления сайтом',
                'route' => 'admin',
                'action' => 'index',
                'resource' => 'Admin\Controller\Index',

                'pages' => [
                    [
                        'label' => 'Статьи',
                        'route' => 'admin/article',
                        'action' => 'index',
                    ],
                    [
                        'label' => 'Добавить статью',
                        'route' => 'admin/article',
                        'action' => 'add',
                    ],
                    [
                        'label' => 'Категории',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ],
                    [
                        'label' => 'Добавить категории',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ],
                    /*[
                        'label' => 'Комментарии',
                        'route' => 'admin/comment',
                        'action' => 'index',
                    ],*/
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\CategoryController::class => Controller\Factory\CategoryControllerFactory::class,
            Controller\ArticleController::class => Controller\Factory\ArticleControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'admin' => __DIR__ . '/../view',
        ],
        'template_map' => [
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ],
    ],
    'module_layouts' => [
        'Admin' => 'layout/admin-layout',
    ],
];