<?php
    date_default_timezone_set("Asia/Vientiane");
    require "config.php";
    include_once("controller/app_module.php");
    function add_class($class_des,$user_id){
        global $dbcon;
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
        global $dbcon;
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
    function del_classroom($class_id){
        global $dbcon;
        $class_id = input_data($class_id);
        $sql = "UPDATE class_rooms SET status = 0 WHERE id=$class_id";
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
        $sql = "SELECT id,class_des,user_id,(SELECT COUNT(*) FROM class_members mb WHERE mb.class_id = cr.id)'member',(SELECT COUNT(*) FROM class_tc ct WHERE ct.class_id = cr.id)'tc',
        (SELECT COUNT(*) FROM class_quiz_prepare cp WHERE cp.class_id = cr.id)quiz_num FROM class_rooms cr WHERE status=1 ORDER BY id DESC";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>