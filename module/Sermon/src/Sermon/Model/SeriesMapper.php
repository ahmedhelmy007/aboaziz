<?php

namespace Sermon\Model;

use Zend\Db\Adapter\Adapter;
use Sermon\Model\SeriesEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class SeriesMapper {

    protected $tableName = 'az_series';
    protected $dbAdapter;
    protected $sql;

    /**
     */
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    /**
     */
    public function fetchAll() {
        $select = $this->sql->select();
        $select->order(array('status ASC', 'created_at ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        //The $results object can be iterated over, but will return an array for each row retrieved but we want 
        //a `SeriesEntity` object. To get this, we create a HydratingResultSet which requires a hydrator and an entity 
        //prototype to work.
        $entityPrototype = new SeriesEntity();
        //we use the ClassMethods hydrator which expects a getter and a setter method for each column in the resultset
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        //The HydratingResultSet uses the prototype design pattern when creating the entities when iterating. This 
        //means that instead of instantiating a new instance of the entity class on each iteration, it clones the 
        //provided instantiated object
        $resultset->initialize($results);
        return $resultset;
    }

    /**
     */
    public function saveSeries(SeriesEntity $series) {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($series);

        if ($series->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $series->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if (!$series->getId()) {
            $series->setId($result->getGeneratedValue());
        }
        return $result;
    }

    /**
     */
    public function getSeries($id) {
        $select = $this->sql->select();
        $select->where(array('id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }

        $hydrator = new ClassMethods();
        $series = new SeriesEntity();
        $hydrator->hydrate($result, $series);

        return $series;
    }

    /**
     */
    public function deleteSeires($id) {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));

        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }

}
