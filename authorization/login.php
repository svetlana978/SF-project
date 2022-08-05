<?php
session_start();
include "../db/dbConnect.php";

$_SESSION['auth']=0;
$token = hash('gost-crypto', random_int(0,999999));
$_SESSION["CSRF"] = $token;

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
    //Начинаем проверку логина и пароля в БД
    $log = $_POST['login'];
    $query = mysqli_query($link,"SELECT * FROM `users` WHERE `login`='$log'");
    $data = mysqli_fetch_assoc($query); 
    
    // Сравниваем пароли
    if($data['password'] === md5(md5($_POST['password'])))
    {
        $hash = md5(generateCode(10));

        if(isset($_POST["remember_me"])){
        
            $password_cookie_token = md5($array_user_data["id"].$password.time());
            $update_password_cookie_token = mysqli_query($link, "UPDATE users SET cookie_token='".$password_cookie_token."' WHERE login = '".$log."'");
            
            if(!$update_password_cookie_token){
                $_SESSION["error_messages"] = "<p class='mesage_error' >Ошибка функционала 'запомнить меня'</p>";
                    
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /index.php");
            
                //Останавливаем скрипт
                exit();
            }

            setcookie("password_cookie_token", $password_cookie_token, time() + (1000 * 60 * 60 * 24 * 30));
        } else {
            //Если галочка "запомнить меня" небыла поставлена, то мы удаляем куки
            if(isset($_COOKIE["password_cookie_token"])){
                $update_password_cookie_token = mysqli_query($link, "UPDATE users SET cookie_token = '' WHERE login = '".$log."'");            
                setcookie("password_cookie_token", "", time() - 3600);
            }
                
        }

        $_SESSION['auth'] = 1;
        $_SESSION['user_id'] = $data['user_id']; 
        $_SESSION['login'] = $log;
        $_SESSION['role'] = $data['role'];
        header("Location: /index.php"); exit();
    } else {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>

<form method="post" action="">
<input type="text" name="login" placeholder="Логин" required><br/>
<input type="password" name="password" placeholder="Пароль" required> <br/>
<input type="hidden" name="token" value="<?=$token?>"> 
<label>
    <input type="checkbox" name="remember_me"> Запомнить меня
</label> <br/>
<input type="submit" name="submit" value="Войти"><br/><br/>
<a href="registration.php"> Зарегистрироваться
</form>