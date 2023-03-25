<?php
    session_start();
    session_destroy();
    include_once 'controller/main_controller.php';
    // $file = "assets/json/app.json";
    // $token = json_decode(file_get_contents($file),true);
    // if(isset($token[getMachineID()])){
    //     unset($token[getMachineID()]);
    // }
    // file_put_contents($file, json_encode($token,true));
    header('Location:login');
