<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_data($quiz_id){
        require "config.php";
        include_once("controller/app_module.php");
        $quiz_id = input_data($quiz_id);
        $sql = "SELECT q.title,quiz_question_id, qq.quiz_id, qq.question_id, qq.user_id, question, ans_choice, question_type, q.subj_id, s.subj_name FROM quiz_question qq 
        INNER JOIN questions q ON qq.question_id = q.question_id INNER JOIN subjects s ON q.subj_id = s.subj_id WHERE qq.status = 1 AND q.status = 1 AND qq.quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_id));
        return $query;
    }
    function del_question($quiz_question_id){
        require "config.php";
        include_once("app_module.php");
        $sql = "DELETE FROM quiz_question WHERE quiz_question_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_question_id));
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
?>