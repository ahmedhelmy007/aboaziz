<?php


return array(
    'controllers' => array(
        'invokables' => array(
            'BookController' => 'Writing\Controller\BookController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'aboutshekh' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/aboutshekh',
                    'defaults' => array(
                        'controller' => 'BookController',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'book' => __DIR__ . '/../view',
        ),
    ),
        /* 'db' => array(
          'driver'         => 'Pdo',
          .....
          ) */
);
