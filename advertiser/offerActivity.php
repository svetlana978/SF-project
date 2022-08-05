<?php
session_start();
include "../db/dbConnect.php";

mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");

$offer_name = $_POST['of_name'];

$query_current_activity = "SELECT `activity` FROM `offers` WHERE `offer_name` = '$offer_name'";
$activity = mysqli_query($link, $query_current_activity) or die(mysqli_error($link));
$a = current(mysqli_fetch_assoc($activity)); 

if ($a == 'YES') {
  $query_change_activity = "UPDATE `offers` SET `activity` = 'NO' WHERE `offer_name` = '$offer_name'";
  } else {
  $query_change_activity = "UPDATE `offers` SET `activity` = 'YES' WHERE `offer_name` = '$offer_name'";
  }

$result = mysqli_query($link, $query_change_activity) or die(mysqli_error($link));

print($a);
?>