<?php
    date_default_timezone_set("Asia/Vientiane");
    session_start();
    $sessionlifetime = 60; //set active timeout (mn)
    
    if(isset($_SESSION["timeLasetdActive"])){
        $seclogin = (time()-$_SESSION["timeLasetdActive"])/60;
            //check active time
        if($seclogin>$sessionlifetime){
            //goto logout page
            header("location:logout.php");
            exit;
        }else{
            $_SESSION["timeLasetdActive"] = time();
        }
    }else{
        $_SESSION["timeLasetdActive"] = time();
    }
    function redirect($url,$data=[]){
        if($data == []){
            unset($_SESSION['login_data']);
        }else{
            $_SESSION['login_data'] = $data;
        }
        header("Location: $url");
    }
    function getMachineID($salt = "") {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
            if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
            $output = shell_exec("diskpart /s ".$temp);
            $lines = explode("\n",$output);
            $result = array_filter($lines,function($line) {
                return stripos($line,"ID:")!==false;
            });
            if(count($result)>0) {
                $result = array_values($result);
                $result = array_shift($result);
                $result = explode(":",$result);
                $result = trim(end($result));       
            } else $result = $output;       
        } else {
            $result = shell_exec("blkid -o value -s UUID");  
            if(stripos($result,"blkid")!==false) {
                $result = $_SERVER['HTTP_HOST'];
            }
        }   
        return md5($salt.md5($result));
    }
?>