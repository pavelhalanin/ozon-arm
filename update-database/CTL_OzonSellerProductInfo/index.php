<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'CTL_OzonSellerProductInfo';

include "$HOME/_includes/head.php";
include "$HOME/_class/OzonSellerSqlite__ProductInfo.class.php";
?>

<div class="container">
    <div class="mt-2 mb-2">
        <a class="btn btn-success" href="/update-database">Назад</a>
    </div>
    <?php
        (new OzonSellerSqlite__ProductInfo())->saveToDatabase();
    ?>
</div>
