<?php
    date_default_timezone_set("Asia/Vientiane");
    function get_class_quiz_data($class_id){
        require "config.php";
        $sql = "SELECT cp.id,q.quiz_title,q.quiz_time,(SELECT COUNT(*) FROM quiz_question qq WHERE qq.quiz_id = q.quiz_id)'question_num',
        IFNULL((SELECT SUM(full_point) FROM quiz_question WHERE quiz_id=q.quiz_id),0)'total_score' FROM class_quiz_prepare cp INNER JOIN quiz q 
        ON cp.quiz_id = q.quiz_id WHERE q.status = 1 AND cp.status = 1 AND class_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_id));
        return $query;
    }
    function del_quiz($id){
        require "config.php";
        $sql = "DELETE FROM class_quiz_prepare WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($id));
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