<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['submit_member'])){
        require "../config.php";
        include_once("app_module.php");
        $member_data = json_decode($_POST['submit_member']);
        $class_des_param = "&class_des=" .$member_data->class_des;
        $class_id_param = "&class_id=" .$member_data->class_id;
        $member_id_list = "";
        foreach($member_data->selected_member as $member_id){
            $member_id_list .= ",$member_id"; 
        }
        $member_id_list .= ")";
        $member_id = "(".substr($member_id_list,1,strlen($member_id_list)-1);
        $sql = "INSERT INTO class_members(user_id, class_id) SELECT id,$member_data->class_id FROM users WHERE id IN $member_id";
        $query = $dbcon->exec($sql);
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_member".$class_id_param.$class_des_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    function load_department(){
        require "config.php";
        $sql = "SELECT * FROM departments WHERE dep_status = 1";
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
    function load_user($class_id,$filter){
        require "config.php";
        $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',tel,address,u.user_group_id,
        d.dep_id,d.dep_name,username,user_type,un.unit_id,un.unit_des,technical_knowledge, degree, u.position_id, p.position_des 
        FROM users u LEFT JOIN tb_unit un ON u.unit_id = un.unit_id INNER JOIN departments d ON u.dep_id = d.dep_id LEFT JOIN tb_position p 
        ON u.position_id = p.position_id WHERE u.user_status = 1 AND d.dep_status = 1 AND u.id NOT IN 
        (SELECT user_id FROM class_members cm WHERE cm.class_id = $class_id) AND user_type = 2 $filter ORDER BY d.dep_id ";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_member($class_id,$filter){
        require "config.php";
        $sql = "SELECT cm.id,cm.user_id,u.fullname,u.gender,class_id,d.dep_name FROM class_members cm INNER JOIN users u ON cm.user_id = u.id INNER JOIN departments d ON u.dep_id = d.dep_id 
        WHERE class_id = $class_id $filter";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function del_member($id){
        require "config.php";
        $sql = "DELETE FROM class_members WHERE id=?";
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