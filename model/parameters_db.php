<?php

class ParametersDB{
    public static function setInitialDeliveryPrice($price){
       $db = Database::getDB(); 
    }
    public static function setRatePerMile($rate){
        $db = Database::getDB();
    }
    public static function getInitialDeliveryPrice($price){
        $db = Database::getDB();
    }
    public static function getRatePerMile($rate){
        $db = Database::getDB();
    }
}

