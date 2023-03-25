<?php
    $row = 21;
    echo "row: $row <br>";
    $mod = $row%10;
    echo "mod: $mod <br>";
    echo "ceil: ".ceil($row/10);
    echo "<br>";

//Generate a random string.
$token_key = openssl_random_pseudo_bytes(16);

//Convert the binary data into hexadecimal representation.
$token_key = bin2hex($token_key);

//Print it out for example purposes.
echo $token_key."<br>";

$file = "assets/json/app.json";
$token = json_decode(file_get_contents($file),true);
$token = array_merge($token,array('tik'=>$token_key));
print_r($token);
unset($token['tik']);
print_r($token);



// $mac = system('arp -an');
// echo $mac;
function UniqueMachineID($salt = "") {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
        if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
        $output = shell_exec("diskpart /s ".$temp);
        $lines = explode("\n",$output);
        $result = array_filter($lines,function($line) {
            return stripos($line,"ID:")!==false;
        });
        if(count($result)>0) {
            $result = array_shift(array_values($result));
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


echo UniqueMachineID();

?>
<a href="location.href=this.href+&page=5">test</a>

