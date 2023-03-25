<?php
    date_default_timezone_set("Asia/Vientiane");
    include_once 'main_controller.php';
    if(!empty($_GET['func'])){
        if($_GET['func'] == 'login'){
            login();
        }
    }
    function login(){
        $user_type = 1;
        if(isset($_POST['login'])){
            $login_success = false;
            require "../config.php";
            $username = $_POST['username'];
            $password = $_POST['password'];
			//$sqlcommand="SELECT GLOBAL group_concat_max_len=1048576;";
			//$dbcon->exec($sqlcommand);
            $sql = "select * from users where user_status = 1 and username = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($username));
            if($query->rowCount()==0){
                $data = array(
                    "error"=>true,
                    "message" => "ບໍ່ພົບຜູ້ໃຊ້ $username !",
                    "username" => $username,
                    "password" => $password
                );
                redirect('../login',$data);
            }else{
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                    if(password_verify($password,$row['password'])){
                        if($row['user_type']==1){
                            // $token_key = "user_".md5(time());
                            $login_success = true;
                            // $file = "../assets/json/app.json";
                            // $token = json_decode(file_get_contents($file),true);
                            // $token = array_merge($token,array(getMachineID()=>$token_key));
                            // file_put_contents($file, json_encode(array('user_token_key'=>$token_key),true));
                            // file_put_contents($file, json_encode($token,true));
                            $row["permission"]=get_permission($row["user_group_id"],$dbcon);
                            $_SESSION["user_admin_login"] = $row;
                        }else{
                            $login_success = true;
                            $user_type = 2;
                            $_SESSION['user_login'] = $row;
                        }
                    }
                }
                if(!$login_success){
                    $data = array(
                        "error"=>true,
                        "message" => "ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ !",
                        "username" => $username,
                        "password" => $password
                    );
                    redirect('../login',$data);
                }else{
                    if($user_type==1){
                        header("location:../template?page=home");
                    }else{
                        header("location:../main");
                    }
                }
            }
            
        }
    }
    function get_permission($user_group_id,$dbcon){
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
            $permission = json_decode($query->fetch(PDO::FETCH_ASSOC)["permission_json_str"]);
            $permissions = array();
            foreach($permission->permission as $data){
                foreach($data->module as $module){
                    $permissions[$module->module_code]=$module->allow;
                }
            }
            return $permissions;
            // return $query->fetch(PDO::FETCH_ASSOC)["permission_json_str"];
        }else{
            return [];
        }
    }
?>