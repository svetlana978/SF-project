<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/db/dbConnect.php";

mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");

$offer_id = $_POST['of_id'];
$webMaster_id = $_SESSION['user_id'];

$query_change_activity = "DELETE FROM `subscriptions` WHERE `offer_id` = '$offer_id'";
$result = mysqli_query($link, $query_change_activity) or die(mysqli_error($link));

$query_subscr_offer_counter = "UPDATE `offers` SET `subscribers` = `subscribers` - 1 WHERE `id` = '$offer_id'";
$subscription_counter = mysqli_query($link, $query_subscr_offer_counter) or die(mysqli_error($link));

?>