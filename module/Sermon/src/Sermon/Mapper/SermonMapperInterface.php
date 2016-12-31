<?php

// Filename: /module/Sermon/src/Sermon/Mapper/SermonMapperInterface.php

namespace Sermon\Mapper;

use Sermon\Model\SermonInterface;

interface SermonMapperInterface {

    /**
     * @param int|string $id
     * @return SermonInterface
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     * @return array|SermonInterface[]
     */
    public function findAll();

    /**
     * @param SermonInterface $sermonObject
     *
     * @param SermonInterface $sermonObject
     * @return SermonInterface
     * @throws \Exception
     */
    public function save(SermonInterface $sermonObject);
}
