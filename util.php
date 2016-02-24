<?php
/**
 * Created by IntelliJ IDEA.
 * User: fahziar
 * Date: 23/02/2016
 * Time: 13.30
 */

class Util{

    public static function validateUsername($username){
        if ((preg_match("/^[0-9a-z_]+$/", $username) == 0) && strlen($username) < 51 && strlen($username) > 2) {
            return false;
        } else {
            return true;
        }
    }


    public static function validatePassword($password){
        return (strlen($password) <= 50) && (strlen($password) >= 6);
    }
}