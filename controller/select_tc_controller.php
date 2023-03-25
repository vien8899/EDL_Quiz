<?php
    date_default_timezone_set("Asia/Vientiane");
    function get_tc_data($class_id,$filter){
        require "config.php";
        $sql = "SELECT u.id,fullname,gender,date_of_birth,TRUNCATE((DATEDIFF(NOW(),date_of_birth)/365),0) 'age',
        tel,address,u.user_group_id,d.dep_id,d.dep_name,username,user_type,un.unit_id,un.unit_des,technical_knowledge, 
        degree, u.position_id, p.position_des FROM users u LEFT JOIN tb_unit un ON u.unit_id = un.unit_id INNER JOIN departments d 
        ON u.dep_id = d.dep_id LEFT JOIN tb_position p ON u.position_id = p.position_id WHERE u.user_status = 1 AND d.dep_status = 1 
        AND (SELECT COUNT(*) FROM tb_group_permission gp WHERE gp.user_group_id = u.user_group_id AND gp.module_id=21)!=0 AND 
        u.id NOT IN (SELECT user_id FROM class_tc ct WHERE ct.class_id = $class_id) $filter ORDER BY d.dep_id ;";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>