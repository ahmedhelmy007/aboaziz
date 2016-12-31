<?php

// Filename: /module/Content/src/Sermon/Factory/SermonControllerFactory.php

namespace Sermon\Factory;

use Sermon\Controller\SermonController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SermonControllerFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $sermonService = $realServiceLocator->get('Sermon\Service\SermonServiceInterface');
        //All forms should be accessed through the FormElementManager. FormElementManager automatically knows about 
        //forms that act as invokables
        $sermonInsertForm     = $realServiceLocator->get('FormElementManager')->get('Sermon\Form\SermonForm');
         
        return new SermonController($sermonService, $sermonInsertForm);
    }

}
