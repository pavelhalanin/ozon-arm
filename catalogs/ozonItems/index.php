<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include "$HOME/config/env.php";
include "$HOME/_class/OzonItemHelper.class.php";

$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'Товары';

include "$HOME/_includes/head.php";

$ozonItemHelper = new OzonItemHelper();
$jsonData = $ozonItemHelper->fetch([
    'limit' => 1000,
]);

$result = $jsonData->result;
$items = $result->items;

function getBooleanText($booleanValue) {
    return $booleanValue ? 'Истина' : 'Ложь';
}

function getBooleanColor($booleanValue) {
    return $booleanValue ? 'green' : 'red';
}

function echoBooleanTr($booleanValue) {
    $color = getBooleanColor($booleanValue);
    $text = getBooleanText($booleanValue);
    echo "<td style='color: $color;'>$text</td>";
}

?>
  
<div class="container">
    <div class="mt-2 mb-2">
        <a class="btn btn-success" href="/catalogs/">Назад</a>
        <a class="btn btn-success" href="/catalogs/ozonItems/json/">JSON</a>
    </div>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th class="text-center">product_id</th>
                <th class="text-center">offer_id</th>
                <th class="text-center">is_fbo_visible</th>
                <th class="text-center">is_fbs_visible</th>
                <th class="text-center">archived</th>
                <th class="text-center">is_discounted</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($items as $element) {
                    $product_id = $element->product_id;
                    $offer_id = $element->offer_id;
                    $is_fbo_visible = $element->is_fbo_visible;
                    $is_fbs_visible = $element->is_fbs_visible;
                    $archived = $element->archived;
                    $is_discounted = $element->is_discounted;

                    echo "<tr>";
                    echo "<td>$product_id</td>";
                    echo "<td>$offer_id</td>";
                    echoBooleanTr($is_fbo_visible);
                    echoBooleanTr($is_fbs_visible);
                    echoBooleanTr($archived);
                    echoBooleanTr($is_discounted);
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table> 
</div>
