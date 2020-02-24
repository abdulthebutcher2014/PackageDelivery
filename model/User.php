<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class User{
    private $id, $name, $logonid, $password, $isAdministrator;
    function __construct($name, $logonid, $password, $isAdministrator) {
        $this->name = $name;
        $this->logonid = $logonid;
        $this->password = $password;
        $this->isAdministrator = $isAdministrator;
    }
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getLogonid() {
        return $this->logonid;
    }

    function getPassword() {
        return $this->password;
    }

    function getIsAdministrator() {
        return $this->isAdministrator;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLogonid($logonid) {
        $this->logonid = $logonid;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setIsAdministrator($isAdministrator) {
        $this->isAdministrator = $isAdministrator;
    }


}
