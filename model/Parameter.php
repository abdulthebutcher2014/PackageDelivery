<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Parameter {

    private $id, $parm, $val;

    function __construct($parm, $val) {
       
        $this->parm = $parm;
        $this->val = $val;
    }
    function getId() {
        return $this->id;
    }

    function getParm() {
        return $this->parm;
    }

    function getVal() {
        return $this->val;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setParm($parm) {
        $this->parm = $parm;
    }

    function setVal($val) {
        $this->val = $val;
    }
}
