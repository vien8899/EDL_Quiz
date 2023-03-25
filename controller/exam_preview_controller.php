<?php
        date_default_timezone_set("Asia/Vientiane");
        if(isset($_POST['load_ans_data'])){
            require "../config.php";
            include_once("app_module.php");
            $data = json_decode(decode($_POST['load_ans_data']));
            $test_id = $data->test_id;
            $sql = "SELECT tq.test_id,test_number,quiz_title,start_time,submit_time,(SELECT SUM(full_point) 
            FROM answer WHERE test_number = tq.test_number)'full_point',(SELECT SUM(point) FROM answer WHERE 
            test_number = tq.test_number)'point',class_quiz_id,tq.user_id,u.fullname,u.gender FROM test_quiz tq 
            INNER JOIN users u ON tq.user_id = u.id WHERE test_id = ?; ";
            $query = $dbcon->prepare($sql);
            $query->execute(array($test_id));
            $test_data = $query->fetch(PDO::FETCH_ASSOC);
            $sql = "SELECT * FROM answer WHERE test_number = ?;";
            $query = $dbcon->prepare($sql);
            $query->execute(array($test_data['test_number']));
            $ans_data = $query->fetchAll(PDO::FETCH_ASSOC);
            $test_data['ans_data']=$ans_data;
            echo json_encode($test_data);
        }
?>