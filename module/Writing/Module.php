<?php

namespace Writing;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

    /**
     * The ModuleManager will call getAutoloaderConfig() and getConfig() automatically for us.
     * This method returns an array that is compatible with ZF2’s AutoloaderFactory.
     * If you are using Composer, you could instead just create an empty getAutoloaderConfig() { } and your module 
     * to composer.json
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * This method simply loads the config/module.config.php file.
     * To help keep our project organized, we’re going to put our array configuration in a separate file
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }


}
