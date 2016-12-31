<?php

// Filename: /module/Sermon/src/Sermon/Service/SermonService.php

namespace Sermon\Service;

use Sermon\Mapper\SermonMapperInterface;
use Sermon\Model\SermonInterface;

class SermonService implements SermonServiceInterface {

    /**
     * @var \Sermon\Mapper\SermonMapperInterface
     */
    protected $sermonMapper;

    /**
     * @param SermonMapperInterface $sermonMapper
     */
    public function __construct(SermonMapperInterface $sermonMapper) {
        $this->sermonMapper = $sermonMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function findAllSermons() {
        return $this->sermonMapper->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function findSermon($id) {
        return $this->sermonMapper->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function saveSermon(SermonInterface $sermon) {
        return $this->sermonMapper->save($sermon);
    }

    
    /**
     * {@inheritDoc}
     */
    public function deleteSermon(SermonInterface $sermon)
    {
        return $this->sermonMapper->delete($sermon);
    }

}
