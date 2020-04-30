<?php

class package_db {

    public static function addPackage($status) {
        $db = Database::getDB();
        $query = 'INSERT INTO packages(status)'
                . ' VALUES (:status)';
        $statement = $db->prepare($query);
        $statement->bindValue(':status', $status);
        $statement->execute();
        $statement->closeCursor();
        $package_id = $db->lastInsertId();
        return $package_id;
    }

    public static function updatePackage($id, $status) {
        $db = Database::getDB();
        $query = 'UPDATE packages SET status=:status where ID=:id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':status', $status);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getPackages() {
        $db = Database::getDB();
        $query = 'SELECT * from packages ORDER BY name ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $p = new Package($row['status']);
            $p->setID($row['ID']);
            $packages[] = $p;
        }
        return $packages;
    }

    public static function getPackage($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM packages
              WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $p = new Location($row['status']);
            $p->setId($row['ID']);
            $package = $p;
        }
        return $package;
    }

    public static function getDeliveryID_By_packageID($package_id) {
        $db = Database::getDB();
        $query = 'SELECT ID FROM deliveries WHERE package = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $package_id);
        $statement->execute();
        $delivery_id = $statement->fetch();
        $statement->closeCursor();
        return $delivery_id[0];
    }

}
