<?php

class ParametersDB{
    public static function setInitialDeliveryPrice($price){
       $db = Database::getDB(); 
    }
    public static function setRatePerMile($rate){
        $db = Database::getDB();
    }
    public static function getInitialDeliveryPrice(){
        $db = Database::getDB();
        return 200;
    }
    public static function getRatePerMile(){
        $db = Database::getDB();
        return 100;
    }
}

