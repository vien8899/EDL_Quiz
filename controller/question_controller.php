<?php
    date_default_timezone_set("Asia/Vientiane");
    //insert question
    if(isset($_POST['new_question'])){
        require "../config.php";
        include_once("app_module.php");
        $question_data = json_decode(decode($_POST['new_question']));
        $url_param = $question_data->urlParam;
        $ans_choice = json_encode($question_data->ans_choice);
        $correct_ans = json_encode($question_data->correct_ans);
        $title = $question_data->title;
        $question = $question_data->question;
        $question_type = $question_data->question_type;
        $subj_id = $question_data->subj_id;
        $user_id = $question_data->user_id;
        $full_point = $question_data->full_point;
        $show_ques_content = $question_data->show_ques_content;
        $sql = "INSERT INTO questions(title,question, ans_choice, correct_ans, question_type, subj_id,full_point,show_ques_content, user_id) 
        VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $dbcon->prepare($sql);
        $query->execute(array($title,$question,$ans_choice,$correct_ans,$question_type,$subj_id,$full_point,$show_ques_content,$user_id));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=question".$url_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການແກ້ໄຂຂໍ້ມູນ!</span>'})";
        }
        
    }
    //update
    if(isset($_POST['update_question'])){
        require "../config.php";
        include_once("app_module.php");
        $question_data = json_decode(decode($_POST['update_question']));
        $url_param = $question_data->urlParam;
        $ans_choice = json_encode($question_data->ans_choice);
        $correct_ans = json_encode($question_data->correct_ans);
        $title = $question_data->title;
        $question = $question_data->question;
        $question_type = $question_data->question_type;
        $subj_id = $question_data->subj_id;
        $user_id = $question_data->user_id;
        $full_point = $question_data->full_point;
        $show_ques_content = $question_data->show_ques_content;
        $question_id = $question_data->question_id;
        // title,question, ans_choice, correct_ans, question_type, subj_id,full_point,show_ques_content, user_id
        $sql = "UPDATE questions SET title=?,question=?,ans_choice=?,correct_ans=?,question_type=?,subj_id=?,full_point=?,show_ques_content=?,user_id=? WHERE question_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($title,$question,$ans_choice,$correct_ans,$question_type,$subj_id,$full_point,$show_ques_content,$user_id,$question_id));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=question".@$url_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການແກ້ໄຂຂໍ້ມູນ!</span>'})";
        }
    }
    function add_class($class_des,$user_id){
        require "config.php";
        include_once("controller/app_module.php");
        $class_des = input_data($class_des);
        $user_id = input_data($user_id);
        //check duplicate
        $sql = "SELECT*FROM class_rooms WHERE class_des = '$class_des' AND status = 1";
        $class = $dbcon->prepare($sql);
        $class->execute();
        if($class->rowCount()==0){
            $sql = "INSERT INTO class_rooms(class_des,user_id,status) VALUES('$class_des','$user_id',1)";
            $query = $dbcon->exec($sql);
            if($query){
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ບັນທຶກສໍາເລັດ!</span>', '', 'success')
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                    </script>
                <?php 
            }
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath><?=$class_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function update_class($class_id,$class_des,$user_id){
        require "config.php";
        include_once("controller/app_module.php");
        $class_des = input_data($class_des);
        $class_id = input_data($class_id);
        $user_id = input_data($user_id);
        $sql = "SELECT*FROM class_rooms WHERE class_des = '$class_des' AND status = 1";
        $class = $dbcon->prepare($sql);
        $class->execute();
        if($class->rowCount()==0){
            $sql = "UPDATE class_rooms SET class_des = '$class_des', user_id = $user_id WHERE id = $class_id";
            $query = $dbcon->exec($sql);
            if($query){
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນສໍາເລັດ!</span>', '', 'success')
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                    </script>
                <?php    
            }
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath><?=$class_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_question($question_id){
        require "config.php";
        include_once("controller/app_module.php");
        $question_id = input_data($question_id);
        $sql = "UPDATE questions SET status = 0 WHERE question_id=$question_id";
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
    function load_data($subj_id,$user_id,$permission){
        require "config.php";
        $param = $permission?" ":" AND q.user_id = $user_id";
        if($subj_id==0){
            $sql = "SELECT question_id,title,question,ans_choice,question_type,q.user_id,s.subj_name,full_point FROM questions q INNER JOIN subjects s 
            ON q.subj_id = s.subj_id WHERE q.status = 1 AND s.status = 1 $param ORDER BY question_id DESC";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }else{
            $sql = "SELECT question_id,title,question,ans_choice,question_type,q.user_id,s.subj_name,full_point FROM questions q INNER JOIN subjects s ON q.subj_id = s.subj_id 
            WHERE q.status = 1 AND q.subj_id = ? $param ORDER BY question_id DESC";
            $query = $dbcon->prepare($sql);
            $query->execute(array($subj_id));
            return $query;
        }
    }
    function load_subject(){
        require "config.php";
        $sql = "SELECT*FROM subjects WHERE status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_question_selection($class_id){
        require "config.php";
        include_once("controller/app_module.php");
        $class_id = input_data($class_id);
        $sql = "SELECT*FROM subjects WHERE status=1 AND subj_id NOT IN (SELECT subject_id FROM class_subject WHERE class_id = '$class_id')";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_question($question_id){
        require "config.php";
        $sql = "SELECT * FROM questions WHERE question_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($question_id));
        return $query;
    }
?>