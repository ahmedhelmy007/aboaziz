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
        
        //Attempt to directly get an object using the key: Zend\Db\Adapter\AdapterServiceFactory will fail
        return new ZendDbSqlMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
             'az_sermons',
            new ClassMethods(false),
            new Sermon()
        );
    }

}
