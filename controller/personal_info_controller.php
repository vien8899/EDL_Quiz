<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['change_pwd'])){
        require "../config.php";
        $data = json_decode($_POST['change_pwd']);
        $user_id = $data->user_id;
        $old_pwd = $data->old_pwd;
        $new_pwd = $data->new_pwd;
        $sql = "SELECT*FROM users WHERE id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_id));
        if(!$query || $query->rowCount()==0){
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ປ່ຽນລະຫັດຜ່ານບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການດຶງຂໍ້ມູນ!</span>'})";
        }else{
            $user_data = $query->fetch(PDO::FETCH_ASSOC);
            if(password_verify($old_pwd,$user_data['password'])){
                $sql = "UPDATE users SET password=? WHERE id=?";
                $query = $dbcon->prepare($sql);
                $query->execute(array(password_hash($new_pwd,PASSWORD_DEFAULT),$user_id));
                if($query){
                    echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then(() => {document.getElementById('close_btn').click();});";
                }else{
                    echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ປ່ຽນລະຫັດຜ່ານບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກຂໍ້ມູນ!</span>'})";
                }
            }else{
                echo "Swal.fire({icon:'info',html:'<span class=phetsarath>ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ!</span>'})";
            }
        }
    }
    function get_personal_info($id){
        require "config.php";
        $sql = "SELECT `user_code`,`fullname`,`date_of_birth`,`address`,`tel`,`technical_knowledge`,
        d.dep_name,un.unit_des,p.position_des,`degree`,`password` FROM `users` u INNER JOIN 
        departments d ON u.dep_id = d.dep_id LEFT JOIN tb_unit un ON u.unit_id = un.unit_id 
        LEFT JOIN tb_position p ON u.position_id = p.position_id WHERE u.id = ?;";
        $query = $dbcon->prepare($sql);
        $query->execute(array($id));
        return $query;
    }
?>