<?php
// Filename: /module/Sermon/src/Sermon/Model/Sermon.php

namespace Sermon\Model;

class Sermon implements SermonInterface {

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $category_id;

    /**
     * 
     */
    public function __construct()
    {
//        $this->created = date('Y-m-d H:i:s');
    }
    
    /**
     * {@inheritDoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function getCategory_id() {
        return $this->category_id;
    }

    /**
     * @param int $category
     */
    public function setCategory_id($category) {
        $this->category_id = $category;
    }

}
