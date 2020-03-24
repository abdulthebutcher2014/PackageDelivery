<?php

class Package {
    private $id, $status;
    function __construct($status) {
        $this->status = $status;
    }
    function getId() {
        return $this->id;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setStatus($status) {
        $this->status = $status;
    }



}
