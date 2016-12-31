<?php

// Filename: /module/Sermon/src/Sermon/Mapper/ZendDbSqlMapper.php

namespace Sermon\Mapper;

use Sermon\Model\SermonInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements SermonMapperInterface {

    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @var \Sermon\Model\SermonInterface
     */
    protected $sermonPrototype;

    /**
     * @param AdapterInterface  $dbAdapter
     * @param HydratorInterface $hydrator
     * @param SermonInterface    $sermonPrototype
     */
    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, SermonInterface $sermonPrototype) {

        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->sermonPrototype = $sermonPrototype;
    }

    /**
     * @param int|string $id
     *
     * @return SermonInterface
     * @throws \InvalidArgumentException
     */
    public function find($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('az_sermons');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->sermonPrototype);
        }

        throw new \InvalidArgumentException("Sermon with given ID:{$id} not found.");
    }

    /**
     * @return array|SermonInterface[]
     */
    public function findAll() {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('az_sermons');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
//        \Zend\Debug\Debug::dump($result);die();
        //Our Mapper has now a really good architecture and no more hidden dependencies.
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->sermonPrototype);
            return $resultSet->initialize($result);
        }

        //FOR DEBUGGING uncomment ResultSet object. A very interesting property in ResultSet object is 
        //["returnType":protected] => string(11) "arrayobject". This tells us
        // that all database entries will be returned as an ArrayObject. And this is a little problem as the 
        // SermonMapperInterface requires us to return an array of SermonInterface objects. Luckily there is a very simple 
        //option for us available to make this happen. In the examples above we have used the default ResultSet object.
        // $resultSet = new ResultSet();
        // \Zend\Debug\Debug::dump($resultSet->initialize($result));die();

        die("no data");
    }

    /**
     * @param SermonInterface $sermonObject
     *
     * @return SermonInterface
     * @throws \Exception
     */
    public function save(SermonInterface $sermonObject) {
        $sermonData = $this->hydrator->extract($sermonObject);
        unset($sermonData['id']); // Neither Insert nor Update needs the ID in the array
        if ($sermonObject->getId()) {
            // ID present, it's an Update
            $action = new Update('az_sermons');
            $action->set($sermonData);
            $action->where(array('id = ?' => $sermonObject->getId()));
        } else {
            // ID NOT present, it's an Insert
            $action = new Insert('az_sermons');
            $action->values($sermonData);
        }

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

//        die('Query:<br>'.$stmt->getSql());
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $sermonObject->setId($newId);
            }

            return $sermonObject;
        }

        throw new \Exception("Database error");
        die("Database error");
    }

    /**
     * i didn't add a declaration of this method in SermonMapperInterface interface to check if is that required!
     * ################################ {@inheritDoc} 
     */
    public function delete(SermonInterface $sermonObject) {
        $action = new Delete('az_sermons');
        $action->where(array('id = ?' => $sermonObject->getId()));

        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool) $result->getAffectedRows();
    }

}
