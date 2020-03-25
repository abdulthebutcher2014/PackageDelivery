<?php

class location_db {
    public static function addLocation($city, $state, $distance) {
        $db = Database::getDB();
        $query = 'INSERT INTO Locations(City, State, Distance)'
                . ' VALUES (:city, :state, :distance)';
        $statement = $db->prepare($query);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);
        $statement->bindValue(':distance', $distance);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function getLocations() {
        $db = Database::getDB();
        $query = 'SELECT * from locations ORDER BY city ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        foreach ($rows as $row) {
            $l = new Location($row['City'], $row['State'], $row['Distance']);
            $l->setID($row['ID']);
            $locations[] = $l; 
        }
        
        return $locations;
    }
    public static function getLocation($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM locations
              WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $l = new Location($row['City'], $row['State'], $row['Distance']);
            $l->setID($row['ID']);
            $location = $l;
        }
        return $location;
    }
    public static function update_location($id, $city, $state, $distance) {
        $db = Database::getDB();
        $query = 'UPDATE locations SET City=:city, State=:state, Distance=:distance WHERE ID=:id';
        $statement = $db->prepare($query);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);      
        $statement->bindValue(':distance', $distance);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
        public static function deleteLocation($id) {
        $db = Database::getDB();
        $query = 'DELETE FROM locations WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
}
