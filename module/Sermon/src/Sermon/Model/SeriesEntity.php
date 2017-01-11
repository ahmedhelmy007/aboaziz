<?php

namespace Sermon\Model;

class SeriesEntity {

    protected $id;
    protected $title;
    protected $description;
    protected $status = 0;
    protected $created_at;

    public function __construct() {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($value) {
        $this->title = $value;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        $this->description = $value;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($value) {
        $this->status = $value;
    }

    public function getCreated_at() {
        return $this->created_at;
    }

    public function setCreated_at($value) {
        $this->created_at = $value;
    }

}
