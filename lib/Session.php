<?php
namespace Holded;
class Session{
    private static $started = false;

    static function start(){
        if(!self::$started){
            $holded_session_id = null;
            if(isset($_COOKIE['holded_session_id'])){
                $holded_session_id = $_COOKIE['holded_session_id'];
            }else{
                $holded_session_id = bin2hex(random_bytes(16));
                setcookie('holded_session_id', $holded_session_id, time()+86400, '/');	
            }
            session_id($holded_session_id);

            session_start();
        }
        self::$started = true;
    }
}