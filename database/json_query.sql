SELECT CONCAT('[', better_result, ']') AS best_result FROM
(
SELECT GROUP_CONCAT('{', subj_json, '}' SEPARATOR ',') AS better_result FROM
(
SELECT 
    CONCAT
    (
      '"subj_name":'   , '"', subj_name   , '"', ',' 
      '"user_id":', '"', user_id,'"'
    ) AS subj_json
  FROM subjects
) AS more_json
) AS yet_more_json;




SELECT CONCAT('"users_num":"',
              (select COUNT(*) from users WHERE status = 1),'","class_num":"',
              (SELECT COUNT(*) FROM class_rooms WHERE status = 1),'","subj_num":"',
              (SELECT COUNT(*) FROM subjects WHERE status = 1),'","quiz_num":"',
              (SELECT COUNT(*) FROM quiz WHERE status = 1),'","question_num":"',
              (SELECT COUNT(*) FROM questions WHERE status = 1),'","dep_data":',
              
              (SELECT CONCAT('[', better_result, ']') AS best_result FROM
                (
                  SELECT GROUP_CONCAT('{', dep_json, '}' SEPARATOR ',') AS better_result FROM
                    (
                    SELECT 
                    CONCAT
                    (
                      '"dep_name":'   , '"', dep_name   , '"', ',' 
                      '"member":', '"', (SELECT COUNT(*) FROM users u WHERE u.dep_id = d.dep_id AND u.status = 1),'"'
                    ) AS dep_json
                    FROM departments d WHERE dep_status = 1
                    ) AS more_json
                )AS yet_more_json
             )
             
             )