<?php

Class UserDB{
    public static function addUser($name, $logonid, $password, $isAdminstrator){
        $db = Database::getDB();
        $query = 'INSERT INTO users(Name, LogonID, Password, isAdministrator)'
                . ' VALUES (:name, :login_id, :password, :isAdministrator)';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':login_id', $logonid);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':isAdministrator', $isAdminstrator);
        $statement->execute();
        $statement->closeCursor(); 
    }
    public static function getUsers(){
        $db = Database::getDB();
        $query = 'SELECT * from users ORDER BY name ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $u = new User($row['Name'], $row['LogonID'], $row['Password'], $row['isAdministrator']);
            $u->setID($row['ID']);
            $users[] = $u;
        }
        return $users;
    }
    public static function getUser($logonid){
        $db = Database::getDB();
        $query = 'SELECT * FROM users
              WHERE LogonID = :logonid';
        $statement = $db->prepare($query);
        $statement->bindValue(':logonid', $logonid);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $u = new User($row['Name'], $row['LogonID'], $row['Password'], $row['isAdministrator']);
            $u->setId($row['ID']);
            $user[] = $u;
        }
        return $user;
    }
    public static function uniqueUsername($logonid) {
        $db = Database::getDB();
        $query = 'SELECT LogonID FROM users
              WHERE logonid = :logonid';
        $statement = $db->prepare($query);
        $statement->bindValue(':logonid', $logonid);
        $statement->execute();
        $id = $statement->fetchAll();
        $statement->closeCursor();
        if(empty($id)) {
            return true;
        } else {
            return false;
        }
    }
    
}

