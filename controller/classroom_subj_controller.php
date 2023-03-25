<?php
    date_default_timezone_set("Asia/Vientiane");
    require "config.php";
    include_once("controller/app_module.php");
    function add_subject($subj_name,$user_id){
        global $dbcon;
        $subj_name = input_data($subj_name);
        $user_id = input_data($user_id);
        //check duplicate
        $sql = "SELECT*FROM subjects WHERE subj_name = '$subj_name' AND status = 1";
        $subject = $dbcon->prepare($sql);
        $subject->execute();
        if($subject->rowCount()==0){
            $sql = "INSERT INTO subjects(subj_name,user_id,status) VALUES('$subj_name','$user_id',1)";
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
                    Swal.fire('<span class=phetsarath><?=$subj_name?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_subject($id){
        global $dbcon;
        $id = input_data($id);
        $sql = "DELETE FROM class_subject WHERE id=$id";
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
    function load_data($class_id){
        global $dbcon;
        $class_id = input_data($class_id);
        $sql = "SELECT cs.id,cs.subject_id,s.subj_name FROM class_subject cs INNER JOIN subjects s ON cs.subject_id = s.subj_id WHERE class_id=$class_id";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>