<?php

require_once 'model/User.php';
require_once 'model/user_db.php';
require_once 'model/PackageDeliveryDB.php';

//check to see if there is an adminstrator if not add one with userid/password
// admin/admin. This will skip validation but give us an adminstrator we can 
// log- on with right away.

if (UserDB::uniqueUsername('admin')) {//We will need to create the user admin in the db
    UserDB::addUser('Adminstrator', 'admin', 'admin', 1);
}

session_set_cookie_params(3600);
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "";
}

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'login';
    }
}

switch ($action) {
    case 'login':
        $userid = filter_input(INPUT_POST, "userid");
        $password = filter_input(INPUT_POST, "password");
        $error_message = "";
        if ($userid === NULL || $password === NULL) {
            $error_message = "Log-in";
            include('view/logon.php');
        } else {
            if (UserDB::is_valid_user_login($userid, $password)) {
                $_SESSION['user'] = $userid;
                include('view/RequestDelivery.php');
            } else {
                $error_message = "Invalid Credentials";
                include('view/logon.php');
            }
        }
        die();
        break;
    case 'register':
        $errors = array("", "", "");
        if(!isset($name)){$name="";}
        if(!isset($logonid)){$logonid="";}
        if(!isset($password)){$password="";}
        include('view/Registration.php');
        break;
    case 'request':
        include ('view/RequestDelivery.php');
        break;
    case 'new_user':
        
        die();
        break;
}
    