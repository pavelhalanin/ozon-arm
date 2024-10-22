<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'ТТН';

include "$HOME/_includes/head.php";
include "$HOME/_class/OzonSellerSqlite__PostingFbsActList.class.php";
?>

<div class="container">
    <div class="mt-2 mb-2">
        <a class="btn btn-success" href="/reports">Назад</a>
    </div>
    <h2>ТТН</h2>
    <?php
        $arr = (new OzonSellerSqlite__PostingFbsActList())->getAll();
        
        echo "<table class='table table-bordered'>";

        echo "<thead>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td width='200'>id</td>";
        echo "<td width='200'>Дата ТТН</td>";
        echo "<td>Скачать PDF</td>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";

        $length = count($arr);
        for ($i = 0; $i < $length; $i++) {
            $element = $arr[$i];

            $index = $length - $i;
            $id = $element['id'];
            $departure_date = $element['departure_date'];
            $filename = 'OZON_TTN_' . $id . "_" . "$departure_date" . ".pdf";
        
            echo "<tr>";
            echo "<td>$index</td>";
            echo "<td>$id</td>";
            echo "<td>$departure_date</td>";
            echo "<td><a class='btn btn-success' href='/reports/ttn/pdf/?id=$id&filename=$filename'>скачать PDF</a></td>";
            echo "</tr>";
        }

        echo "</tbody>";

        echo "</table>";
    ?>
</div>
