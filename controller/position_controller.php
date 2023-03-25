<?php
    date_default_timezone_set("Asia/Vientiane");
    function get_position(){
        require "config.php";
        $sql = "SELECT * FROM tb_position WHERE position_status=1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function add_position($position_des){
        require "config.php";
        $sql = "SELECT*FROM tb_position WHERE position_des=?";
        $position = $dbcon->prepare($sql);
        $position->execute(array($position_des));
        if($position->rowCount()==0){
            $sql = "INSERT INTO tb_position(position_des) VALUES (?)";
            $query = $dbcon->prepare($sql);
            $query->execute(array($position_des));
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
                    Swal.fire('<span class=phetsarath><?=$position_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function update_position($position_id,$position_des){
        require "config.php";
        $sql = "SELECT*FROM tb_position WHERE position_des=?";
        $position = $dbcon->prepare($sql);
        $position->execute(array($position_des));
        if($position->rowCount()==0){
            $sql = "UPDATE tb_position SET position_des = ? WHERE position_id = ?";
            $query = $dbcon->prepare($sql);
            $query->execute(array($position_des, $position_id));
            if($query){
                ?>
                    <script>
                        Swal.fire('<span class=phetsarath>ແກ້ໄຂຂໍ້ມູນສໍາເລັດ!</span>', '', 'success')
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
                    Swal.fire('<span class=phetsarath><?=$position_des?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_position($position_id){
        require "config.php";
        $sql = "UPDATE tb_position SET position_status = 0 WHERE position_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($position_id));
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