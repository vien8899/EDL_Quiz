<?php
    date_default_timezone_set("Asia/Vientiane");
    require "config.php";
    include_once("controller/app_module.php");
    function del_quiz($quiz_id,$user_id){
        global $dbcon;
        $quiz_id = input_data($quiz_id);
        $user_id = input_data($user_id);
        $sql = "UPDATE quiz SET status = 0, user_id = $user_id WHERE quiz_id=$quiz_id";
        $query = $dbcon->exec($sql);
        if($query){
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ລຶບຂໍ້ມູນສໍາເລັດ!</span>', '', 'success')
                </script>
            <?php
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການລຶບຂໍ້ມູນ!</span>', '', 'error')
                </script>
            <?php    
        }
    }
    function load_data($user_id,$view_all_quiz){
        global $dbcon;
        if($view_all_quiz){
            $sql = "SELECT quiz_id, quiz_title, quiz_caption, quiz_num, quiz_time, q.user_id, q.last_update, q.status,
            (SELECT COUNT(*) FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id)'question_num',
            IFNULL((SELECT SUM(full_point) FROM quiz_question WHERE quiz_id=q.quiz_id),0)'total_score'
            FROM quiz q WHERE q.status != 0;";
        }else{
            $sql = "SELECT quiz_id, quiz_title, quiz_caption, quiz_num, quiz_time, q.user_id, q.last_update, q.status,
            (SELECT COUNT(*) FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id)'question_num',
            IFNULL((SELECT SUM(full_point) FROM quiz_question WHERE quiz_id=q.quiz_id),0)'total_score'
            FROM quiz q WHERE q.status = 1 AND (q.user_id = $user_id OR q.status = 2);";
        }
        
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function set_question_num($question_num,$quiz_id,$user_id){
        global $dbcon;
        $sql = "UPDATE quiz SET quiz_num=?,user_id=? WHERE quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($question_num,$quiz_id,$user_id));
        if($query){
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ສໍາເລັດ!</span>', '', 'success')
                </script>
            <?php
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການດໍາເນີນການ!</span>', '', 'error')
                </script>
            <?php    
        }
    }
    function getQuizInfo($class_quiz_id){
        global $dbcon;
        $sql = "SELECT cq.class_quiz_id,quiz_title,quiz_caption,quiz_num,quiz_time,(SELECT SUM(full_point) 
        FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id) full_point,(SELECT COUNT(*) FROM quiz_question qq WHERE 
        qq.quiz_id = q.quiz_id) ques_num FROM class_quiz cq INNER JOIN quiz q ON cq.quiz_id = q.quiz_id WHERE cq.class_quiz_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_quiz_id));
        return $query;
    }
?>