<?php

class Database {

    public static function getKoneksi(){

        $db = new mysqli('localhost', 'root', '', 'dbk_perpus');

        if($db->errno):
        
            exit;
        
        endif;

        return $db;

    }
    
}

?>