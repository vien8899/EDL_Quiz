<?php
    date_default_timezone_set("Asia/Vientiane");
    function input_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data,ENT_QUOTES, 'UTF-8');
        return $data;
    }
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
    function decode($text){
        $text = str_replace('#amp;','&',$text);
        $text = str_replace('#quot;','"',$text);
        $text = str_replace('#plus;','+',$text);
        $text = str_replace('#039;',"'",$text);
        return $text;
    }
    function encode($text){
        $text = str_replace('&','#amp;',$text);
        $text = str_replace('"','#quot;',$text);
        $text = str_replace('+','#plus;',$text);
        $text = str_replace("'",'#039;',$text);
        return $text;
    }
?>