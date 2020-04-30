<?php

require_once 'model/User.php';
require_once 'model/user_db.php';
require_once 'model/PackageDeliveryDB.php';
require_once 'model/validation.php';
require_once 'model/parameters_db.php';
require_once 'model/Parameter.php';
require_once 'model/Location.php';
require_once 'model/location_db.php';
require_once 'model/delivery_db.php';
require_once 'model/delivery.php';
require_once 'model/package_db.php';
require_once 'model/package.php';
require_once 'model/SendNotifiation.php';
require_once 'model/Delivery_display.php';

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
                    //$isAdministrator = $user->getIsAdministrator();
                    //$adminuser = UserDB::getUser($_SESSION['username']);
                    $adminuserpermission = $user->getIsAdministrator();
                    $users = UserDB::getUsers();
                    include('view/updateUser.php');
                } else {
                    $user = UserDB::getUser($_SESSION['username']);
                    $adminuserpermission = $user->getIsAdministrator();
                    $location = location_db::getLocations();
                    $users = UserDB::getUsers();
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
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $message = "";
        $location = location_db::getLocations();
        $users = UserDB::getUsers();

        include ('view/RequestDelivery.php');
        die();
        break;
    case 'new_delivery':
        $deliveries = array($_POST['from_location'], $_POST['to_location'], $_POST['from_user'], $_POST['to_user']);
        $delivery_from = location_db::getLocation($deliveries[0]);
        $delivery_to = location_db::getLocation($deliveries[1]);
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $user_from = UserDB::getUserByID($deliveries[2]);
        $user_to = UserDB::getUserByID($deliveries[3]);
        $distance = $delivery_to->getDistance();
        $total = $distance * ParametersDB::getRatePerMile() + ParametersDB::getInitialDeliveryPrice();

        $display_total = number_format($total, 2, '.', ',');

        $message = "";
        include ('view/NewDelivery.php');

        die();
        break;
    case 'approve_delivery':
        //$deliveries = array($_POST['from_location'], $_POST['to_location'], $_POST['from_user'], $_POST['to_user'], $_POST['distance'], $_POST['total']);
        $deliveries = array(filter_input(INPUT_POST, 'from_location'), filter_input(INPUT_POST, 'to_location'), filter_input(INPUT_POST, 'from_user'), filter_input(INPUT_POST, 'to_user'), filter_input(INPUT_POST, 'distance'), filter_input(INPUT_POST, 'total'));
        $delivery_from = location_db::getLocation($deliveries[0]);
        $delivery_to = location_db::getLocation($deliveries[1]);
        $user_from = UserDB::getUserByID($deliveries[2]);
        $user_to = UserDB::getUserByID($deliveries[3]);
        $distance = filter_input(INPUT_POST, 'distance');
        $total = filter_input(INPUT_POST, 'total');
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        //now insert a new package
        $package_id = package_db::addPackage("Recieved");
        //now insert a new delivery
        $delivery_id = delivery_db::addDelivery($delivery_from->getId(), $delivery_to->getId(), $total, $package_id, $user_to->getId(), $user_from->getId());
        //write to file.
        $text = date('m/d/Y') . "|" . date('H:i:s') . "|" . $delivery_id . "|" . $package_id . "|" . "received\n";
        $fp = fopen('delivery.log', 'a');
        fwrite($fp, $text);
        $message = "Thank you for your request";
        //Send e-mail.
        include ('view/ApproveDelivery.php');
        die();
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
            $location = location_db::getLocations();
            $user = UserDB::getUsers();
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
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
       
        $adminuserpermission = $user->getIsAdministrator();
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
        
        $isAdministrator = $user->getIsAdministrator();
        $adminuser = UserDB::getUser($user);
        
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
            include('view/updateUser.php');
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

        $adminuserpermission = $user->getIsAdministrator();
        $users = UserDB::getUsers();
        include('view/updateUser.php');
        die();
        break;
    case 'parameters':
        $user = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $user->getIsAdministrator();
        $baseprice = ParametersDB::getInitialDeliveryPrice();
        $milagerate = ParametersDB::getRatePerMile();
        $errors = array("", "", "", "");
        $message = "";
        include('view/frmParameters.php');
        die();
        break;
    case 'parameters2':
        $user = UserDB::getUser($_SESSION['username']);
        $adminuserpermission = $user->getIsAdministrator();
        // get the values from the form and set the values in the database.
        $message = "";
        $errors = array("", "", "", "");
        $baseprice = filter_input(INPUT_POST, 'baseprice');
        $milagerate = filter_input(INPUT_POST, 'milagerate');
        $errors[0] = validation::validAmount($baseprice, 'Flat-rate');
        $errors[1] = validation::validAmount($milagerate, 'Milage-rate');
        if ($errors[0] == "" && $errors[1] == "") {
            $message = "Values for flat rate and Milage have been set.";
            $errors = array("", "", "", "");
            ParametersDB::setInitialDeliveryPrice($baseprice);
            ParametersDB::setRatePerMile($milagerate);
        }
        include ('view/frmParameters.php');
        die();
        break;
    case 'locations':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $message = "";
        $errors = array("", "", "", "");
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $distance = filter_input(INPUT_POST, 'distance');
        $locations = location_db::getLocations();
        if ($adminuserpermission == 1) {
            include('view/NewDelivery.php');
        } else {
            include('view/frmLocations.php');
        }
        die();
        break;
    case 'add_location':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $message = "";
        $errors = array("", "", "");
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $distance = filter_input(INPUT_POST, 'distance');
        $errors[0] = validation::cityCheck($city, 'City');
        $errors[1] = validation::stateCheck($state, 'State');
        $errors[2] = validation::validDistance($distance, 'Distance');

        $count = 0;
        for ($i = 0; $i < count($errors); $i++) {
            if ($errors[$i] === "") {
                $count++;
            }
        }

        if ($count >= 3) {
            location_db::addLocation($city, $state, $distance);
            $locations = location_db::getLocations();
            $message = $city . ", " . $state . " has been registered";
            $city = "";
            $state = "";
            $distance = "";
            include('view/frmLocations.php');
        } else {
            $locations = location_db::getLocations();
            $message = "There is an error - location wasn't added.";
            include ('view/frmLocations.php');
        }
        die();
        break;
    case 'delete_location':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $id = filter_input(INPUT_GET, 'location_id');
        location_db::deleteLocation($id);
        $locations = location_db::getLocations();
        $message = "";
        $errors = array("", "", "");
        $city = "";
        $state = "";
        $distance = "";
        include ('view/frmLocations.php');
        die();
        break;
    case 'update_location':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $id = filter_input(INPUT_GET, 'location_id');
        $location = location_db::getLocation($id);

        $locations = location_db::getLocations();
        $city = $location->getCity();
        $state = $location->getState();
        $distance = $location->getDistance();
        $message = "";
        $errors = array("", "", "");
        include ('view/frmLocations.php');
        die();
        break;
    case 'update_location2':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $id = filter_input(INPUT_GET, 'location_id');
        $location = location_db::getLocation($id);
        $city = $location->getCity();
        $state = $location->getState();
        $distance = $location->getDistance();
        location_db::update_location($id, $city, $state, $distance);
        $locations = location_db::getLocations();
        $message = "";
        $errors = array("", "", "");
        include ('view/frmLocations.php');
        die();
        break;
    case 'view_my_deliveries':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $myuserid = $user->getId();

        //get outbound deliveries
        $incoming_deliveries = delivery_db::getIncomingDeliveries($myuserid);

        //get inbound deliveries.
        $outgoing_deliveries = delivery_db::getOutGoingDeliveries($myuserid);

        include('view/view_my_delieveries.php');
        die();
        break;
    case 'all_deliveries':
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();

        $all_deliveries = delivery_db::getAllDeliveries();
        include('view/view_all_delieveries.php');
        die();
        break;
    case 'update_package';
        $userid = ($_SESSION['username']);
        $user = UserDB::getUser($userid);
        $adminuserpermission = $user->getIsAdministrator();
        $status = filter_input(INPUT_POST, 'status');
        $package_id = filter_input(INPUT_POST, 'package_id');
        $delivery_id = package_db::getDeliveryID_By_packageID($package_id);
        //update the package
        if ($status == "Recieved") {
            package_db::updatePackage($package_id, "Sent");
            $text = date('m/d/Y') . "|" . date('H:i:s') . "|" . $delivery_id . "|" . $package_id . "|" . "sent\n";
        }
        if ($status == "Sent") {
            package_db::updatePackage($package_id, "Delivered");
            $text = date('m/d/Y') . "|" . date('H:i:s') . "|" . $delivery_id . "|" . $package_id . "|" . "delivered\n";
        }
        $userid = ($_SESSION['username']);
        $all_deliveries = delivery_db::getAllDeliveries();
        $fp = fopen('delivery.log', 'a');
        fwrite($fp, $text);
        include('view/view_all_delieveries.php');
        die();
        break;
}
    