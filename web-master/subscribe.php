<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/db/dbConnect.php";

mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");

$webMaster_id = $_SESSION['user_id'];
$offer_name = $_POST['of_name'];
$link_cost = $_POST['cost'];

$query_subscr_offer = "SELECT * FROM `offers` WHERE `offer_name` = '$offer_name'";
$subscription = mysqli_query($link, $query_subscr_offer) or die(mysqli_error($link));

foreach($subscription as $row){
  $offer_id = $row['id'];
  $id_owner = $row['id_owner'];
  $offer_cost = $row['cost'];
}


if ($link_cost == $offer_cost){
  $query_subscr_offer_counter = "UPDATE `offers` SET `subscribers` = `subscribers` + 1 WHERE `offer_name` = '$offer_name'";
  $subscription_counter = mysqli_query($link, $query_subscr_offer_counter) or die(mysqli_error($link));
  
  $query_insert_subscr = "INSERT INTO `subscriptions` (offer_id, webMaster_id, owner_id, link_cost) VALUES ('$offer_id', '$webMaster_id', '$id_owner', '$link_cost')";
  
  $result_insert_subscr = mysqli_query($link, $query_insert_subscr) or die(mysqli_error($link));
} else {
  echo '1';
}
?>