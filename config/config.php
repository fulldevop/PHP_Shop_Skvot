<?php

use app\engine\Db;
use app\engine\Request;
use app\models\repositories\ProductRepository;
use app\models\repositories\BasketRepository;
use app\models\repositories\UserRepository;
use app\models\repositories\OrdersRepository;
use app\models\repositories\StatusRepository;

return [
    'root_dir' => __DIR__ . "/../",
    'templates_dir' => __DIR__ . "/../views/",
    'twig_dir' => __DIR__ . "/../twig/",
    'controllers_namespaces' => "app\controllers\\",
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3307',
            'login' => 'root',
            'password' => '',
            'database' => 'skvot',
            'charset' => 'utf8'
        ],
        'request' => [
            'class' => Request::class
        ],
        'productRepository' => [
            'class' => ProductRepository::class
        ],
        'basketRepository' => [
            'class' => BasketRepository::class
        ],
        'userRepository' => [
            'class' => UserRepository::class
        ],
        'ordersRepository' => [
            'class' => OrdersRepository::class
        ],
        'statusRepository' => [
            'class' => StatusRepository::class
        ],
    ]

];