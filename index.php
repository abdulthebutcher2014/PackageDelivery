<?php
require_once 'model/User.php';
require_once 'model/user_db.php';
require_once 'model/PackageDeliveryDB.php';

//check to see if there is an adminstrator if not add one with userid/password
// admin/admin. This will skip validation but give us an adminstrator we can 
// log- on with right away.

if(UserDB::uniqueUsername('admin')){//We will need to create the user admin in the db
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

switch ($action){
    case 'login':
        include ('view/logon.php');
        break;
}
