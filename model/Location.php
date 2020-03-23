<?php

class Location {
    private $id, $city, $state, $distance;
    function __construct($city, $state, $distance) {
        $this->city = $city;
        $this->state = $state;
        $this->distance = $distance;
    }
    function getId() {
        return $this->id;
    }

    function getCity() {
        return $this->city;
    }

    function getState() {
        return $this->state;
    }

    function getDistance() {
        return $this->distance;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setDistance($distance) {
        $this->distance = $distance;
    }



}
