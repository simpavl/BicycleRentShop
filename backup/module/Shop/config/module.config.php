<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Shop;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use ShoppingCart\Controller\Plugin\ShoppingCart;

return [
    'router' => [
        'routes' => [
            'shop' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/shop[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/user[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'product' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'cart' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cart[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CartController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'order' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/order[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\OrderController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\AdminController::class => Controller\Factory\AdminControllerFactory::class,
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            Controller\ProductController::class => Controller\Factory\ProductControllerFactory::class,
            Controller\CartController::class => Controller\Factory\CartControllerFactory::class,
            Controller\OrderController::class => Controller\Factory\OrderControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'layout/admin'           => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            'shop' => __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\CategoryManager::class => Service\Factory\CategoryManagerFactory::class,
            Service\UserManager::class=>Service\Factory\UserManagerFactory::class,
            Service\ProductManager::class => Service\Factory\ProductManagerFactory::class,
            Service\OrderManager::class => Service\Factory\OrderManagerFactory::class,
            Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            'navigation' => Zend\Navigation\Service\DefaultNavigationFactory::class,

        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    /*'access_filter' => [
        'controllers' => [
            Controller\AdminController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                ['actions' => [''], 'allow' => '*' ],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'add-category', 'edit-category', 'delete-category','users-list', 'add-user', 'view-user', 'edit-user'], 'allow' => '@']
            ],
            Controller\IndexController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                ['actions' => [''], 'allow' => '*' ],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'add-category', 'edit-category', 'delete-category','users-list', 'add-user', 'view-user', 'edit-user'], 'allow' => '@']
            ],
        ]
    ],*/
    'access_filter' => [
        'controllers' => [
            Controller\IndexController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                'user' => ['index'],
                'admin' => [''],
            ],
            Controller\AdminController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                'user' => ['index'],
                'admin' => ['index', 'editSubCategory', 'addCategory', 'editCategory',
                    'deleteCategory','usersList', 'addUser', 'viewUser', 'editUser','editSubCategory',
                    'addSubCategory','addProduct','editProduct','categories','subcategories','users','products','orders'],
            ],
            Controller\ProductController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                'user' => ['index','view'],
                'admin' => ['index', 'test'],
            ],
            Controller\CartController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                'user' => ['index'],
                'admin' => ['index'],
            ],
            Controller\OrderController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                'user' => ['index'],
                'admin' => ['index'],
            ],
        ]
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'admin',
                'pages' => [
                    [
                        'label'  => 'Add category',
                        'route'  => 'admin',
                        'action' => 'add-category',
                    ],
                    [
                        'label'  => 'Categories',
                        'route'  => 'admin',
                        'action' => 'categories',
                    ],
                    [
                        'label'  => 'Subcategories',
                        'route'  => 'admin',
                        'action' => 'subcategories',
                    ],
                    [
                        'label'  => 'Add subcategory',
                        'route'  => 'admin',
                        'action' => 'add-sub-category',
                    ],
                    [
                        'label'  => 'Users',
                        'route'  => 'admin',
                        'action' => 'users',
                    ],
                    [
                        'label'  => 'Add user',
                        'route'  => 'admin',
                        'action' => 'add-user',
                    ],
                    [
                        'label'  => 'Products',
                        'route'  => 'admin',
                        'action' => 'products',
                    ],
                    [
                        'label'  => 'Add product',
                        'route'  => 'admin',
                        'action' => 'add-product',
                    ],
                    [
                        'label'  => 'Orders',
                        'route'  => 'admin',
                        'action' => 'orders',
                    ],
                    [
                        'label'  => 'Dashboard',
                        'route'  => 'admin',
                    ],
                ],
            ],
        ],
    ],
];