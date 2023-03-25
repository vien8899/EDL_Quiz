<?php
    date_default_timezone_set("Asia/Vientiane");
    // if(isset($_POST['new_employee'])){
    //     require "../config.php";
    //     include_once("app_module.php");
    //     date_default_timezone_set("Asia/Vientiane");
    //     $emp_data = json_decode(decode($_POST['new_employee']));
    //     $fullname = input_data($emp_data->fullname);
    //     $gender = input_data($emp_data->gender);
    //     $dep_id = input_data($emp_data->dep_id);
    //     $username = $emp_data->username;
    //     $password = password_hash($emp_data->password,true);
    //     $address = ($emp_data->address=="")?null:input_data($emp_data->address);
    //     $tel = ($emp_data->tel=="")?null:input_data($emp_data->tel);
    //     $user_type = input_data($emp_data->user_type);
    //     $date_of_birth = ($emp_data->date_of_birth=="")?null:input_data($emp_data->date_of_birth);
    //     $sql = "INSERT INTO users (fullname, gender, date_of_birth, address, tel, dep_id, username, password, user_type, status)
    //     VALUES(?,?,?,?,?,?,?,?,?,?)";
    //     $query = $dbcon->prepare($sql);
    //     $query->execute(array($fullname,$gender,$date_of_birth,$address,$tel,$dep_id,$username,$password,$user_type,1));
    //     if($query){
    //         echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee'}});";
    //     }else{
    //         echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
    //     }
    // }
    if(isset($_POST['new_quiz'])){
        require "../config.php";
        include_once("app_module.php");
        $quiz_data = json_decode(decode($_POST['new_quiz']));
        $quiz_time = $quiz_data->quiz_time;
        $quiz_title = $quiz_data->quiz_title;
        $quiz_caption = $quiz_data->quiz_caption;
        $user_id = $quiz_data->user_id;
        $sql = "INSERT INTO quiz(quiz_title, quiz_caption, quiz_time, user_id) VALUES (?,?,?,?)";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_title, $quiz_caption, $quiz_time, $user_id));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=quizes'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    if(isset($_POST['update_quiz'])){
        require "../config.php";
        include_once("app_module.php");
        $quiz_data = json_decode(decode($_POST['update_quiz']));
        $quiz_id = $quiz_data->quiz_id;
        $quiz_time = $quiz_data->quiz_time;
        $quiz_title = $quiz_data->quiz_title;
        $quiz_caption = $quiz_data->quiz_caption;
        $user_id = $quiz_data->user_id;
        $sql = "UPDATE quiz SET quiz_title=?,quiz_caption=?,quiz_time=?,user_id=? WHERE quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_title, $quiz_caption, $quiz_time, $user_id, $quiz_id));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=quizes'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    function load_subject(){
        require "config.php";
        include_once("controller/app_module.php");
        $sql = "SELECT*FROM subjects WHERE status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_quiz($quiz_id){
        require "config.php";
        include_once("controller/app_module.php");
        $sql = "SELECT*FROM quiz WHERE quiz_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_id));
        return $query;
    }
?>