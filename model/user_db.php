<?php

Class UserDB {

    public static function addUser($name, $logonid, $password, $isAdminstrator, $email) {
        $db = Database::getDB();
        $query = 'INSERT INTO users(Name, LogonID, Password, isAdministrator, Email)'
                . ' VALUES (:name, :login_id, :password, :isAdministrator, :email)';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':login_id', $logonid);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':isAdministrator', $isAdminstrator);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function getUsers() {
        $db = Database::getDB();
        $query = 'SELECT * from users ORDER BY name ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $u = new User($row['Name'], $row['LogonID'], $row['Password'], $row['isAdministrator'], $row['Email']);
            $u->setID($row['ID']);
            $users[] = $u; 
        }
        return $users;
    }

    public static function getUser($logonid) {
        $db = Database::getDB();
        $query = 'SELECT * FROM users
              WHERE LogonID = :logonid';
        $statement = $db->prepare($query);
        $statement->bindValue(':logonid', $logonid);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $u = new User($row['Name'], $row['LogonID'], $row['Password'], $row['isAdministrator'], $row['Email']);
            $u->setId($row['ID']);
            $user = $u;
        }
        return $user;
    }
     public static function getUserByID($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM users
              WHERE ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        foreach ($rows as $row) {
            $u = new User($row['Name'], $row['LogonID'], $row['Password'], $row['isAdministrator'], $row['Email']);
            $u->setId($row['ID']);
            $user = $u;
        }
        return $user;
    }

    public static function uniqueUsername($logonid) {
        $db = Database::getDB();
        $query = 'SELECT LogonID FROM users
              WHERE LogonID = :logonid';
        $statement = $db->prepare($query);
        $statement->bindValue(':logonid', $logonid);
        $statement->execute();
        $id = $statement->fetchAll();
        $statement->closeCursor();
        if (empty($id)) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_valid_user_login($userid, $password) {
        $db = Database::getDB();
        $query = 'SELECT Password FROM users
              WHERE LogonID = :userid';
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        $hash = $result['Password'];
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    public static function update_user($name, $logonid, $password, $isAdminstrator, $email) {
        $db = Database::getDB();
        $query = 'UPDATE users SET Name=:name, Password=:password, isAdministrator=:isAdministrator, Email=:email WHERE LogonID=:login_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':login_id', $logonid);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':isAdministrator', $isAdminstrator);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteUser($id) {
        $db = Database::getDB();
        $query = 'DELETE FROM users WHERE LogonID = :user_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $id);
        $statement->execute();
        $statement->closeCursor();
    }

}
