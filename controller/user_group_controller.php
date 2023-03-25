<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_user_group_data(){
        require "config.php";
        $sql = "SELECT user_group_id,group_des,user_group_status,read_only,(SELECT COUNT(*) FROM users u WHERE u.user_group_id = ug.user_group_id)'member' FROM tb_user_group ug WHERE user_group_status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function add_user_group($group_des){
        require "config.php";
        $sql = "SELECT * FROM tb_user_group WHERE group_des=? AND user_group_status = 1";
        $unit = $dbcon->prepare($sql);
        $unit->execute(array($group_des));
        if($unit->rowCount()==0){
            $sql = "INSERT INTO tb_user_group(group_des) VALUES (?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($group_des));
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
                    Swal.fire('<span class=phetsarath><?=$group_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function update_user_group($user_group_id,$user_group_des){
        require "config.php";
        $sql = "SELECT * FROM tb_user_group WHERE group_des=? AND user_group_status = 1";
        $unit = $dbcon->prepare($sql);
        $unit->execute(array($user_group_des));
        if($unit->rowCount()==0){
            $sql = "UPDATE tb_user_group SET group_des = ? WHERE user_group_id =? ";
            $query = $dbcon->prepare($sql);
            $query->execute(array($user_group_des,$user_group_id));
            if($query){
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ແກ້ໄຂຂໍມູນສໍາເລັດ!</span>', '', 'success')
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>', '', 'error')
                    </script>
                <?php 
            }
        }else{
            ?>
                <script>
                    Swal.fire('<span class=phetsarath><?=$user_group_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_user_group($user_group_id){
        require "config.php";
        $sql = "UPDATE tb_user_group SET user_group_status = 0 WHERE user_group_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_group_id));
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
    // function get_dep_data(){
    //     require "config.php";
    //     $sql = "SELECT dep_id,dep_name FROM departments WHERE dep_status=1";
    //     $query = $dbcon->prepare($sql);
    //     $query->execute();
    //     return $query;
    // }
?>