<?php
        date_default_timezone_set("Asia/Vientiane");
        if(isset($_POST['set_permission'])){
            require "../config.php";
            $permission_data = json_decode($_POST['set_permission']);
            $sql = "DELETE FROM tb_group_permission WHERE module_id IN (SELECT module_id FROM tb_module WHERE module_group_id = ?) AND user_group_id = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($permission_data->module_group_id,$permission_data->user_group_id));
            if($query){
                $sql = "";
                foreach($permission_data->module as $module_id){
                    $sql .="INSERT INTO tb_group_permission(user_group_id, module_id) VALUES ('".$permission_data->user_group_id."','".$module_id."');";
                }
                $query = $dbcon->exec($sql);
                if($query){
                    echo true;
                }else{
                    echo false;
                }
            }else{
                echo false;
            }
        }
        function load_user_group_data(){
            require "config.php";
            $sql = "SELECT user_group_id,group_des,user_group_status,(SELECT COUNT(*) FROM users u WHERE u.user_group_id = ug.user_group_id AND u.user_status=1)'member' FROM tb_user_group ug WHERE user_group_status = 1";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }
        function get_permission($user_group_id){
            require "config.php";
            $sql = "SELECT CONCAT('{\"user_group_id\":$user_group_id',',\"user_group_des\":\"',ug.group_des,'\",\"permission\":',
                (SELECT CONCAT('[',GROUP_CONCAT('{', permission_data, '}' SEPARATOR ','),']') AS module FROM
                (SELECT CONCAT(
                    '\"module_group_id\":\"',module_group_id,
                    '\",\"module_group_des\":\"',module_group_des,
                    '\",\"module\":',module
                ) AS permission_data  FROM (
                SELECT module_group_id,module_group_des, CONCAT('[',GROUP_CONCAT('{', module_json, '}' SEPARATOR ','),']') AS module FROM
                                   (
                                   SELECT m.module_group_id,mg.module_group_des,
                                   CONCAT
                                   (
                                       '\"module_id\":\"',m.module_id,
                                       '\",\"module_code\":\"',m.module_code,
                                       '\",\"module_des\":\"',m.module_des,
                                       '\",\"allow\":',
                                       (SELECT COUNT(*) FROM tb_group_permission gp WHERE gp.module_id = m.module_id AND gp.user_group_id = $user_group_id)
                                   ) AS module_json
                                   FROM tb_module m INNER JOIN tb_module_group mg ON m.module_group_id = mg.module_group_id WHERE m.module_status = 1
                                   ) AS more_json GROUP BY module_group_id
                 ) AS json ) AS permission),'}') AS permission_json_str FROM tb_user_group ug WHERE ug.user_group_id = $user_group_id";
            $query = $dbcon->prepare($sql);
            $query->execute();
            if($query){
                return $query->fetch(PDO::FETCH_ASSOC)["permission_json_str"];
            }else{
                return "{}";
            }
        }
?>