<?php
    // $server_name = "laoskyway.com";
    // $user_login = "laoskywa_quiz";
    // $userpass = "tik55210711";
    // $database_name = "laoskywa_quiz";
    // $server_name = "laoskywaytravel.com";
    // $user_login = "skywaytravel_01";
    // $userpass = "tik55210711";
    // $database_name = "skywaytravel_QUIZ_DB";

    $server_name = "localhost";
    $user_login = "root";
    $userpass = "";
    $database_name = "edl_quiz";
    try {
        $dbcon = new PDO(
            "mysql:host=$server_name;dbname=$database_name", $user_login, $userpass, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Faild to connect to database " . $e->getMessage();
    }
?>