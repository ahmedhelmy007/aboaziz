<?php

namespace Sermon\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sermon\Model\SeriesEntity;
use Sermon\Form\SeriesForm;

class SeriesController extends AbstractActionController {

    public function indexAction() {
        $mapper = $this->getSeriesMapper();
        return new ViewModel(array('seriesList' => $mapper->fetchAll()));
        //You can also return an array from a controller as Zend Framework will construct a ViewModel behind the 
        //scenes for you.
        //return $mapper->fetchAll();
    }

    /**
     */
    public function getSeriesMapper() {
        //this is how to call a service in ZF2
        $sm = $this->getServiceLocator();
        return $sm->get('SeriesMapper');
    }

    /**
     */
    public function addAction() {
        $form = new SeriesForm();
        $series = new SeriesEntity();
        $form->bind($series);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getSeriesMapper()->saveSeries($series);

                // Redirect to list of series
                return $this->redirect()->toRoute('series');
            }
        }

        return array('form' => $form);
    }

    /**
     */
    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('series', array('action' => 'add'));
        }
        $series = $this->getSeriesMapper()->getSeries($id);

        $form = new SeriesForm();
        $form->bind($series);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getSeriesMapper()->saveSeries($series);

                return $this->redirect()->toRoute('series');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    /**
     */
    public function deleteAction() {
        $id = $this->params('id');
        $series = $this->getSeriesMapper()->getSeries($id);
        if (!$series) {
            return $this->redirect()->toRoute('series');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost()->get('del') == 'Yes') {
                $this->getSeriesMapper()->deleteSeries($id);
            }

            return $this->redirect()->toRoute('series');
        }

        return array(
            'id' => $id,
            'task' => $series
        );
    }

}
