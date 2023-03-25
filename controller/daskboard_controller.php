<?php
    function load_data(){
        require "config.php";
        $sql = "SELECT CONCAT('{\"users_num\":\"',
        (select COUNT(*) from users WHERE user_status = 1),'\",\"class_num\":\"',
        (SELECT COUNT(*) FROM class_rooms WHERE status = 1),'\",\"subj_num\":\"',
        (SELECT COUNT(*) FROM subjects WHERE status = 1),'\",\"quiz_num\":\"',
        (SELECT COUNT(*) FROM quiz WHERE status = 1),'\",\"question_num\":\"',
        (SELECT COUNT(*) FROM questions WHERE status = 1),'\",\"dep_data\":',
        (SELECT CONCAT('[', better_result, ']') AS best_result FROM
          (
            SELECT GROUP_CONCAT('{', dep_json, '}' SEPARATOR ',') AS better_result FROM
              (
              SELECT 
              CONCAT
              (
                '\"dep_name\":'   , '\"', dep_name   , '\"', ',' 
                '\"member\":', '\"', (SELECT COUNT(*) FROM users u WHERE u.user_status = 1),'\"'
              ) AS dep_json
              FROM departments d WHERE dep_status = 1
              ) AS more_json
          )AS yet_more_json
        ),'}')AS data";
        $query = $dbcon->prepare($sql);
        $query->execute();
        return $query;
    }
?>
