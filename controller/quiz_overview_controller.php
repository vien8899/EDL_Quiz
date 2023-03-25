<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_test_quiz($user_id){
        require "config.php";
        include_once("controller/app_module.php");
        $status = 1;
        $quiz_id_filter = "";
        $class_id_filter = "";
        $sql = "SELECT test_id,test_number,tq.quiz_title,tq.start_time,tq.submit_time,tq.user_id,q.quiz_id,cq.class_id,c.class_des,tq.status
        FROM test_quiz tq INNER JOIN class_quiz cq ON tq.class_quiz_id = cq.class_quiz_id INNER JOIN quiz q on cq.quiz_id = q.quiz_id INNER JOIN 
        class_rooms c on cq.class_id = c.id WHERE (SELECT COUNT(*) FROM answer an WHERE an.test_number=tq.test_number AND an.question_type=2) != 0
        AND (c.id IN (SELECT tc.class_id FROM class_tc tc WHERE tc.user_id='$user_id')) AND tq.status=$status $class_id_filter $quiz_id_filter";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    if(isset($_POST['load_ans'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['load_ans']));
        $sql = "SELECT * FROM answer WHERE test_number=? AND question_type = 2";
        $query = $dbcon->prepare($sql);
        $query->execute(array($data->quiz_no));
        $ans_data = $query->fetchAll(PDO::FETCH_ASSOC);
        $res_data = array();
        $index = 0;
        foreach($ans_data as $_ans){
            $ans = array(
                "index"=>$index,
                "ans_id"=>$_ans['ans_id'],
                "question_title"=>$_ans['question_title'],
                "question_des"=>$_ans['question_des'],
                "answer"=>$_ans['answer'],
                "question_rang"=>$_ans['question_rang'],
                "full_point"=>$_ans['full_point'],
                "show_ques_content"=>intval($_ans['show_ques_content']),
                "point"=>$_ans['point']
            );
            array_push($res_data,$ans);
            $index++;
        }
        echo json_encode($res_data);
    }
    if(isset($_POST['set_score'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['set_score']));
        $test_number = $data->quiz_no;
        $ans_data = $data->ans_data;
        $username = $data->username;
        $sql = "";
        $log_des = $username." ກວດບົດເສັງ";
        $sql .="INSERT INTO action_logs(reference_id, description) VALUES ('".$test_number."','".$log_des."');";
        foreach($ans_data as $ans){
            $ans_id = $ans->ans_id;
            $point = $ans->point;
            $question_rang = $ans->question_rang;
            $log_des = $username." ໃຫ້ຄະແນນ ຂໍ້ ( ".$question_rang." ) ".$point." ຄະແນນ";
            $sql .="UPDATE answer SET point='".$point."' WHERE ans_id='".$ans_id."' AND test_number='".$test_number."';";
            $sql .="INSERT INTO action_logs(reference_id, description) VALUES ('".$test_number."','".$log_des."');";
        }
        $sql .="UPDATE test_quiz SET status=2 WHERE test_number='".$test_number."';";
        $query = $dbcon->exec($sql);
        if($query){
            $res = array(
                "success"=>true
            );
        }else{
            $res = array(
                "success"=>false
            );
        }
        echo json_encode($res);
    }
?>