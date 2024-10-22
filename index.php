<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'Главная';

include "$HOME/_includes/head.php";
?>

<div class="container">
<div class="mt-2 mb-2">
        <a class="btn btn-success" href="/" style="color: white;">Главная</a>
    </div>
    <div class="mt-2 mb-2">
        <a class="btn btn-primary" href="/api/">API</a>
        <a class="btn btn-primary" href="/reports/">Отчеты</a>
        <a class="btn btn-primary" href="/catalogs/">Каталоги</a>
        <a class="btn btn-primary" href="/update-database/">Обновление БД</a>
    </div>
</div>
