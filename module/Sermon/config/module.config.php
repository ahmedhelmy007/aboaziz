<?php

// Filename: /module/Sermon/config/module.config.php
//these configs are inclueded by the Module.php getConfig() method.
//The config information is passed to the relevant components by the ServiceManager.
// We need two initial sections: controllers and view_manager. The controllers section provides a list of all 
// the controllers provided by the module.
//In practice, the Module Manager requires that the returned value from getConfig() be a Traversable

return array(
    //The controllers sub-array (configuration key) is used to register this module’s controller classes with the 
    //Controller Service Manager which is used by the dispatcher to instantiate a controller.
    'controllers' => array(
        'invokables' => array(
            'Sermon\Controller\CategoryList' => 'Sermon\Controller\CategoryController',
            'Sermon\Controller\Series' => 'Sermon\Controller\SeriesController',
        ),
        'factories' => array(
            'Sermon\Controller\SermonList' => 'Sermon\Factory\SermonControllerFactory'
        ),
    ),
    //This array works exactly the same as the one in getServiceConfig(), except that you should not use closures in a 
    //config file as if you do Module Manager will not be able to cache the merged configuration information
    'service_manager' => array(
        /* 'invokables' => array(
          // Service that listens to the name Sermon\Service\SermonServiceInterface and points to our own 
          //implementation which is Sermon\Service\SermonService
          'Sermon\Service\SermonServiceInterface' => 'Sermon\Service\SermonService'
          ) */
        'factories' => array(
            'Sermon\Service\SermonServiceInterface' => 'Sermon\Factory\SermonServiceFactory',
            //As we have requested an instance of Zend\Db\Adapter\Adapter from the Service Manager, we also need to 
            //configure the Service Manager so that it knows how to instantiate a Zend\Db\Adapter\Adapter. This is done
            // using a class provided by Zend Framework called Zend\Db\Adapter\AdapterServiceFactory.
            // Calling the following Service will always give back a running instance of the 
            //Zend\Db\Adapter\AdapterInterface depending on what driver we assign.
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
                        //'__NAMESPACE__' => 'Sermon\Controller',
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
            'series' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/series[/:action[/:id]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Sermon\Controller',
                        'controller'    => 'Series',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete)',
                        'id'     => '[0-9]+',
                    ),
                ),
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
