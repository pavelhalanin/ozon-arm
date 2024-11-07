<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'Номера заказов';

include "$HOME/_includes/head.php";
include "$HOME/_class/OzonSellerSqlite__FinanceTransactionList.class.php";
?>

<div class="container">
    <div class="mt-2 mb-2">
        <a class="btn btn-success" href="/reports">Назад</a>
    </div>
    <?php
        $arr = (new OzonSellerSqlite__FinanceTransactionList())->getUnicPostingData();

        $filteredArray = [];
        for ($i = 0; $i < count($arr); $i++) {
            $element = $arr[$i];
            if ($element['_posting__user_id']) {
                array_push($filteredArray, $element);
            }
        }
  
        $count = count($filteredArray);
        echo "<h2>Даты заказов (всего заказов $count)</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-light'>";
        echo "<tr>";
        echo "<td class='align-middle text-center' width='100'>№</td>";
        echo "<td class='align-middle text-center' width='200'>Дата заказа</td>";
        echo "<td class='align-middle text-center' width='200'>Идентификатор<br/>пользователя</td>";
        echo "<td class='align-middle text-center' width='100'>Количество<br/>заказов</td>";
        echo "<td class='align-middle text-center'>Номер заказа</td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        for($i = count($filteredArray) - 1; $i >= 0; $i--) {
            $element = $filteredArray[$i];

            $index = $i + 1;
            $order_date = $element['posting__order_date'];
            $order_user_id = $element['_posting__user_id'];
            $order_order_number = $element['_posting__order_number'];

            echo "<tr>";
            echo "<td class='text-end'>$index</td>";
            echo "<td class='text-center'>$order_date</td>";
            echo "<td class='text-end'>$order_user_id</td>";
            echo "<td class='text-center'>$order_order_number</td>";
            echo "<td class='text-start'>$order_user_id-$order_order_number</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    ?>
</div>
