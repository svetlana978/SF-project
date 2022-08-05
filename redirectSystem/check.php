<?php
include "../db/dbConnect.php";

$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];   
$str = strval($url);

// получаем id веб-мастера и id предложения
$utm_source = "utm_source=";
$utm_offer_id = "offer_id=";
$arr = explode($utm_source, $str);

$webMast_arr = explode("&", $arr[1]); 
$offerIdd_arr = explode($utm_offer_id, $str);

$webMaster_id = $webMast_arr[0];
$of_id= $offerIdd_arr[1];

  
mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");

$query_subscr_check = "SELECT `index` FROM `subscriptions` WHERE `offer_id` = '$of_id' AND `webMaster_id`='$webMaster_id'";
$res = mysqli_query($link, $query_subscr_check) or die(mysqli_error($link));
$result = mysqli_fetch_array($res);

if($result != NULL) {      
  $query_subscr_check = "SELECT `offer_url` FROM `offers` WHERE `id` = '$of_id'";
  $offer_url = mysqli_query($link, $query_subscr_check) or die(mysqli_error($link));
  foreach(mysqli_fetch_assoc($offer_url) as $row){
    $url = $row;
  }

  header("Location: $url");  
} else {  
  header("Location: /404.html");
}

?>
