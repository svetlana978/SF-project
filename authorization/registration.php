<?php
session_start();
include "../db/dbConnect.php";

if(isset($_POST['submit']))
{
    $err = [];
    // проверяем логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    } 
    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    } 

    // проверяем, не существует ли пользователя с таким именем
    $log = $_POST['login'];
    $role = $_POST['role'];
    $query = "SELECT user_id FROM users WHERE login = '$log'";
    $result = mysqli_query($link, $query);
    
    if(mysqli_fetch_assoc($result) != NULL)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    } 
    if (!$role)
    {
        $err[] = 'Выберете роль';
    }
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
       
       if ($role =="advertiser")
        {
            $r = 'ad';
        }
        if ($role =="web-master")
        {
            $r = 'wm';
        }
       
        $password = md5(md5(trim($_POST['password']))); 
        mysqli_query($link,"INSERT INTO `users` (login, password, role) VALUES ('$log', '$password', '$r')");
         
        $query = "SELECT `user_id` FROM `users` WHERE `login`='$log'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        $user_id = current(mysqli_fetch_assoc($result));

        $_SESSION['auth'] = 1;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['login'] = $log; 
        $_SESSION['role'] = $r;
        header("Location: /index.php");
        exit();
    } else {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?> 

<form method="POST">
<input type="text" name="login" placeholder="Логин" required><br/>
<input type="password" name="password" placeholder="Пароль" required> <br>
<input type="radio" id="advertiser" name="role" value="advertiser">рекламодатель<br/>
<input type="radio"  id="web-master" name="role" value="web-master">веб-мастер<br/>
<input name="submit" type="submit" value="Зарегистрироваться"><br/>
<br/><a href="login.php"> Войти
</form>
