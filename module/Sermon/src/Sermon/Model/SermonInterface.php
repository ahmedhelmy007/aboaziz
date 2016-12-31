<?php

// Filename: /module/Sermon/src/Sermon/Model/SermonInterface.php

namespace Sermon\Model;

interface SermonInterface {

    /**
     * Will return the ID of the sermon
     *
     * @return int
     */
    public function getId();

    /**
     * Will return the TITLE of the sermon
     *
     * @return string
     */
    public function getTitle();

    /**
     * Will return the Description of the sermon
     *
     * @return string
     */
    public function getDescription();

    /**
     * Will return the Category of the sermon
     *
     * @return int
     */
    public function getCategory_id();
}
