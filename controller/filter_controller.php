<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_class(){
        require "config.php";
        include_once("controller/app_module.php");
        $sql = "SELECT id'class_id',class_des FROM class_rooms WHERE status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_subject($class_id){
        require "config.php";
        include_once("controller/app_module.php");
        $filter = "";
        if($class_id!=""){
            $filter = " AND subj_id IN (SELECT subject_id'subj_id' FROM class_subject WHERE class_id='".$class_id."')";
        }
        $sql = "SELECT subj_id,subj_name FROM subjects WHERE status = 1 ".$filter;
    }
    function load_quiz($subj_id){
        require "config.php";
        include_once("controller/app_module.php");
    }
    
?>