<?php

// Filename: /module/Content/src/Sermon/Controller/SermonController.php

namespace Sermon\Controller;

use Sermon\Service\SermonServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;

class SermonController extends AbstractActionController {

    /**
     * @var \Sermon\Service\SermonServiceInterface
     */
    protected $sermonService;

    /**
     * @var
     */
    protected $sermonForm;

    public function __construct(SermonServiceInterface $sermonService, FormInterface $sermonForm) {
        $this->sermonService = $sermonService;
        $this->sermonForm = $sermonForm;
    }

    /**
     * 
     */
    public function indexAction() {
        return new ViewModel(array(
            'sermons' => $this->sermonService->findAllSermons()
        ));
        //we can return an array too
    }

    public function detailAction() {
        $id = $this->params()->fromRoute('id');
        try {
            $sermon = $this->sermonService->findSermon($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('sermon');
        }
        return new ViewModel(array('sermon' => $sermon));
    }

    public function addAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->sermonForm->setData($request->getPost());

            if ($this->sermonForm->isValid()) {
                try {
                    //\Zend\Debug\Debug::dump($this->sermonForm->getData());die(); //This is to dump data
                    $this->sermonService->saveSermon($this->sermonForm->getData());
                    return $this->redirect()->toRoute('sermon');
                } catch (\Exception $e) {
                    // Some DB Error happened, log it and let the user know
                }
            }
        }
        return new ViewModel(array(
            'form' => $this->sermonForm
        ));
    }

    /**
     * 
     */
    public function editAction() {
        $request = $this->getRequest();
        $sermon = $this->sermonService->findSermon($this->params('id'));

        $this->sermonForm->bind($sermon);

        if ($request->isPost()) {
            $this->sermonForm->setData($request->getPost());

            if ($this->sermonForm->isValid()) {
                try {
                    $this->sermonService->saveSermon($sermon);

                    return $this->redirect()->toRoute('sermon');
                } catch (\Exception $e) {
                    die($e->getMessage());
                    // Some DB Error happened, log it and let the user know
                }
            }
        }

        return new ViewModel(array(
            'form' => $this->sermonForm
        ));
    }

    /**
     * 
     */
    public function deleteAction() {
        try {
            $sermon = $this->sermonService->findSermon($this->params('id'));
        } catch (\InvalidArgumentException $e) {
            return $this->redirect()->toRoute('sermon');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            //check if a certain post parameter called delete_confirmation is present
            $del = $request->getPost('delete_confirmation', 'no');

            if ($del === 'yes') {
                $this->sermonService->deleteSermon($sermon);
            }

            return $this->redirect()->toRoute('sermon');
        }

        return new ViewModel(array(
            'sermon' => $sermon
        ));
    }

}
