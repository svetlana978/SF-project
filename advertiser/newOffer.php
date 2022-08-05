<?php 
session_start();
include "../db/dbConnect.php";

mysqli_report(MYSQLI_REPORT_ERROR ^ MYSQLI_REPORT_STRICT);
mysqli_query($link, "SET NAMES 'utf8'");

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
} 

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $url = $_POST['url'];
    $theme = $_POST['theme'];
    $id_owner = $_SESSION['user_id'];
   
    $query_check = mysqli_query($link,"SELECT * FROM `offers` WHERE `offer_name`='$name'");
    $result = mysqli_fetch_assoc($query_check); 
    
    if($result != NULL) { 
        print('This offer name is already exists, choose another name');
    } else {  
        $query = "INSERT INTO `offers` (offer_name, cost, offer_url, theme, id_owner, subscribers, activity) VALUES ('$name', '$cost', '$url', '$theme', '$id_owner', 0, 'YES')";

        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        header("Location: ../index.php");
    }
}
?>


<form method="post">
    <p>Имя offer-а: 
        <input type="text" name="name" required/>
    </p>
    <p>Стоимость перехода: 
       <input type="number" name="cost" required/>
    </p>
    <p>Целевой URL: 
        <input type="text" name="url" required/>
    </p>
    <p>Тема сайта: 
        <input type="text" name="theme" required/>
    </p>
    <input type="submit" name="submit" value="Создать новый offer">
    <br>
    <a href="../index.php"> Назад
</form>
     
