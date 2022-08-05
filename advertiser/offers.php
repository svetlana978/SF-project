<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/db/dbConnect.php";

$id_owner = $_SESSION['user_id'];

$query = "SELECT * FROM `offers` WHERE `id_owner`='$id_owner'";
$result = mysqli_query($link, $query) or die(mysqli_error($link)); 

if($result != NULL) { 
    for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) {
        if ($data == []) {
        echo "<table><tr><th>Название</th><t><th>Стоимость</th><th>Url</th><th>Тема</th><th>Число подписчиков</th><th>Активность</th></tr>";
        }

        echo "<tr>";
        echo "<td>" . $row['offer_name'] . "</td>";
        echo "<td>" . $row['cost'] . "</td>";
        echo "<td>" . $row['offer_url'] . "</td>";
        echo "<td>" . $row['theme'] . "</td>";
        echo "<td>" . $row['subscribers'] . "</td>";
        echo "<td>" . $row['activity'] . "</td>";
        $of_name =  $row['offer_name']; 
        $of_id = $row['id']; 
        $arr_offer_name[] = $row['offer_name'];
        $arr_url[] = $row['offer_url'];
        ?>
        <td><input id="<?php echo $of_name ?>" type="button" class = "activity_button" name="activity" ></input> </td>
        <?php  
        echo "<td>" . "<a href='#count_$of_id'>Статистика</a>" . "</td>";
        ?> 
        
        <div class="lightbox" id="count_<?php echo $of_id ?>">
            <figure>
                <a href="#" class="close"></a>
                <div class="window">
                    Количество переходов за текущий: <br>
                    День: <?php include "expenseStatistics.php"; 
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

                    Расходы за текущий: <br>
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
        <?
        echo "</tr>";
    }
    echo "</table>";
} else { ?>
<div class="alert alert-secondary">Нет созданных offer-ов</div>  
<?php } ?>              
<a href="advertiser/newOffer.php">Создать новый offer</a>      
