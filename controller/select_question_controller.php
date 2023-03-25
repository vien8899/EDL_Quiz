<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['load_question'])){
        require "../config.php";
        include_once("app_module.php");
        $question_data = json_decode($_POST['load_question']);
        // quiz_id
        // quiz_title
        // subj_id
        $quiz_id_param = "&quiz_id=".$question_data->quiz_id;
        $quiz_title_param = "&quiz_title=".$question_data->quiz_title;
        $question_id_list = "";
        foreach($question_data->selected_question as $question_id){
            $question_id_list .= ",$question_id"; 
        }
        $question_id_list .= ")";
        $question_id = "(".substr($question_id_list,1,strlen($question_id_list)-1);
        $sql = "INSERT INTO quiz_question(quiz_id, question_id, user_id, status) SELECT $question_data->quiz_id,question_id, $question_data->user_id,1 FROM questions WHERE question_id IN $question_id";
        // $sql = "INSERT INTO class_subject (class_id,subject_id) SELECT $subject_data->class_id,subj_id FROM subjects WHERE subj_id IN $subj_id";
        $query = $dbcon->exec($sql);
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=quizes&sub_page=quiz_preview".$quiz_id_param.$quiz_title_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
        
    }
    function load_question($quiz_id,$subj_id){
        require "config.php";
        include_once("controller/app_module.php");
        $quiz_id = input_data($quiz_id);
        if($subj_id==0){
            $sql = "SELECT title,question_id,question,ans_choice,question_type,q.user_id,s.subj_name FROM questions q INNER JOIN subjects s ON q.subj_id = s.subj_id 
            WHERE q.status = 1 AND question_id NOT IN (SELECT question_id FROM quiz_question WHERE quiz_id = $quiz_id) ORDER BY question_id DESC";
        }else{
            $sql = "SELECT title,question_id,question,ans_choice,question_type,q.user_id,s.subj_name FROM questions q INNER JOIN subjects s ON q.subj_id = s.subj_id 
            WHERE q.status = 1 AND q.subj_id = $subj_id AND question_id NOT IN (SELECT question_id FROM quiz_question WHERE quiz_id = $quiz_id) ORDER BY question_id DESC";
        }
       
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_subject(){
        require "config.php";
        $sql = "SELECT*FROM subjects WHERE status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>