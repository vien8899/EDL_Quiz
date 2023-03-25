<?php
    date_default_timezone_set("Asia/Vientiane");
    if(isset($_POST['close_exam'])){
        require "../config.php";
        include_once("app_module.php");
        $data = json_decode($_POST['close_exam']);
        $class_id = $data->class_id;
        $user_id = $data->user_id;
        $quiz_id = $data->quiz_id;
        $sql = "UPDATE class_quiz SET user_id=?,status=0,end_time = '".date("Y-m-d h:m")."' WHERE class_id=? AND quiz_id=?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($user_id,$class_id,$quiz_id));
        if($query){
            echo '{"success":true}';
        }else{
            echo '{"success":false}';
        }
        // echo $sql;
    }
    function open_test($quiz_id,$start_time,$end_time,$user_id,$class_id,$remark){
        require "config.php";
        $end_time = ($end_time=="")?NULL:$end_time;
        $sql = "INSERT INTO class_quiz(quiz_id, class_id, user_id, start_time, end_time,remark) VALUES (?,?,?,?,?,?)";
        $query = $dbcon->prepare($sql);
        $query->execute(array($quiz_id,$class_id,$user_id,$start_time,$end_time,$remark));
        if($query){
            echo "<script>Swal.fire({icon:'success',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>'});</script>";
        }else{
            echo "<script>Swal.fire({icon:'error',html:'<span class=phetsarath>ບັນທຶກຂໍ້ມູນບໍ່ສໍາເລັດ<br>ເກີດຂໍ້ຜິດພາດລະຫວ່າງການບັນທຶກ!</span>'});</script>";
        }
    }
    function load_classroom(){
        require "config.php";
        // $sql = "SELECT c.id,c.class_des,COUNT(quiz_id)'quiz_num',cs.class_id FROM quiz q INNER JOIN class_subject cs ON q.subj_id = cs.subject_id INNER JOIN class_rooms c 
        // ON cs.class_id = c.id WHERE c.status = 1 GROUP BY c.id,c.class_des,cs.class_id";
        $sql = "SELECT c.id'class_id',c.class_des,COUNT(cp.quiz_id)'quiz_num' FROM class_quiz_prepare cp INNER JOIN class_rooms c ON cp.class_id = c.id
        GROUP BY c.id, c.class_des";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function load_quiz($class_id){
        require "config.php";
        $sql = "SELECT `quiz_id`,`quiz_title`,`subj_id`,`quiz_caption`,`quiz_num`,`quiz_time`,`open_test`,`user_id`,`last_update`,`status`,
        IF(IFNULL((SELECT COUNT(*) from class_quiz cq WHERE cq.class_id = cs.class_id AND cq.quiz_id = q.quiz_id),0)=0,0,
        IF ((SELECT start_time FROM class_quiz cq WHERE cq.class_id = cs.class_id AND cq.quiz_id = q.quiz_id) <= NOW(),
            IF(ISNULL((SELECT end_time FROM class_quiz cq WHERE cq.class_id = cs.class_id AND cq.quiz_id = q.quiz_id)),1,
               IF((SELECT end_time FROM class_quiz cq WHERE cq.class_id AND cq.quiz_id = q.quiz_id)>NOW(),1,0)
            )
            ,0)
        )'is_open'
        FROM quiz q INNER JOIN class_subject cs ON q.subj_id = cs.subject_id WHERE cs.class_id = ? AND q.status>0";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_id));
        return $query;
    }
    function load_quiz_by_user($user_id){
        require "config.php";
        // $sql = "SELECT cq.class_quiz_id,cq.quiz_id,q.quiz_title,q.subj_id,s.subj_name,q.quiz_caption,q.quiz_num,q.quiz_time,
        // IF(((SELECT COUNT(*) FROM test_quiz tz WHERE tz.user_id='$user_id')=0),1,
        //    IF(((SELECT tz.status FROM test_quiz tz WHERE tz.user_id='$user_id' ORDER BY tz.test_id DESC LIMIT 1)=3),1,0)
        //   )can_test
        // FROM class_quiz cq INNER JOIN quiz q ON cq.quiz_id = q.quiz_id INNER JOIN subjects s ON q.subj_id = s.subj_id 
        // WHERE cq.class_id IN (SELECT class_id FROM class_members cm WHERE cm.user_id='$user_id')";
        // $sql = "SELECT cq.class_quiz_id,cq.quiz_id,q.quiz_title,q.subj_id,s.subj_name,q.quiz_caption,q.quiz_num,q.quiz_time,(
        //     CASE WHEN (SELECT COUNT(*) FROM test_quiz tq WHERE tq.class_quiz_id=cq.class_quiz_id AND tq.user_id = '".$user_id."')=0 THEN 1
        //     WHEN (SELECT COUNT(*) FROM test_quiz tq WHERE tq.class_quiz_id=cq.class_quiz_id AND tq.user_id = '".$user_id."')>0
        //     THEN 0 END)'can_test',(CASE WHEN cq.start_time <= now() THEN 1 ELSE 0 END
        //     )'availabled' FROM class_quiz cq INNER JOIN quiz q ON cq.quiz_id = q.quiz_id INNER JOIN subjects s ON q.subj_id = s.subj_id WHERE cq.class_id 
        //     IN (SELECT class_id FROM class_members cm WHERE cm.user_id='".$user_id."') AND (cq.end_time>now() OR cq.end_time IS NULL) AND cq.status = 1";
        $sql = "SELECT cq.class_quiz_id,cq.quiz_id,q.quiz_title,q.quiz_caption,q.quiz_num,q.quiz_time,
        (	CASE WHEN (SELECT COUNT(*) FROM test_quiz tq WHERE tq.class_quiz_id=cq.class_quiz_id AND tq.user_id = '".$user_id."')=0 
                 THEN 1
                WHEN (SELECT COUNT(*) FROM test_quiz tq WHERE tq.class_quiz_id=cq.class_quiz_id AND tq.user_id = '".$user_id."')>0
                THEN 0
             END)'can_test',
        (	CASE WHEN cq.start_time <= now() 
             THEN 1 
             ELSE 0 
             END )'availabled' 
        FROM class_quiz cq INNER JOIN quiz q ON cq.quiz_id = q.quiz_id WHERE cq.class_id IN (SELECT class_id FROM class_members cm WHERE cm.user_id='".$user_id."') AND (cq.end_time>now() OR cq.end_time IS NULL) AND cq.status = 1";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_quiz_data($class_id){
        require "config.php";
        $sql = "SELECT q.quiz_id, q.quiz_title,q.quiz_time,
        (
            CASE WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id)=0
                THEN 0 
            ELSE 
                CASE WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id AND cq.status=1 AND cq.class_id = cp.class_id)=0
                    THEN 0 
                    WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id AND (cq.end_time >= now() OR cq.end_time IS NULL) AND cq.status=1 AND cq.class_id = cp.class_id)>0
                    THEN 1 
                    ELSE 0 
                END 
            END) AS is_open FROM class_quiz_prepare cp INNER JOIN quiz q ON cp.quiz_id = q.quiz_id WHERE q.status = 1 AND cp.class_id = ?";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_id));
        return $query;
    }
    function load_data($class_id){
        require "config.php";
        $sql = "SELECT CONCAT('[',json_data,']') AS json_str FROM (
            SELECT GROUP_CONCAT('{', data, '}' SEPARATOR ',') AS json_data FROM (
            SELECT CONCAT('\"subj_id\":\"',subj_id,'\",\"subj_name\":\"',subj_name,'\",\"quiz_data\":',
                          IFNULL((SELECT CONCAT('[', better_result, ']') AS best_result FROM
                            (
                              SELECT GROUP_CONCAT('{', quiz_json, '}' SEPARATOR ',') AS better_result, subj_id FROM
                                (
                                SELECT 
                                CONCAT
                                (
                                    '\"quiz_id\":\"', q.quiz_id   , '\",\"quiz_title\":\"', q.quiz_title   , '\",\"quiz_time\":\"',q.quiz_time,'\",\"is_open\":\"',
                                    (
                                        CASE WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id)=0
                                        THEN
                                        0
                                        ELSE
                                            CASE WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id AND cq.status=1)=0
                                            THEN
                                            0
                                            WHEN (SELECT COUNT(*) FROM class_quiz cq WHERE cq.quiz_id = q.quiz_id AND (cq.end_time >= now() OR cq.end_time IS NULL) AND cq.status=1)>0
                                            THEN
                                            1
                                            ELSE
                                            0
                                            END
                                        END
                                    ),'\"'
                                ) AS quiz_json, q.subj_id
                                FROM quiz q WHERE q.status = 1
                                ) AS more_json
                            )AS yet_more_json WHERE subj_id = s.subj_id
                         ),'[]')) AS data FROM subjects s WHERE s.subj_id IN (SELECT subject_id'subj_id' FROM class_subject cs WHERE cs.class_id = ?)
            
            ) as json_final) AS res_data";
        $query = $dbcon->prepare($sql);
        $query->execute(array($class_id));
        return $query;
    }
?>