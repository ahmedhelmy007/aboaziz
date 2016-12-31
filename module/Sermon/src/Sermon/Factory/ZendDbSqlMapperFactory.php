<?php

// Filename: /module/Content/src/Sermon/Factory/ZendDbSqlMapperFactory.php

namespace Sermon\Factory;

use Sermon\Mapper\ZendDbSqlMapper;
use Sermon\Model\Sermon;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
 
class ZendDbSqlMapperFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        //if you tried to get an object using the key: Zend\Db\Adapter\AdapterServiceFactory this will fail
        return new ZendDbSqlMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(false),
            new Sermon()
        );
    }

}
