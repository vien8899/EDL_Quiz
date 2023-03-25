<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['new_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp_data = json_decode(decode($_POST['new_employee']));
        $url_param = decode($emp_data->url_param);
        $user_code = input_data($emp_data->user_code);
        $fullname = input_data($emp_data->fullname);
        $gender = input_data($emp_data->gender);
        $dep_id = input_data($emp_data->dep_id);
        $unit_id = input_data($emp_data->unit_id);
        $technical_knowledge = input_data($emp_data->technical_knowledge);
        $degree = input_data($emp_data->degree);
        $position_id = input_data($emp_data->position_id);
        $user_group_id = input_data($emp_data->user_group_id);
        $username = $emp_data->username;
        $password = password_hash($emp_data->password,PASSWORD_DEFAULT);
        $address = ($emp_data->address=="")?null:input_data($emp_data->address);
        $tel = ($emp_data->tel=="")?null:input_data($emp_data->tel);
        $user_type = input_data($emp_data->user_type);
        $date_of_birth = ($emp_data->date_of_birth=="")?null:input_data($emp_data->date_of_birth);
        $sql = "SELECT CASE WHEN (SELECT COUNT(*) FROM users WHERE user_code=?)=1 THEN 'ລະຫັດພະນັກງານຊໍ້າກັນ' 
                WHEN (SELECT COUNT(*) FROM users WHERE fullname=?)=1 THEN 'ຊື່ພະນັກງານຊໍ້າກັນ' 
                WHEN (SELECT COUNT(*) FROM users WHERE username=?)=1 THEN 'ຊື່ເຂົ້າໃຊ້ລະບົບຊໍ້າກັນ' 
                ELSE FALSE END AS result";
        $return_data = $dbcon->prepare($sql);
        $return_data->execute(array($user_code,$fullname,$username));
        $result = $return_data->fetch(PDO::FETCH_ASSOC)['result'];
        if(!$result){
            $sql = "INSERT INTO users(user_code, fullname, gender, date_of_birth, address, tel, dep_id, unit_id, technical_knowledge, degree, position_id, username, password, user_type, user_group_id) VALUES 
            (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($user_code, $fullname, $gender, $date_of_birth, $address, $tel, $dep_id, $unit_id, $technical_knowledge, $degree, $position_id, $username, $password, $user_type, $user_group_id));
            if($query){
                echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee".$url_param."'}});";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
            }
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>".$result."!</span>'})";
        }
        
    }
    if(isset($_POST['update_employee'])){
        require "../config.php";
        include_once("app_module.php");
        date_default_timezone_set("Asia/Vientiane");
        $emp = json_decode(decode($_POST['update_employee']));
        $emp_old = $emp->old_emp;
        $emp_data = $emp->new_emp;
        $id = input_data($emp_data->em_id);
        $fullname = '';
        $username= '';
        $password= '';
        $date_of_birth = ($emp_data->date_of_birth=="")?null:input_data($emp_data->date_of_birth);
        if($emp_data->fullname != $emp_old->fullname){
            $sql = "SELECT COUNT(*)'num' FROM users WHERE fullname=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($emp_data->fullname));
            $result = $query->fetch(PDO::FETCH_ASSOC)['num'];
            if($result==0){
                $fullname = " ,fullname = '".$emp_data->fullname."'";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ຊື່ພະນັກງານຊໍ້າກັນ!</span>'})";
                return;
            }
        }
        if($emp_data->username != $emp_old->username){
            $sql = "SELECT COUNT(*)'num' FROM users WHERE username=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($emp_data->username));
            $result = $query->fetch(PDO::FETCH_ASSOC)['num'];
            if($result==0){
                $username = " ,username = '".$emp_data->username."'";
            }else{
                echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ຊື່ເຂົ້າໃຊ້ລະບົບຊໍ້າກັນ!</span>'})";
                return;
            }
        }
        if($emp_data->password!="edlquiz")
            $gender = " ,password = '".password_hash($emp_data->password,PASSWORD_DEFAULT)."'";
        $sql = "UPDATE users SET gender=?,date_of_birth=?,address=?,tel=?,dep_id=?,unit_id=?,technical_knowledge=?,degree=?,position_id=?,user_type=?,user_group_id=? ".$fullname.$username.$password." WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($emp_data->gender,$date_of_birth,$emp_data->address,
        $emp_data->tel,$emp_data->dep_id,$emp_data->unit_id,$emp_data->technical_knowledge,
        $emp_data->degree,$emp_data->position_id,$emp_data->user_type,$emp_data->user_group_id,
        $emp_data->em_id));
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=employee".$emp->url_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    if(isset($_POST['get_unit_by_dep'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode(decode($_POST['get_unit_by_dep']));
        $dep_id = $data->dep_id;
        $sql = "SELECT*FROM tb_unit WHERE unit_status=1 AND dep_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($dep_id));
        $unit_data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($unit_data);
    }
    function set_user_group($user_id,$user_group_id){
        require "config.php";
        $sql = "UPDATE users SET user_group_id = ? WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_group_id,$user_id));
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
    }
    function update_pwd($user_id,$password){
        require "config.php";
        $password = password_hash($password,PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($password,$user_id));
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
    }
    function load_department(){
        require "config.php";
        include_once("controller/app_module.php");
        $sql = "SELECT*FROM departments WHERE dep_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_unit($dep_id){
        require "config.php";
        if($dep_id==0){
            $sql = "SELECT*FROM tb_unit WHERE unit_status=1";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }else{
            $sql = "SELECT*FROM tb_unit WHERE unit_status=1 AND dep_id = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($dep_id));
            return $query;
        }
    }
    function del_emp($emp_id){
        require "config.php";
        include_once("controller/app_module.php");
        $emp_id = input_data($emp_id);
        $sql = "UPDATE users SET user_status = 0 WHERE id=$emp_id";
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
    function load_employee($dep_id,$unit_id){
        require "config.php";
        if($dep_id == 0){
            $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.user_group_id,
            d.dep_id,d.dep_name,username,user_type,un.unit_id,un.unit_des,technical_knowledge, degree, u.position_id, p.position_des 
            FROM users u LEFT JOIN tb_unit un ON u.unit_id = un.unit_id INNER JOIN departments d ON u.dep_id = d.dep_id LEFT JOIN tb_position p ON u.position_id = p.position_id WHERE u.user_status = 1 AND d.dep_status = 1 ORDER BY d.dep_id";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }else{
            if($unit_id==0){
                $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.user_group_id,
                d.dep_id,d.dep_name,username,user_type,un.unit_id,un.unit_des,technical_knowledge, degree, u.position_id, p.position_des 
                FROM users u LEFT JOIN tb_unit un ON u.unit_id = un.unit_id INNER JOIN departments d ON u.dep_id = d.dep_id LEFT JOIN tb_position p ON u.position_id = p.position_id WHERE u.user_status = 1 AND d.dep_status = 1 AND un.dep_id=? ORDER BY d.dep_id";
                $query = $dbcon->prepare($sql);
                $query->execute(array($dep_id));
                return $query;
            }else{
                $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.user_group_id,
                d.dep_id,d.dep_name,username,user_type,un.unit_id,un.unit_des,technical_knowledge, degree, u.position_id, p.position_des 
                FROM users u LEFT JOIN tb_unit un ON u.unit_id = un.unit_id INNER JOIN departments d ON u.dep_id = d.dep_id LEFT JOIN 
                tb_position p ON u.position_id = p.position_id WHERE u.user_status = 1 AND d.dep_status = 1 AND un.dep_id=? AND un.unit_id=? ORDER BY d.dep_id";
                $query = $dbcon->prepare($sql);
                $query->execute(array($dep_id,$unit_id));
                return $query;
            }
        }
    }
    function get_emp_by_id($emp_id){
        require "config.php";
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($emp_id));
        return $query;
    }
    function get_position(){
        require "config.php";
        $sql = "SELECT*FROM tb_position WHERE position_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_user_group(){
        require "config.php";
        $sql = "SELECT*FROM tb_user_group WHERE user_group_status=1 AND user_group_id !=1 ";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>