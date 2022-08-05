<?php

$file = $_SERVER['DOCUMENT_ROOT'] . "/logi/log.txt";  

$log_string = file_get_contents($file);
$message=explode("\n",$log_string);
$arr = [];
array_pop($message);

foreach ($message as $key => $value) {
    $arr[] = explode("|",$value);
}

foreach ($arr as $key =>$value) {
    $of_nam[$key] = $value[3];
    
}

$count_day = 0;
$count_month = 0;
$count_year = 0;
$count = [];
foreach($of_nam as $key =>$value1) {
    foreach($arr as $key =>$value2) {
         if ($value1 == $value2[3]) {
            $date[$key] = explode(".",$value2[1]);
                if($date[$key][2] == date("y")) {
                    $count_year += 1;
                    if($date[$key][1] == date("m")) {
                        $count_month += 1;
                        if($date[$key][0] == date("d")) {
                            $count_day += 1;
                        }
                    }
                }
            }    
    }
    $count[$value1] = ["day" => $count_day, "month" => $count_month, "year" => $count_year];
        
    $count_day = 0;
    $count_month = 0;
    $count_year = 0;
}
