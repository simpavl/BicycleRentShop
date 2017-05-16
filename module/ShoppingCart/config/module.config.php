<?php

return [
    'router' => [
        'routes' => [
                   
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            ShoppingCart\Controller\Plugin\ShoppingCart::class => ShoppingCart\Factory\ShoppingCartFactory::class,
        ],
		'aliases' => [
			'ShoppingCart' => ShoppingCart\Controller\Plugin\ShoppingCart::class,
		]
    ]
];
