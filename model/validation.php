<?php

class validation {

    public static function isNotEmpty($arg, $label) {
        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        } else {
            return "";
        }
    }

    public static function validDistance($arg, $label) {
        if (!is_integer($arg)) { 
            //return $label . ' must be a value in miles';
            return "";
        } else {
            return "";
        }
    }
    public static function validAmount($arg, $label){
        if (!preg_match('/\d+(\.\d{1,2})?/', $arg)) { //found this regex at https://stackoverflow.com/questions/308122/simple-regular-expression-for-a-decimal-with-a-precision-of-2
            return $label . ' must a valid dollar amount';
        } else {
            return "";
        }
    }

    public static function nameCheck($arg, $label) {
        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        }
        $leng = strlen($arg);
        if (is_numeric($arg[0])) {
            return $label . ' can not start with a number';
        } else if ($leng < 3 || $leng > 30) {
            return $label . ' needs to be between 4 and 30 characters';
        } else {
            return "";
        }
    }

    public static function cityCheck($arg, $label) {
        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        }else{
            return "";
        }
    }

    public static function stateCheck($arg, $label) {
        $lengt = strlen($arg);
        if ($lengt !== 2) {
            return $label . ' needs to be two characters';
        } else {
            return "";
        }
    }

    public static function logonidCheck($arg, $label) {
        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        }
        $leng = strlen($arg);
        if (is_numeric($arg[0])) {
            return $label . ' can not start with a number';
        } else if ($leng < 3 || $leng > 30) {
            return $label . ' needs to be between 3 and 30 characters';
        } else if (!UserDB::uniqueUsername($arg)) {
            return $label . ' ' . $arg . ' is already used. Id needs to be unique';
        } else {
            return "";
        }
    }

    public static function passwordCheck($arg, $label) {

        $error = "";
        $counter = 0;

        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        }

        if (!preg_match('/[A-Z]/', $arg)) {

            $error .= 'Password needs to have one upper case letter. ';
            $counter++;
        }
        if (!preg_match('/[a-z]/', $arg)) {
            $error .= 'Password needs to have one lower case letter. ';
            $counter++;
        }
        if (!preg_match('/[0-9]/', $arg)) {
            $error .= 'Password needs to have at least one number. ';
            $counter++;
        }
        if (!preg_match('/[!@#$%.]/', $arg)) {
            $error .= 'Password needs to have at least one special character .!@#&%';
            $counter++;
        }
        if ($counter <= 1) {
            return "";
        } else {
            return $error;
        }
    }

    public static function passwordSame($password1, $password2) {
        if ($password1 === $password2) {
            return "";
        } else {
            return"Passwords do not match ";
        }
    }

    public static function emailCheck($email, $label) {
        $parts = explode("@", $email);
        if (count($parts) != 2) {
            return $label . " is invalid";
        }
        if (strlen($parts[0]) > 64) {
            return $label . " is invalid";
        }
        if (strlen($parts[1]) > 255) {
            return $label . " is invalid";
        }

        $atom = '[[:a1num:]_!#$%&\'*+\/=?^`{|}~-]+';
        $dotatom = '(\.' . $atom . ')*';
        $address = '(^' . $atom . $dotatom . '$)';
        $char = '([^\\\\"])';
        $esc = '(\\\\[\\\\"])';
        $text = '(' . $char . '|' . $esc . ')+';
        $quoted = '(^"' . $text . '"$)';
        $local_part = '/' . $address . '|' . $quoted . '/';
        //$local_match = preg_match($local_part, $parts[0]);
        //if ($local_match === FALSE || $local_match != 1) {
        //  return $label . " is invalid";
        //}
        $hostname = '([[:a1num:]]([-[:a1num:]]{0,62}[[:a1num:]])?)';
        $hostnames = '(' . $hostname . '(\.' . $hostname . ')*)';
        $top = '\.[[:a1num:]]{2,6}';
        $domain_part = '/^' . $hostnames . $top . '$/';
        //$domain_match = preg_match($domain_part, $parts[1]);
        //if ($domain_match === FALSE || $domain_match != 1) {
        //  return $label . " is invalid";
        //}
        return "";
    }

}
