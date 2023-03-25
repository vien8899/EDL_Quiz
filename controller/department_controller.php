<?php
    date_default_timezone_set("Asia/Vientiane");
    require "config.php";
    include_once("controller/app_module.php");
    function add_department($dep_name,$user_id){
        global $dbcon;
        $dep_name = input_data($dep_name);
        $user_id = input_data($user_id);
        //check duplicate
        $sql = "SELECT*FROM departments WHERE dep_name = '$dep_name' AND dep_status = 1";
        $department = $dbcon->prepare($sql);
        $department->execute();
        if($department->rowCount()==0){
            $sql = "INSERT INTO departments(dep_name,user_id,dep_status) VALUES('$dep_name','$user_id',1)";
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
                    Swal.fire('<span class=phetsarath><?=$dep_name?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function update_department($dep_id,$dep_name,$user_id){
        global $dbcon;
        $dep_name = input_data($dep_name);
        $dep_id = input_data($dep_id);
        $user_id = input_data($user_id);
        $sql = "SELECT * FROM departments WHERE dep_name = '$dep_name' AND dep_status = 1";
        $department = $dbcon->prepare($sql);
        $department->execute();
        if($department->rowCount()==0){
            $sql = "UPDATE departments SET dep_name = '$dep_name', user_id = $user_id WHERE dep_id = $dep_id";
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
                    Swal.fire('<span class=phetsarath><?=$dep_name?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_department($dep_id){
        global $dbcon;
        $dep_id = input_data($dep_id);
        $sql = "UPDATE departments SET dep_status = 0 WHERE dep_id=$dep_id";
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
    function load_data(){
        global $dbcon;
        $sql = "SELECT dep_id,dep_name,user_id,dep_status,last_update,(SELECT COUNT(*) FROM tb_unit u WHERE (u.dep_id = d.dep_id) AND (unit_status=1)) 'number_of_dept' FROM departments d WHERE dep_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>