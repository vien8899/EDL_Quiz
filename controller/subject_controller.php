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
    function update_subject($subj_id,$subj_name,$user_id){
        global $dbcon;
        $subj_name = input_data($subj_name);
        $subj_id = input_data($subj_id);
        $user_id = input_data($user_id);
        $sql = "SELECT*FROM subjects WHERE subj_name = '$subj_name' AND status = 1";
        $subject = $dbcon->prepare($sql);
        $subject->execute();
        if($subject->rowCount()==0){
            $sql = "UPDATE subjects SET subj_name = '$subj_name', user_id = $user_id WHERE subj_id = $subj_id";
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
                    Swal.fire('<span class=phetsarath><?=$subj_name?> ມີແລ້ວຢູ່ໃນຖານຂໍ້ມູນແລ້ວ!</span>', '', 'warning')
                </script>
            <?php
        }
    }
    function del_subject($subj_id){
        global $dbcon;
        $subj_id = input_data($subj_id);
        $sql = "UPDATE subjects SET status = 0 WHERE subj_id=$subj_id";
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
    function load_subject(){
        global $dbcon;
        $sql = "SELECT subj_id,subj_name,user_id,(SELECT COUNT(*) FROM questions WHERE questions.subj_id = subjects.subj_id) AS ques_num FROM subjects WHERE status=1;";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>