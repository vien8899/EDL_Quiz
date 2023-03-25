<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['start_exam'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['start_exam']));
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
            $quiz_question_id = $question_data[$question_no[$index]]['quiz_question_id'];
            
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
                $_insert_choice = input_data(json_encode($ans_choice));
                $insert_sql .="INSERT INTO answer(quiz_quest_id, test_number, question_title, question_des, ans_choice, correct_ans, answer, full_point, point, question_rang, question_type, show_ques_content) 
                VALUES ('".$quiz_question_id."', '".$test_number."', '".$question_title."', '".$question_des."', '".$_insert_choice."', '".json_encode($correct_ans)."', '', ".$full_point.", 0, ".$index.", 
                ".$question_type.", ".$show_ques_content.");";
            }else{
                if($question_data[$question_no[$index]]['show_ques_content']==1){
                    $ans = $question_data[$question_no[$index]]['question'];
                }
                $insert_sql .="INSERT INTO answer(quiz_quest_id, test_number, question_title, question_des, ans_choice, correct_ans, answer, full_point, point, question_rang, question_type, show_ques_content) 
                VALUES ('".$quiz_question_id."', '".$test_number."', '".$question_title."', '".$question_des."', '[]', '[]','".$ans."', ".$full_point.", 0, ".$index.", 
                ".$question_type.", ".$show_ques_content.");";
            }
            $ans = array(
                "quiz_question_id"=>$quiz_question_id,
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
            "class_quiz_id"=>$data->class_quiz_id,
            "user_ans"=>$user_answer_data,
            "selection_index"=>0
        );
        $insert_sql .="INSERT INTO test_quiz(test_number, quiz_title, start_time, submit_time, user_id, class_quiz_id, status) VALUES 
        ('".$test_number."', '".$data->quiz_title."', '".date("Y-m-d H:i:s")."', NULL, '".$data->user_id."', '".$data->class_quiz_id."', 1);";
        $query = $dbcon->exec($insert_sql);
        if($query){
            $res = array(
                "success"=>true,
                "exam_data"=>$exam_data
            );
        }else{
            $res = array(
                "success"=>false
            );
        }
        echo json_encode($res);
    }
    if(isset($_POST['update_ans'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['update_ans']));
        $ans_choice = json_encode($data->ans_choice);
        $answer = $data->answer;
        $point = $data->point;
        $quiz_quest_id = $data->quiz_quest_id;
        $test_number = $data->test_number;
        $submit_time = date("Y-m-d H:i:s");
        $sql = "UPDATE answer SET ans_choice=?,answer=?,point=? WHERE quiz_quest_id=? AND test_number=?;
                UPDATE test_quiz SET submit_time=? WHERE test_number = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($ans_choice,$answer,$point,$quiz_quest_id,$test_number,$submit_time,$test_number));
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