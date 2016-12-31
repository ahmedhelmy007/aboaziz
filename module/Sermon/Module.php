<?php

namespace Sermon;

use Sermon\Model\Category;
use Sermon\Model\CategoryTable;
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
    
    /**
     * In order to always use the same instance of our CategoryTable, we will use the ServiceManager to define how to 
     * create one. This is most easily done in the Module class.
     * getServiceConfig() is automatically called by the ModuleManager and applied to the ServiceManager.
     * 
     * https://framework.zend.com/manual/2.4/en/user-guide/database-and-models.html
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Sermon\Model\CategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('az_categories', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }


}
