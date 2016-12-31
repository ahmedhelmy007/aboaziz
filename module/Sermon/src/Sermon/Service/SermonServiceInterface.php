<?php

// Filename: /module/Sermon/src/Sermon/Service/SermonServiceInterface.php

namespace Sermon\Service;

use Sermon\Model\SermonInterface;

interface SermonServiceInterface {

    /**
     * Should return a set of all sermons that we can iterate over. Single entries of the array are supposed to be
     * implementing \Sermon\Model\SermonInterface
     *
     * @return array|SermonInterface[]
     */
    public function findAllSermons();

    /**
     * Should return a single sermon
     *
     * @param  int $id Identifier of the Sermon that should be returned
     * @return SermonInterface
     */
    public function findSermon($id);

    /**
     * Should save a given implementation of the SermonInterface and return it. If it is an existing Sermon the Sermon
     * should be updated, if it's a new Sermon it should be created.
     *
     * @param  SermonInterface $sermon
     * @return SermonInterface
     */
    public function saveSermon(SermonInterface $sermon);
    
    
    /**
     * Should delete a given implementation of the SermonInterface and return true if the deletion has been
     * successful or false if not.
     *
     * @param  SermonInterface $sermon
     * @return bool
     */
    public function deleteSermon(SermonInterface $sermon);

}
