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
        //Return the delivery id.
        $delivery_id = $db->lastInsertId();
        return $delivery_id;
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

    public static function getOutGoingDeliveries($userid) {
        $db = Database::getDB();
        $query = 'SELECT deliveries.ID as DeliveryID, users.Name, locations.City,'
                . ' locations.State, packages.ID as PackageID, packages.status FROM `deliveries`'
                . ' join users on users.id=deliveries.toUser join '
                . 'locations on deliveries.ToLocation = locations.ID '
                . 'join packages on deliveries.package=packages.id '
                . 'where deliveries.fromUser=:userid';

        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);

        $statement->execute();
        $rows = $statement->fetchAll();

        $statement->closeCursor();
        foreach ($rows as $row) {
            $d = new Delivery_display($row['DeliveryID'], $row['Name'], $row['City'], $row['State'], $row['PackageID'], $row['status']);
            $delivery[] = $d;
        }
        if(!isset($delivery[0])){
            $delivery=new Delivery_display("", "", "", "", "", "");
            return $delivery;
        }
        return $delivery;
    }

    public static function getIncomingDeliveries($userid) {
        $db = Database::getDB();
        $query = 'SELECT deliveries.ID as DeliveryID, users.Name, locations.City,'
                . ' locations.State, packages.ID as packageID, packages.status FROM `deliveries`'
                . ' join users on users.id=deliveries.fromUser join '
                . 'locations on deliveries.FromLocation = locations.ID '
                . 'join packages on deliveries.package=packages.id '
                . 'where deliveries.toUser=:userid';
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $d = new Delivery_display($row['DeliveryID'], $row['Name'], $row['City'], $row['State'], $row['packageID'], $row['status']);
            $delivery[] = $d;
        }
        if (!isset($delivery[0])) {
            $delivery = new Delivery_display("", "", "", "", "", "");
            return $delivery;
        }
        return $delivery;
    }

    public static function getAllDeliveries() {
        $db = Database::getDB();
        $query = 'SELECT deliveries.ID as DeliveryID, users.Name, locations.City,'
                . ' locations.State, packages.ID as packageID, packages.status FROM `deliveries`'
                . ' join users on users.id=deliveries.fromUser join '
                . 'locations on deliveries.FromLocation = locations.ID '
                . 'join packages on deliveries.package=packages.id ';
        $statement = $db->prepare($query);

        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $d = new Delivery_display($row['DeliveryID'], $row['Name'], $row['City'], $row['State'], $row['packageID'], $row['status']);
            $delivery[] = $d;
        }
        if (!isset($delivery[0])) {
            $delivery = new Delivery_display("", "", "", "", "", "");
            return $delivery;
        }
        return $delivery;
    }

}
