<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['load_exam_data'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['load_exam_data']));
        $sql = "SELECT q.question_id,q.question,q.ans_choice,q.correct_ans,q.question_type,q.subj_id,q.user_id,
        q.last_update,q.status,qq.full_point,q.title,q.show_ques_content,qq.quiz_question_id,qq.quiz_id FROM 
        quiz_question qq INNER JOIN questions q ON qq.question_id = q.question_id WHERE qq.quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($data->quiz_id));
        $question_data = $query->fetchAll(PDO::FETCH_ASSOC);
        $sql = "SELECT quiz_id, quiz_title, quiz_caption, quiz_num, quiz_time, q.user_id, q.last_update, q.status,
        (SELECT COUNT(*) FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id)'question_num',
        (SELECT SUM(full_point) FROM quiz_question WHERE quiz_id=q.quiz_id)'total_score'
        FROM quiz q WHERE q.status != 0 AND q.quiz_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($data->quiz_id));
        $quiz_data = $query->fetchAll(PDO::FETCH_ASSOC)[0];
        $questions = array();
        // $rang = 0;
        foreach($question_data as $question){
            $ans_choice = array();
            if($question['question_type']==0 || $question['question_type'] ==1){
                $choices = json_decode($question['ans_choice']);
                $index = 0;
                foreach($choices as $choice){
                    $_choice = array(
                        "choice_index"=>$index,
                        "choice"=>$choice
                    );
                    array_push($ans_choice,$_choice);
                    $index++;
                }
            }
            $quest = array(
                // "question_rang"=>$rang,
                "question_id"=>$question['question_id'],
                "quiz_question_id"=>$question['quiz_question_id'],
                "question_title"=>$question['title'],
                "question_des"=>$question['question'],
                "ans_choice"=>$ans_choice,
                "full_point"=>intval($question['full_point']),
                "question_type"=>$question['question_type'],
                "show_ques_content"=>$question['show_ques_content']
            );
            array_push($questions,$quest);
            // $rang++;
        }
        $res_data = array(
            "quiz_title"=>$quiz_data['quiz_title'],
            "quiz_time"=>$quiz_data['quiz_time'],
            "total_score"=>intval($quiz_data['total_score']),
            "questions"=>$questions
        );
        echo json_encode($res_data);
    }
    if(isset($_POST['delete_quiz_question'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['delete_quiz_question']));
        $quiz_question_id = $data->quiz_question_id;
        $sql = "DELETE FROM quiz_question WHERE quiz_question_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_question_id));
        if($query){
            $res_data = array(
                "success"=>true
            );
        }else{
            $res_data = array(
                "success"=>false
            );
        }
        echo json_encode($res_data);
    }
    if(isset($_POST['update_score'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['update_score']));
        $quiz_question_id = $data->quiz_question_id;
        $user_id = $data->user_id;
        $full_point = $data->full_point;
        $sql = "UPDATE quiz_question SET user_id=?,full_point=? WHERE quiz_question_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_id,$full_point,$quiz_question_id));
        if($query){
            $res_data = array(
                "success"=>true
            );
        }else{
            $res_data = array(
                "success"=>false
            );
        }
        echo json_encode($res_data);
    }
?>