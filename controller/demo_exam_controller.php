<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_demo_quiz(){
        require "config.php";
        $sql = "SELECT q.quiz_id,q.quiz_title,q.quiz_caption,q.quiz_num,q.quiz_time FROM quiz q WHERE q.status = 2";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function getQuizInfo($quiz_id){
        require "config.php";
        $sql = "SELECT quiz_title,quiz_caption,quiz_num,quiz_time,(SELECT SUM(full_point) 
        FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id) full_point,(SELECT COUNT(*) FROM quiz_question qq WHERE 
        qq.quiz_id = q.quiz_id) ques_num FROM quiz q WHERE q.quiz_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_id));
        return $query;
    }
    if(isset($_POST['start_demo_exam'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['start_demo_exam']));
        $sql = "SELECT q.question_id,q.question,q.ans_choice,q.correct_ans,q.question_type,q.subj_id,q.user_id,
        q.last_update,q.status,qq.full_point,q.title,q.show_ques_content,qq.quiz_question_id,qq.quiz_id FROM 
        quiz_question qq INNER JOIN questions q ON qq.question_id = q.question_id WHERE qq.quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($data->quiz_id));
        $question_data = $query->fetchAll(PDO::FETCH_ASSOC);
        $question_no = UniqueRandomNumbersWithinRange(0,(count($question_data)-1),count($question_data));
        $user_answer_data = array();
        $test_number = date("md").$data->user_id.date("His");
        $insert_sql = "";
        for($index = 0; $index < count($question_no); $index++){
            $ans_choice = array();
            $correct_ans = array();
            $ans = "";
            $question_title = input_data($question_data[$question_no[$index]]['title']);
            $question_des = input_data($question_data[$question_no[$index]]['question']);
            $full_point = $question_data[$question_no[$index]]['full_point'];
            $question_type = $question_data[$question_no[$index]]['question_type'];
            $show_ques_content = $question_data[$question_no[$index]]['show_ques_content'];
            if($question_data[$question_no[$index]]['question_type']==0 || $question_data[$question_no[$index]]['question_type'] ==1){
                $choices = json_decode($question_data[$question_no[$index]]['ans_choice']);
                $choice_rang = UniqueRandomNumbersWithinRange(0,(count($choices)-1),count($choices));
                $correct_ans = json_decode($question_data[$question_no[$index]]['correct_ans']);
                for($rang = 0; $rang < count($choice_rang); $rang++){
                    $_ans_choice = array(
                        "choice_index"=>$choice_rang[$rang],
                        "rang"=>$rang,
                        "choice"=>$choices[$choice_rang[$rang]],
                        "is_selected"=>0
                    );
                    array_push($ans_choice,$_ans_choice);
                }
            }else{
                if($question_data[$question_no[$index]]['show_ques_content']==1){
                    $ans = $question_data[$question_no[$index]]['question'];
                }
            }
            $ans = array(
                "test_number"=>$test_number,
                "question_title"=>$question_title,
                "question_des"=>$question_des,
                "ans_choice"=>$ans_choice,
                "correct_ans"=>$correct_ans,
                "ans"=>$ans,
                "full_point"=>$full_point,
                "point"=>0,
                "question_rang"=>$index,
                "question_type"=>$question_type,
                "show_ques_content"=>$show_ques_content
            );
            array_push($user_answer_data,$ans);
        }
        $exam_data = array(
            "test_number"=>$test_number,
            "quiz_title"=>$data->quiz_title,
            "start_time"=>date("Y-m-d H:i:s"),
            "submit_time"=>null,
            "quiz_time"=>$data->quiz_time,
            "user_id"=>$data->user_id,
            "user_ans"=>$user_answer_data,
            "selection_index"=>0
        );
        $res = array(
            "success"=>true,
            "exam_data"=>$exam_data
        );
        echo json_encode($res);
    }

?>