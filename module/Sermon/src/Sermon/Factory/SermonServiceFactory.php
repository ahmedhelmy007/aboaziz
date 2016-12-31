<?php

// Filename: /module/Content/src/Sermon/Factory/SermonServiceFactory.php

namespace Sermon\Factory;

use Sermon\Service\SermonService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SermonServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SermonService(
            $serviceLocator->get('Sermon\Mapper\SermonMapperInterface')
        );
    }

}
