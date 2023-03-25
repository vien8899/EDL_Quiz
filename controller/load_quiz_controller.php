<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['load_quiz'])){
        require "../config.php";
        $quiz_data = json_decode($_POST['load_quiz']);
        $class_des_param = "&class_des=" .$quiz_data->class_des;
        $class_id_param = "&class_id=" .$quiz_data->class_id;
        $quiz_id_list = "";
        foreach($quiz_data->quizes as $quiz_id){
            $quiz_id_list .= ",$quiz_id"; 
        }
        $quiz_id_list .= ")";
        $quiz_id = "(".substr($quiz_id_list,1,strlen($quiz_id_list)-1);
        $sql = "INSERT INTO class_quiz_prepare(class_id, quiz_id) SELECT $quiz_data->class_id, 
        quiz_id FROM quiz WHERE quiz_id IN $quiz_id";
        $query = $dbcon->exec($sql);
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_quiz_prepare".$class_id_param.$class_des_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    function get_quiz_data($class_id){
        require "config.php";
        $sql = "SELECT q.quiz_id,q.quiz_title,q.quiz_time,(SELECT COUNT(*) FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id)'question_num',
        IFNULL((SELECT SUM(full_point) FROM quiz_question WHERE quiz_id=q.quiz_id),0)'total_score' FROM quiz q WHERE q.status = 1 AND q.quiz_id NOT IN 
        (SELECT quiz_id FROM class_quiz_prepare cp WHERE cp.class_id = ?)";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_id));
        return $query;
    }
?>