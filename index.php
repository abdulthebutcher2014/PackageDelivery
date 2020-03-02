<?php

require_once 'model/User.php';
require_once 'model/user_db.php';
require_once 'model/PackageDeliveryDB.php';
require_once 'model/validation.php';

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
    case 'logout':
        unset($_SESSION['username']);
        session_destroy();
        header('Location:index.php');
        break;
    case 'login':
        $errors = array("", "", "");
        $userid = filter_input(INPUT_POST, "userid");
        $password = filter_input(INPUT_POST, "password");
        $error_message = "";
        $message = "";
        if ($userid === NULL || $password === NULL) {
            $error_message = "Log-in";
            include('view/logon.php');
        } else {
            if (UserDB::is_valid_user_login($userid, $password)) {
                $_SESSION['username'] = $userid;
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
        if (!isset($name)) {
            $name = "";
        }
        if (!isset($logonid)) {
            $logonid = "";
        }
        if (!isset($password)) {
            $password = "";
        }
        include('view/Registration.php');
        break;
    case 'request':
        $message = "";
        include ('view/RequestDelivery.php');
        break;
    case 'new_user':
        $errors = array("", "", "");
        $message = "";
        $name = filter_input(INPUT_POST, "name");
        $logonid = filter_input(INPUT_POST, 'logonid');
        $password = filter_input(INPUT_POST, "password");
        $errors[0] = validation::nameCheck($name, "Name");
        $errors[1] = validation::nameCheck($logonid, "Logon-id");
        $errors[2] = validation::passwordCheck($password, "Password");
        $count = 0;
        for ($i = 0; $i < count($errors); $i++) {
            if ($errors[$i] === "") {
                $count++;
            }
        }
        if ($count >= 3) {
            UserDB::addUser($name, $logonid, $password, 0);
            $message = $logonid . " has been registered";
            $_SESSION['username'] = $logonid; //you are now logged on. remember your password
            include('view/RequestDelivery.php');
        } else {
            $message = "There is an error - user wasn't added.";
            include ('view/Registration.php');
        }
        die();
        break;
    case 'update_user':
        //get a user object for the user
        $user = UserDB::getUser($_SESSION['username']);
        //var_dump($user);
        $message = "";
        $errors = array("", "", "");

        //$name="Phat Ho";
        $name = $user->getName();
        $logonid = $user->getLogonid();
        $password = $user->getPassword();
        if ($user->getIsAdministrator() === '1') {
            $users = UserDB::getUsers();
        }
        var_dump($users);
        include ('view/updateUser.php');
        die();
        break;
    case 'update_user2':
        $name = filter_input(INPUT_POST, "name");
        $logonid = filter_input(INPUT_POST, 'logonid');
        $password = filter_input(INPUT_POST, "password");
        $errors[0] = validation::nameCheck($name, "Name");
        $errors[1] = validation::nameCheck($logonid, "Logon-id");
        $errors[2] = validation::passwordCheck($password, "Password");
        $count = 0;
        for ($i = 0; $i < count($errors); $i++) {
            if ($errors[$i] === "") {
                $count++;
            }
        }
        if ($count >= 3) {
            UserDB::update_user($name, $logonid, $password, 1);
            $message = $logonid . " has been updated";
            include('view/RequestDelivery.php');
        } else {
            $message = "There is an error - user wasn't updated.";
            include ('view/updateUser.php');
        }
        die();
        break;
}
    