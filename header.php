<header>
<div class="row">
    <div class="col-4 col-offset-3 ">
    <?php if ($_SESSION['auth'] == 0) { ?>
        <a href='authorization/login.php'>Вход
        <?php } else { ?>
        <div><?php echo "Добро пожаловать, " . $_SESSION['login'] . "!"; ?></div>
        <a href="authorization/logout.php">Выход</a>
        <?php }  ?>
    </div>
</div>
</header>