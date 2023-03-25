<?php
    date_default_timezone_set("Asia/Vientiane");
    function load_score_report($filter_data){
		require "config.php";
        include_once("controller/app_module.php");
		
		$sql="SELECT IFNULL(MAX(start_time), '2022-01-01') AS max_test_date FROM test_quiz ";
		$query = $dbcon->prepare($sql);
        $query->execute();
		$row=$query->fetchAll(PDO::FETCH_ASSOC)[0];
		$max_test_date = $row['max_test_date'];
		//echo $max_test_date;
		
		
        $filter = "";
        if(count($filter_data)!=0){
            if($filter_data['class_id']!=0){
                $filter = " AND cq.class_id=".$filter_data['class_id'];
            }
            if($filter_data['quiz_id']!=0){
                $filter .= " AND cq.quiz_id=".$filter_data['quiz_id'];
            }
            if($filter_data['exam_date']!=''){
                $filter .= " AND tq.start_time BETWEEN '".date("Y-m-d", strtotime($filter_data['exam_date']))." 00:00' AND '".date("Y-m-d", strtotime($filter_data['exam_date']))." 23:59'";
            }
            if($filter_data['remark']!=''){
                $filter .=" AND cq.remark LIKE '%".$filter_data['remark']."%'";
            }
        }else{
			$filter = " AND tq.start_time BETWEEN '".$max_test_date." 00:00' AND '".$max_test_date." 23:59'";
			$filter_data['exam_date']=$max_test_date;
		}
		//echo $filter;
        
        $sql = "SELECT tq.test_id,cq.class_id,test_number,tq.quiz_title,tq.user_id, u.fullname,
        u.gender,u.user_code,u.technical_knowledge,u.degree,u.position_id,
        p.position_des,u.unit_id,un.unit_des,u.dep_id,d.dep_name,tq.start_time,
        tq.submit_time,cq.remark,(SELECT SUM(point) FROM answer WHERE test_number = tq.test_number)'point',
        (SELECT SUM(full_point) FROM answer WHERE test_number = tq.test_number)'full_point' FROM test_quiz tq 
        INNER JOIN users u ON tq.user_id = u.id 
        INNER JOIN class_quiz cq ON tq.class_quiz_id = cq.class_quiz_id 
        LEFT JOIN tb_position p ON u.position_id = p.position_id
        LEFT JOIN tb_unit un ON u.unit_id = un.unit_id
        INNER JOIN departments d ON u.dep_id = d.dep_id WHERE (tq.status = 2 OR 
        (SELECT COUNT(*) FROM answer an WHERE an.test_number=tq.test_number AND an.question_type=2) = 0) ".$filter;
        // return $sql;
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_class_data(){
        require "config.php";
        $sql = "SELECT*FROM class_rooms WHERE status=1;";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
    function get_quiz($class_id){
        require "config.php";
        if($class_id==0){
            $sql = "SELECT q.quiz_id,q.quiz_title FROM class_quiz cq INNER JOIN class_rooms c ON cq.class_id = c.id INNER JOIN quiz q ON cq.quiz_id = q.quiz_id GROUP BY q.quiz_id,q.quiz_title";
        }else{
            $sql = "SELECT q.quiz_id,q.quiz_title FROM class_quiz cq INNER JOIN class_rooms c ON cq.class_id = c.id INNER JOIN quiz q ON cq.quiz_id = q.quiz_id WHERE c.id = '$class_id' GROUP BY q.quiz_id,q.quiz_title";
        }
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }

?>