<?php  
session_start();
include "../db/dbConnect.php";

mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");


$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']  .htmlspecialchars($_SERVER['REQUEST_URI']);

$query = "SELECT `offer_name` FROM `offers` WHERE `offer_url` = '$url'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
$offer_name = current(mysqli_fetch_assoc($result)); 

$file="../logi/log.txt";    //куда пишем логи
// $col_zap=4999;        //строк в файле не более

$l_cash='';
$fh=fopen($file,"a+");
flock($fh,LOCK_EX);
fseek($fh,0);
while (!feof($fh)) $l_cash.= fread($fh,8192);
$message=explode("\n",$l_cash);
// while(count($message)>$col_zap) array_shift($message);
$l_cash=implode("\n",$message);
$l_cash.=date("H:i:s")."|" . date("d.m.y") ."|" . $url."|". $offer_name . "\n";
ftruncate($fh,0);
fwrite($fh,$l_cash);
flock($fh,LOCK_UN);
fclose($fh);

    
?>