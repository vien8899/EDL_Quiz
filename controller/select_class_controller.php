<?php
    date_default_timezone_set("Asia/Vientiane");
    require "../config.php";
    include_once("app_module.php");
    if(isset($_POST['load_subject'])){
        $subject_data = json_decode($_POST['load_subject']);
        $class_des_param = "&class_des=" .$subject_data->class_des;
        $class_id_param = "&class_id=" .$subject_data->class_id;
        $subj_id_list = "";
        foreach($subject_data->selected_subjected as $subj_id){
            $subj_id_list .= ",$subj_id"; 
        }
        $subj_id_list .= ")";
        $subj_id = "(".substr($subj_id_list,1,strlen($subj_id_list)-1);
        $sql = "INSERT INTO class_subject (class_id,subject_id) SELECT $subject_data->class_id,subj_id FROM subjects WHERE subj_id IN $subj_id";
        $query = $dbcon->exec($sql);
        if($query){
            echo "Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_subject".$class_id_param.$class_des_param."'}});";
        }else{
            echo "Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'})";
        }
        
    }
?>