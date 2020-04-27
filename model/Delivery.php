<?php

class Delivery {
    private $id, $fromLocation, $toLocation, $total, $package, $toUser, $fromUser;
    function __construct($fromLocation, $toLocation, $total, $package, $toUser, $fromUser) {
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->total = $total;
        $this->package = $package;
        $this->toUser = $toUser;
        $this->fromUser = $fromUser;
    }
    function getId() {
        return $this->id;
    }

    function getFromLocation() {
        return $this->fromLocation;
    }

    function getToLocation() {
        return $this->toLocation;
    }

    function getTotal() {
        return $this->total;
    }

    function getPackage() {
        return $this->package;
    }

    function getToUser() {
        return $this->toUser;
    }

    function getFromUser() {
        return $this->fromUser;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFromLocation($fromLocation) {
        $this->fromLocation = $fromLocation;
    }

    function setToLocation($toLocation) {
        $this->toLocation = $toLocation;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setPackage($package) {
        $this->package = $package;
    }

    function setToUser($toUser) {
        $this->toUser = $toUser;
    }

    function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }
    function getTotalDisplay(){
        return number_format($this->getTotal(),2,'.');
    }



}
