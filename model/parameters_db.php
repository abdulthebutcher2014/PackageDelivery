<?php

class ParametersDB {

    public static function setInitialDeliveryPrice($price) {
        $db = Database::getDB();
        $query = 'UPDATE parameters SET value=:value WHERE Property = :baseprice';
        $statement = $db->prepare($query);
        $statement->bindValue(':value', $price);
        $statement->bindValue(':baseprice', "baseprice");
        $statement->execute();
        $statement->closeCursor();
    }

    public static function setRatePerMile($rate) {
        $db = Database::getDB();
        $query = 'UPDATE parameters SET value=:value WHERE Property = :rate';
        $statement = $db->prepare($query);
        $statement->bindValue(':value', $rate);
        $statement->bindValue(':rate', "rate");
        $statement->execute();
        $statement->closeCursor();
    }

 
    public static function getInitialDeliveryPrice() {
        $db = Database::getDB();
        $query = 'SELECT * FROM parameters WHERE Property = :baseprice';
        $statement = $db->prepare($query);
        $arg = 'baseprice';
        $statement->bindValue(':baseprice', $arg);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $p = new Parameter($row['Property'], $row['value']);
            $p->setId($row['ID']);
            $baseprice = $p->getVal();
        }
        return $baseprice;
    }

    public static function getRatePerMile() {
        $db = Database::getDB();
        $query = 'SELECT * FROM parameters WHERE Property = :rate';
        $statement = $db->prepare($query);
        $arg = 'rate';
        $statement->bindValue(':rate', $arg);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $p = new Parameter($row['Property'], $row['value']);
            $p->setId($row['ID']);
            $rate = $p->getVal();
        }
        return $rate;
    }

}
