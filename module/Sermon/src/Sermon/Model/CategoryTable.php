<?php

namespace Sermon\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false) {
        /* couple of lines does the job:
        $resultSet = $this->tableGateway->select();
        return $resultSet; */
        
        if ($paginated) {
            // create a new Select object for the table category
            $select = new Select('az_categories');
            // create a new result set based on the Category entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Category());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                    // our configured select object
                    $select,
                    // the adapter to run it against
                    $this->tableGateway->getAdapter(),
                    // the result set to hydrate
                    $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
         $resultSet = $this->tableGateway->select();
         return $resultSet;
    }

    public function getCategory($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCategory(Category $category) {
        $data = array(
            'description' => $category->description,
            'title' => $category->title,
        );

        $id = (int) $category->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategory($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Category id does not exist');
            }
        }
    }

    public function deleteCategory($id) {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}
