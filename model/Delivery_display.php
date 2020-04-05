<?php

class Delivery_display {
    private $id, $name, $city, $state, $packageId,$status;
    function __construct($id, $name, $city, $state, $packageId, $status) {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->state = $state;
        $this->packageId = $packageId;
        $this->status = $status;
    }
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getCity() {
        return $this->city;
    }

    function getState() {
        return $this->state;
    }

    function getPackageId() {
        return $this->packageId;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setPackageId($packageId) {
        $this->packageId = $packageId;
    }

    function setStatus($status) {
        $this->status = $status;
    }



}
