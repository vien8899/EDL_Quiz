SELECT CONCAT('{"user_group_id":2',',"user_group_des":"',ug.group_des,'","permission":',
             (SELECT CONCAT('[',GROUP_CONCAT('{', permission_data, '}' SEPARATOR ','),']') AS module FROM
             (SELECT CONCAT(
                 '"module_group_id":"',module_group_id,
                 '","module_group_des":"',module_group_des,
                 '","module":',module
             ) AS permission_data  FROM 
              (
                  SELECT module_group_id,module_group_des, CONCAT('[',GROUP_CONCAT('{', module_json, '}' SEPARATOR ','),']') AS module FROM
                                (
                                SELECT m.module_group_id,mg.module_group_des,
                                CONCAT
                                (
                                    '"module_id":"',m.module_id,
                                    '","module_code":"',m.module_code,
                                    '","module_des":"',m.module_des,
                                    '","allow":',
                                    (SELECT COUNT(*) FROM tb_group_permission gp WHERE gp.module_id = m.module_id AND gp.user_group_id = 2)
                                ) AS module_json
                                FROM tb_module m INNER JOIN tb_module_group mg ON m.module_group_id = mg.module_group_id WHERE m.module_status = 1
                                ) AS more_json GROUP BY module_group_id
              ) AS json ) AS permission),'}'
             )
FROM tb_user_group ug WHERE ug.user_group_id = 2


-- set max len for group_concat
SET GLOBAL group_concat_max_len=1048576;



