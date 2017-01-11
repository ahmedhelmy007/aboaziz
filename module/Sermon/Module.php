<?php

namespace Sermon;

use Sermon\Model\Category;
use Sermon\Model\CategoryTable;
use Sermon\Model\SeriesMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Module class contains methods that are called during the start-up process and is also used to register listeners 
 * that will be triggered during the dispatch process
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

    /**
     * The ModuleManager will call getAutoloaderConfig() and getConfig() automatically for us.
     * This method returns an array that is compatible with ZF2’s AutoloaderFactory.
     * If you are using Composer, you could instead just create an empty getAutoloaderConfig() { } and your module 
     * to composer.json
     * It is configured for us with both a classmap file (autoload_classmap.php) and a standard autoloader to load 
     * any files in src/__NAMESPACE__ according to the PSR-0 rules .
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
     * is called by the Module Manager to retrieve the configuration information for this module.
     * By tradition, this method simply loads the config/module.config.php file which is an associative array
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * In order to always use the same instance of our CategoryTable, we will use the ServiceManager to define how to 
     * create one. This is most easily done in the Module class.
     * getServiceConfig() is automatically called by the ModuleManager and applied to the ServiceManager.
     * https://framework.zend.com/manual/2.4/en/user-guide/database-and-models.html
     * 
     * Service Manager can be used as a Dependency Injection Container in addition to a Service Locator.
     */
    public function getServiceConfig()
    {
        //returning an array of class creation definitions that are all merged together by the Module Manager before 
        //passing to the Service Manager
        return array(
            'factories' => array(
                //To create a service within the Service Manager we use a unique key name. As this has to be unique, 
                //it’s common (but not a requirement) to use the fully qualified class name as the Service Manager key 
                //name. We then define a closure that the Service Manager will call when it is asked for an instance of
                // the given key name. We can do anything we like in this closure, as long as we return an instance of
                // the required class
                'Sermon\Model\CategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                //We have requested an instance of Zend\Db\Adapter\Adapter from the Service Manager, which we've 
                //configured so that it knows from module.comfig.php how to instantiate a Zend\Db\Adapter\Adapter. This
                // is done using a class provided by Zend Framework called Zend\Db\Adapter\AdapterServiceFactory which 
                // we can configure within the merged configuration system.
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('az_categories', $dbAdapter, null, $resultSetPrototype);
                },
                //In the following, we will inject the database adapter into the mapper. This means that Service 
                //Manager can be used as a Dependency Injection Container in addition to a Service Locator.
                'SeriesMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new SeriesMapper($dbAdapter);
                    return $mapper;
                }
            ),
        );
        //This is an example of the Dependency Injection pattern at work as we have injected the database adapter into 
        //the mapper. This also means that Service Manager can be used as a Dependency Injection Container in addition 
        //to a Service Locator.
    }
    
    //The onBootstrap() method in the Module class is the easiest place to register listeners for the MVC events that 
    //are triggered by the Event Manager.


}
