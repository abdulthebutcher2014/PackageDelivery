<?php

class delivery_db {

    public static function addDelivery($from, $to, $total, $package, $toUser, $fromUser) {
        $db = Database::getDB();
        $query = 'INSERT INTO deliveries(FromLocation, ToLocation, Total, package, toUser, fromUser)'
                . ' VALUES (:from, :to, :total, :package, :touser, :fromuser)';
        $statement = $db->prepare($query);
        $statement->bindValue(':from', $from);
        $statement->bindValue(':to', $to);        
        $statement->bindValue(':total', $total);
        $statement->bindValue(':package', $package);
        $statement->bindValue(':touser', $toUser);
        $statement->bindValue(':fromuser', $fromUser);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function updateDelivery($status) {

    }

    public static function getDeliveries() {
        $db = Database::getDB();
        $query = 'SELECT * from deliveries ORDER BY ID ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $d = new Delivery($row['FromLocation'], $row['ToLocation'], $row['Total'], $row['package'], $row['toUser'], $row['fromUser']);
            $d->setID($row['ID']);
            $deliveries[] = $d; 
        }
        return $deliveries;
    }

    public static function getDelivery($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM deliveries
              WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $d = new Delivery($row['FromLocation'], $row['ToLocation'], $row['Total'], $row['package'], $row['toUser'], $row['fromUser']);
            $d->setId($row['ID']);
            $delivery = $d;
        }
        return $delivery;
    }

}
