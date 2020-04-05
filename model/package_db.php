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

}
