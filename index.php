<?php

require_once 'model/User.php';
require_once 'model/user_db.php';
require_once 'model/PackageDeliveryDB.php';
require_once 'model/validation.php';
require_once 'model/parameters_db.php';
require_once 'model/Parameter.php';

//check to see if there is an adminstrator if not add one with userid/password
// admin/admin. This will skip validation but give us an adminstrator we can 
// log- on with right away.

if (UserDB::uniqueUsername('admin')) {//We will need to create the user admin in the db
    UserDB::addUser('Adminstrator', 'admin', 'admin', 1, 'admin@jeffware.com');
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
                if (UserDB::is_valid_user_login($userid, "admin")) {
                    $message = "Please change admin password";
                    $user = UserDB::getUser($_SESSION['username']);

                    $errors = array("", "", "", "");
                    $name = $user->getName();
                    $logonid = $user->getLogonid();
                    $email = $user->getEmail();
                    $password = $user->getPassword();
                    $isAdministrator = $user->getIsAdministrator();
                    $adminuser = UserDB::getUser($_SESSION['username']);
                    $adminuserpermission = $adminuser->getIsAdministrator();
                    $users = UserDB::getUsers();
                    include('view/updateUser.php');
                } else {
                    include('view/RequestDelivery.php');
                }
            } else {
                $error_message = "Please provide correct credentials.";
                include('view/logon.php');
            }
        }
        die();
        break;
    case 'register':
        $errors = array("", "", "", "");
        if (!isset($name)) {
            $name = "";
        }
        if (!isset($logonid)) {
            $logonid = "";
        }
        if (!isset($email)) {
            $email = "";
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
        $errors = array("", "", "", "");
        $message = "";
        $name = filter_input(INPUT_POST, "name");
        $logonid = filter_input(INPUT_POST, 'logonid');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, "password");
        $password2 = filter_input(INPUT_POST, "password2");
        $errors[0] = validation::nameCheck($name, "Name");
        $errors[1] = validation::logonidCheck($logonid, "Logon-ID");
        $errors[3] = validation::emailCheck($email, "Email");
        $errors[2] = validation::passwordCheck($password, "Password");
        $errors[2] = validation::passwordSame($password, $password2) . $errors[2];
        $count = 0;
        for ($i = 0; $i < count($errors); $i++) {
            if ($errors[$i] === "") {
                $count++;
            }
        }
        if ($count >= 4) {
            UserDB::addUser($name, $logonid, $password, 0, $email);
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
        $message = "";
        $errors = array("", "", "", "");
        $name = $user->getName();
        $logonid = $user->getLogonid();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $isAdministrator = $user->getIsAdministrator();
        $adminuser = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $adminuser->getIsAdministrator();
        $users = UserDB::getUsers();
        include ('view/updateUser.php');
        die();
        break;
    case 'update_user2':
        $name = filter_input(INPUT_POST, 'name');
        $logonid = filter_input(INPUT_POST, 'logonid');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $password2 = filter_input(INPUT_POST, 'password2');
        $isAdmin = filter_input(INPUT_POST, 'isadmin');
        $admin = 0;
        if ($isAdmin === 'yes') {
            $admin = 1;
        }
        $user = UserDB::getUser($_SESSION['username']);
        $isAdministrator = $user->getIsAdministrator();
        $adminuser = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $adminuser->getIsAdministrator();
        $errors[0] = validation::nameCheck($name, "Name");
        $errors[1] = validation::nameCheck($logonid, "Logon-id");
        $errors[2] = validation::passwordCheck($password, "Password");
        $errors[2] = validation::passwordSame($password, $password2) . $errors[2];
        $errors[3] = validation::emailCheck($email, "Email");
        $count = 0;
        for ($i = 0; $i < count($errors); $i++) {
            if ($errors[$i] === "") {
                $count++;
            }
        }
        if ($count >= 4) {
            UserDB::update_user($name, $logonid, $password, $admin, $email);
            $message = $logonid . " has been updated";
            include('view/RequestDelivery.php');
        } else {
            $message = "There is an error - user wasn't updated.";
            $users = UserDB::getUsers();
            include ('view/updateUser.php');
        }
        die();
        break;
    case 'update_user3':
//get a user object for the user
        $logonid = filter_input(INPUT_GET, 'logonid');
        $user = UserDB::getUser($logonid);
        $adminuser = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $adminuser->getIsAdministrator();
        $message = "";
        $errors = array("", "", "", "");
        $name = $user->getName();
        $logonid = $user->getLogonid();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $isAdministrator = $user->getIsAdministrator();
        $users = UserDB::getUsers();
        include ('view/updateUser.php');
        die();
        break;
    case 'delete_user':
        $delete_user = filter_input(INPUT_GET, 'logonid');
        $user = UserDB::getUser($_SESSION['username']);
        if ($user->getIsAdministrator() === "1") {
            UserDB::deleteUser($delete_user);
            $message = "User " . $delete_user . " has been removed.";
        } else {
            $message = "User " . $delete_user . " has not been removed.";
        }
        $user = UserDB::getUser($_SESSION['username']);
        $errors = array("", "", "", "");
        $name = $user->getName();
        $logonid = $user->getLogonid();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $isAdministrator = $user->getIsAdministrator();
        $adminuser = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $adminuser->getIsAdministrator();
        $users = UserDB::getUsers();
        include('view/updateUser.php');
        die();
        break;
    case 'parameters':
        $baseprice= ParametersDB::getInitialDeliveryPrice();
        $milagerate= ParametersDB::getRatePerMile();
        $errors = array("", "", "", "");
        $message = "";
        include('view/frmParameters.php');
        die();
        break;
    case 'parameters2':
        // get the values from the form and set the values in the database.
        die();
        break;
}
    