<?php

class validation {

    public static function isNotEmpty($arg, $label) {
        if ($arg === null || $arg === "") {
            return $label . ' must not be empty';
        } else {
            return "";
        }
    }

    public static function validAmount($arg, $label) {
        if (preg_match('/\d+(\.\d{1,2})?/', $arg)) { //found this regex at https://stackoverflow.com/questions/308122/simple-regular-expression-for-a-decimal-with-a-precision-of-2
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

}
