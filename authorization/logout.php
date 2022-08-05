<?php
session_start();
include "../db/dbConnect.php";

if(isset($_COOKIE["password_cookie_token"])){
    $query = "UPDATE `users` SET `cookie_token` = '' WHERE `login` = '".$_SESSION["login"]."'";
   
    $update_password_cookie_token = mysqli_query($link, $query);
     
    if(!$update_password_cookie_token){
        echo "Ошибка ".$mysqli->error();
    }else{
        setcookie("cookie_token", "", time() - 3600);
    }
}
$_SESSION['auth'] = 0;
$_SESSION['user_id'] = '';

// Удаляем куки
setcookie("id", "", time() - 3600*24*30*12, "/");
header("Location: /index.php"); exit; 
?>
