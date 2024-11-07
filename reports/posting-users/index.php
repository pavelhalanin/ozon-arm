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
        $arr = (new OzonSellerSqlite__FinanceTransactionList())->getUsersInfo();

        echo "<h2>Количество заказов по каждому покупателю</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-light'>";
        echo "<tr>";
        echo "<td class='align-middle text-center' width='100'>№</td>";
        echo "<td class='align-middle text-center' width='100'>Идентификатор<br/>пользователя</td>";
        echo "<td class='align-middle text-center' width='100'>Количество<br/>заказов</td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i < count($arr); $i++) {
            $element = $arr[$i];

            $index = $i + 1;
            $order_count = $element['order_count'];
            $user_id = $element['user_id'];

            echo "<tr>";
            echo "<td class='text-end'>$index</td>";
            echo "<td class='text-end'>$user_id</td>";
            echo "<td class='text-end'>$order_count</td>";
            echo "<td></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    ?>
</div>
