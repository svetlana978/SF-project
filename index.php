<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="web-master/styleLink.css">
  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <title>SF-AdTech</title>
</head>

<body>
<?php include 'header.php'; ?>
<div class="container pt-4">
    <h1 class="mb-4"><a href="<?php echo URL; ?>">Offers</a></h1>
    <div class="mb-4" id="table">
        <?php 
        if ($_SESSION['auth'] == 1) {
            if ($_SESSION['role'] == 'ad') {
            include "advertiser/offers.php";
            }
            if ($_SESSION['role'] == 'wm') {
            include "web-master/mySubscriptions.php";
            }
        }  else { ?>
            <p>Пожалуйста, войдите в аккаунт или зарегистрируйтесь</p>
        <?php } ?>            
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="advertiser/offerDisactive.js"></script>
<script src="web-master/subscr.js"></script>
</body>
</html>
