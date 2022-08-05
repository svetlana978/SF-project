<?php
session_start();

$webMaster_id = $_SESSION['user_id'];

include $_SERVER['DOCUMENT_ROOT'] . "/db/dbConnect.php";

$act_offer = 0;
$query_offers = "SELECT * FROM `offers`";
$result_offers = mysqli_query($link, $query_offers) or die(mysqli_error($link)); 
$table_start = 0; // для вывода заголовка и каркаса таблицы (чтобы в цикле оно вывелось только 1 раз в самом начале)

if($result_offers != NULL) { 
    for($data = []; $row = mysqli_fetch_assoc($result_offers); $data[] = $row) {
        if ($row['activity'] == 'YES') {
            $offer_id = $row['id'];
            $query_check_subscr = "SELECT * FROM `subscriptions` WHERE `webMaster_id` = '$webMaster_id' AND `offer_id` = '$offer_id'";
            $result_check_subscr = mysqli_query($link, $query_check_subscr) or die(mysqli_error($link)); 
            
            // для исчезновения из списка предложений тех, на которые мы подписаны
            if (mysqli_fetch_assoc($result_check_subscr) == NULL){
                if ($table_start == 0) 
                echo "<table><tr><th>Название</th><th>Стоимость</th><th>Тема</th><th>Число подписчиков</th></tr>";
            
                echo "<tr>";
                echo "<td>" . $row['offer_name'] . "</td>";
                echo "<td>" . $row['cost'] . "</td>";
                echo "<td>" . $row['theme'] . "</td>";
                echo "<td>" . $row['subscribers'] . "</td>";

                $of_name =  $row['offer_name']; 
                ?>
                <td><input  id="<?php echo $of_name ?>" type="button" class = "subscr_button" name="subscribe" value="subscribe"></input> </td>
                <?php echo "</tr>";
                
                // проверяем есть ли хотя бы одно активное предложения для вывода на экран
                // если нет то напишем на экране, что нет активных предложений
                $act_offer = 1;
                $table_start += 1;
            } 
        }
    }
    
    echo "</table>";  
    if ($act_offer == 0) {
        echo "There are no active offers";
    }                  
} 
?>    

<!-- //////////
//////////вывод на экран моих подписок на предложения
////////// -->

<br>
<h1><a href="<?php echo URL; ?>">My subscribtions</a></h1>
 
<?php
$query_Subscr = "SELECT `offer_id` FROM `subscriptions` WHERE `webMaster_id`='$webMaster_id'";
$result_Subscr = mysqli_query($link, $query_Subscr) or die(mysqli_error($link)); 

if(mysqli_fetch_assoc($result_Subscr) == NULL) {       
    echo "You are not subscribed to any offer";        
} else {
    echo "<table><tr><th>Название</th><th>Стоимость перехода</th><th>Тема</th><th>Число подписчиков</th><th>Url</th></tr>";
    foreach($result_Subscr as $row){
        $of_id = $row['offer_id']; 
     
        $query_link_cost = "SELECT `link_cost` FROM `subscriptions` WHERE `webMaster_id` = '$webMaster_id' AND `offer_id` = '$of_id'";
        $result_link_cost = mysqli_query($link, $query_link_cost) or die(mysqli_error($link)); 
        $link_cost = current(mysqli_fetch_assoc($result_link_cost));
         
        $query_Subscr_Offers = "SELECT * FROM `offers` WHERE `id` = '$of_id'";
        $result_Subscr_Offers = mysqli_query($link, $query_Subscr_Offers) or die(mysqli_error($link)); 
           
        for($data = []; $row = mysqli_fetch_assoc($result_Subscr_Offers); $data[] = $row) {
            
            echo "<tr>";
            echo "<td>" . $row['offer_name'] . "</td>";
            echo "<td>" . $link_cost . "</td>";
            echo "<td>" . $row['theme'] . "</td>";
            echo "<td>" . $row['subscribers'] . "</td>";
            echo "<td>" . "<a href='#link_$of_id'>ссылка</a>" . "</td>";
            ?> 
            
            <div class="lightbox" id="link_<?php echo $of_id ?>">
            <figure>
                <a href="#" class="close"></a>
                <div class="window">
                    Вставьте в код: <br>
                    <?php $urlLink = "https://sf-project/redirectSystem/check.php?utm_source=$webMaster_id&offer_id=$of_id"; ?>   
                        &lt;a href="<?php echo $urlLink ?>"&gt;реклама&lt;/a&gt; <br>                    
                </div>
            </figure>
            </div>
            <td><input  id="<?php echo $of_id ?>" type="button" class = "unsubscr_button" name="unsubscribe" value="unsubscribe"></input> </td>
            
            <?php  
            echo "<td>" . "<a href='#count_$of_id'>Статистика</a>" . "</td>";
            $of_name = $row['offer_name'];
            ?> 
            
            <div class="lightbox" id="count_<?php echo $of_id ?>">
            <figure>
                <a href="#" class="close"></a>
                <div class="window">
                    Количество переходов за текущий: <br>
                    День: <?php include "incomeStatistics.php";
                    
                    if ($count[$of_name]['day'] == NULL) {
                    echo '0';
                    } else {
                    echo $count[$of_name]['day'];
                    }
                    ?><br>
                    Месяц: <?php if ($count[$of_name]['month'] == NULL) {
                        echo '0';
                    } else {
                        echo $count[$of_name]['month'];
                    }?><br>
                    Год: <?php if ($count[$of_name]['year'] == NULL) {
                        echo '0';
                    } else {
                        echo $count[$of_name]['year'];
                    }?> <br>

                    Доходы за текущий: <br>
                    День: <?php 
                    if ($count[$of_name]['day'] == NULL) {
                        echo '0';
                    } else {
                        echo $row['cost'] * $count[$of_name]['day'];
                    }
                    ?><br>
                    Месяц: <?php if ($count[$of_name]['month'] == NULL) {
                        echo '0';
                    } else {
                        echo $row['cost'] * $count[$of_name]['month'];
                    }?><br>
                    Год: <?php if ($count[$of_name]['year'] == NULL) {
                        echo '0';
                    } else {
                        echo $row['cost'] * $count[$of_name]['year'];
                    }?> <br>
                </div>
            </figure>
            </div>
                
            <?php echo "</tr>";
        } 
    }  
    echo "</table>";    
} 