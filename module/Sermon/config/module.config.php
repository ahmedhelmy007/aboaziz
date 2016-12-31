<?php

// Filename: /module/Sermon/config/module.config.php
//these configs are inclueded by the Module.php getConfig() method.
//The config information is passed to the relevant components by the ServiceManager.
// We need two initial sections: controllers and view_manager. The controllers section provides a list of all 
// the controllers provided by the module.

return array(
    //In controllers section we are telling our module where to find controllers that 
    //the routes under routes configuration key are referring to
    'controllers' => array(
        'invokables' => array(
            'Sermon\Controller\CategoryList' => 'Sermon\Controller\CategoryController',
        ),
        'factories' => array(
            'Sermon\Controller\SermonList' => 'Sermon\Factory\SermonControllerFactory'
        ),
    ),
    'service_manager' => array(
        /* 'invokables' => array(
          // Service that listens to the name Sermon\Service\SermonServiceInterface and points to our own implementation which is Sermon\Service\SermonService
          'Sermon\Service\SermonServiceInterface' => 'Sermon\Service\SermonService'
          ) */
        'factories' => array(
            'Sermon\Service\SermonServiceInterface' => 'Sermon\Factory\SermonServiceFactory',
            // Calling the following Service will always give back a running instance of the 
            // Zend\Db\Adapter\AdapterInterface depending on what driver we assign
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Sermon\Mapper\SermonMapperInterface' => 'Sermon\Factory\ZendDbSqlMapperFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'about-shekh' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/about-shekh',
                    'defaults' => array(
                        'controller' => 'PagesController',
                        'action' => 'about-shekh',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/categories[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sermon\Controller\CategoryList',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true, // Defines that "/categories" can be matched on its own without a child route being matched
                'child_routes' => array(
                    'archive' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/archive[/:year]',
                            'defaults' => array(
                                'action'     => 'archive',
                            ),
                            'constraints' => array(
                                'year' => '\d{4}'
                            )
                        ),
                    ),
                    'single' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/:id',
                            'defaults' => array(
                                'action'     => 'detail',
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        ),
                    ),
                )
            ),
            'sermon' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/sermons',
                    'defaults' => array(
                        'controller' => 'Sermon\Controller\SermonList',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'single' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/:id',
                            'defaults' => array(
                                'action'     => 'detail',
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        ),
                    ),
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'action'     => 'add',
                            )
                        ),
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'action'     => 'edit',
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        ),
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'defaults' => array(
                                'action'     => 'delete',
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        ),
                    ),
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../view',
        ),
    ),
        /* 'db' => array(
          'driver'         => 'Pdo',
          .....
          ) */
);
