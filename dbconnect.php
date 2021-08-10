<?php

try {
    
    $whitelist = array('127.0.0.1', "::1");

    if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){

        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

        $pdo = new PDO("mysql:host=$server;dbname=$db","$username","$password");

    }else{

        $pdo = new PDO("mysql:host=localhost;dbname=product_management","root","");

    }

} catch (PDOException $e) {
    echo "";
}