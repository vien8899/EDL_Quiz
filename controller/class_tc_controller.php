<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['submit_tc'])){
        require "../config.php";
        include_once("app_module.php");
        $tc_data = json_decode($_POST['submit_tc']);
        $class_des_param = "&class_des=" .$tc_data->class_des;
        $class_id_param = "&class_id=" .$tc_data->class_id;
        $tc_list = "";
        foreach($tc_data->selected_tc as $tc_id){
            $tc_list .= ",$tc_id"; 
        }
        $tc_list .= ")";
        $tc_id = "(".substr($tc_list,1,strlen($tc_list)-1);
        $sql = "INSERT INTO class_tc(user_id, class_id) SELECT id,$tc_data->class_id FROM users WHERE id IN $tc_id";
        $query = $dbcon->exec($sql);
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_tc".$class_id_param.$class_des_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
    }
    function del_tc($id){
        require "config.php";
        $sql = "DELETE FROM class_tc WHERE id=?";
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
    function get_class_tc_data($class_id, $filter){
        require "config.php";
        $sql = "SELECT ct.id,ct.user_id,u.fullname,u.gender,class_id,d.dep_name,un.unit_des FROM class_tc ct INNER JOIN users u ON ct.user_id = u.id INNER JOIN departments d ON u.dep_id = d.dep_id LEFT JOIN tb_unit un ON u.unit_id = un.unit_id
        WHERE ct.class_id = $class_id $filter";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>