<?php

namespace Writing\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * controller must implement ZendStdlibDispatchableInterface in order to be ‘dispatched’ (or run) by 
 * ZendFramework’s MVC layer
 */

class BookController extends AbstractActionController {

    protected $categoryTable;

    public function indexAction() {
        die('sssssssssss');
    }

}
