<?php

namespace Sermon\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sermon\Model\Category;
use Sermon\Form\CategoryForm;

/**
 * controller must implement ZendStdlibDispatchableInterface in order to be ‘dispatched’ (or run) by 
 * ZendFramework’s MVC layer
 */

class CategoryController extends AbstractActionController {

    protected $categoryTable;

    public function indexAction() {
        return new ViewModel(array(
            'categories' => $this->getCategoryTable()->fetchAll(),
        ));
    }

    /**
     * 
     */
    public function addAction() {
        $form = new CategoryForm();
        $form->get('submit')->setValue('Add'); //set the label on the submit button to “Add” as we will re-use the form when editing
        //If the Request object’s isPost() method is true, We then set the posted data to the form
        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = new Category();
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //If the form is valid, then we grab the data from the form and store to the model using saveCategory()
                $category->exchangeArray($form->getData());
                $this->getCategoryTable()->saveCategory($category);

                // Redirect to list of categories
                return $this->redirect()->toRoute('category');
            }
        }
        //Finally, we return the variables that we want assigned to the view. In this case, just the form object
        return array('form' => $form);
    }

    /**
     * 
     */
    public function editAction() {
        //params is a controller plugin that provides a convenient way to retrieve parameters from the matched route.
        //We use it to retrieve the id from the route we created in the modules’ module.config.php
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category', array(
                        'action' => 'add'
            ));
        }

        // Get the category with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $category = $this->getCategoryTable()->getCategory($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('category', array(
                        'action' => 'index'
            ));
        }

        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //As a result of using bind() with its hydrator, we do not need to populate the form’s data back into 
                //the $album as that’s already been done, so we can just call the mappers’ saveCategory()
                $this->getCategoryTable()->saveCategory($category);

                // Redirect to list of categories
                return $this->redirect()->toRoute('category');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id' => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }

    /**
     * 
     */
    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Sermon\Model\CategoryTable');
        }
        return $this->categoryTable;
    }

}
