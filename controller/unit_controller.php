<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_unit_data($dep_id){
        require "config.php";
        if($dep_id==0){
            $sql = "SELECT unit_id,unit_des,d.dep_name,d.dep_id, 
			(SELECT COUNT(*) FROM users WHERE(unit_id=u.unit_id) AND (user_status=1)) AS number_of_staff
			FROM tb_unit u INNER JOIN departments d ON u.dep_id = d.dep_id WHERE unit_status = 1";
            $query = $dbcon->prepare($sql);
            $query->execute();
            return $query;
        }else{
            $sql = "SELECT unit_id,unit_des,d.dep_name,d.dep_id, 
			(SELECT COUNT(*) FROM users WHERE(unit_id=u.unit_id) AND (user_status=1)) AS number_of_staff
			FROM tb_unit u INNER JOIN departments d ON u.dep_id = d.dep_id WHERE unit_status = 1 AND u.dep_id = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($dep_id));
            return $query;
        }
    }
    function add_unit($dep_id, $unit_des){
        require "config.php";
        $sql = "SELECT*FROM tb_unit WHERE unit_des = ? AND dep_id = ? AND unit_status = 1";
        $unit = $dbcon->prepare($sql);
        $unit->execute(array($unit_des, $dep_id));
        if($unit->rowCount()==0){
            $sql = "INSERT INTO tb_unit(dep_id, unit_des) VALUES (?,?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($dep_id, $unit_des));
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
                    Swal.fire('<span class=phetsarath><?=$unit_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function update_uint($unit_id,$unit_des,$dep_id){
        require "config.php";
        $sql = "SELECT*FROM tb_unit WHERE unit_des = ? AND dep_id = ? AND unit_status = 1";
        $unit = $dbcon->prepare($sql);
        $unit->execute(array($unit_des, $dep_id));
        if($unit->rowCount()==0){
            $sql = "UPDATE tb_unit SET unit_des=? , dep_id=? WHERE unit_id=?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($unit_des,$dep_id,$unit_id));
            if($query){
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນສໍາເລັດ!</span>', '', 'success')
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ການແກ້ໄຂຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                    </script>
                <?php 
            }
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath><?=$unit_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_unit($unit_id){
        require "config.php";
        $sql = "UPDATE tb_unit SET unit_status = 0 WHERE unit_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($unit_id));
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
    function get_dep_data(){
        require "config.php";
        $sql = "SELECT dep_id,dep_name FROM departments WHERE dep_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>