<?php

class SessionManager
{
    const PATH = "/";
    const NAME = "simpleblog";

    const IP_KEY = "address";
    const USER_AGENT_KEY = "userAgent";
    const USER_ID_KEY = 'userId';

    public static function sessionStart()
    {
        //Disable putting session in url
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);

        //Configure session cookie
        session_name(SessionManager::NAME . "_SESSION");
        session_set_cookie_params(0, SessionManager::PATH, $_SERVER['SERVER_NAME'], false, true);

        //Start session
        session_start();

        if (!self::checkHijack()){
            session_regenerate_id();
            $_SESSION = array();
            $_SESSION[SessionManager::IP_KEY] = $_SERVER['REMOTE_ADDR'];
            $_SESSION[SessionManager::USER_AGENT_KEY] = $_SERVER['HTTP_USER_AGENT'];
        }
    }

    public static function checkHijack()
    {
        if (!isset($_SESSION[SessionManager::IP_KEY]) || !isset($_SESSION[SessionManager::USER_AGENT_KEY])){
            return false;
        }

        if ($_SESSION[SessionManager::IP_KEY] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        if ($_SESSION[SessionManager::USER_AGENT_KEY] != $_SERVER['HTTP_USER_AGENT']){
            return false;
        }

        return true;
    }

    public static function regenerateSession()
    {
        session_regenerate_id(true);
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION[SessionManager::USER_ID_KEY]) && $_SESSION[SessionManager::USER_ID_KEY] != '';
    }

    public static function login($id)
    {
        $_SESSION[SessionManager::USER_ID_KEY] = $id;
        self::regenerateSession();
    }

    public static function logout(){
        unset($_SESSION[SessionManager::USER_ID_KEY]);
        self::regenerateSession();
    }
}

