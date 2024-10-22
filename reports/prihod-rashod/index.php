<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

$seoTitle = 'Приход-расход';

include "$HOME/_includes/head.php";
include "$HOME/_class/OzonSellerSqlite__FinanceTransactionList.class.php";

function getDescription($name)
{
    switch ($name) {
        case 'MarketplaceRedistributionOfAcquiringOperation':
            return 'Эквайринг';
        case 'MarketplaceServiceItemDropoffPVZ':
            return 'Обработка отправления (Drop-off/Pick-up)';
        case 'MarketplaceServiceItemDirectFlowTrans':
            return '';
        case 'MarketplaceServiceItemDelivToCustomer':
            return 'Последняя миля';
        case 'MarketplaceServiceItemDirectFlowLogistic':
            return 'Логистика';
        case 'MarketplaceServiceItemReturnAfterDelivToCustomer':
            return '';
        case 'MarketplaceServiceItemReturnFlowTrans':
            return '';
        case 'MarketplaceServiceItemReturnFlowLogistic':
            return 'Обратная логистика';
        case 'MarketplaceServiceItemRedistributionReturnsPVZ':
            return 'Обработка возврата';
        default:
            return '';
    }
}

function echoHeadTr() {
    echo "<tr><td colspan='9'></td></tr>";
    echo "<tr class='table-light'>";
    echo "<td class='text-center'>№<br/>операции</td>";
    echo "<td class='text-center'>Дата<br/>операции</td>";
    echo "<td class='text-center'>Тип<br/>операции</td>";
    echo "<td class='text-center'>Дата<br/>заказа</td>";
    echo "<td class='text-center'>Номер<br/>заказа</td>";
    echo "<td class='text-center'>Артикулы OZON</td>";
    echo "<td class='text-center'>Приход</td>";
    echo "<td class='text-center'>Расход</td>";
    echo "<td class='text-center'>Итого</td>";
    echo "<td class='text-center'>Описание</td>";
    echo "</tr>";
}

function echoViewUpperTd() {
    echo "<td class='text-center text-secondary'>↑</td>";
}
?>

<div class="container">
    <div class="mt-2 mb-2">
        <a class="btn btn-success" href="/reports">Назад</a>
    </div>
    <h2>Транзакции начислений отсортированные по № операции (дате начисления)</h2>
    <?php
        $arr = (new OzonSellerSqlite__FinanceTransactionList())->getAll();
        
        echo "<table class='table table-bordered'>";
        $total_sum = 0;
        foreach($arr as $element) {
            $services = json_decode($element['services'], true);

            $sum_1 = 0;
            foreach ($services as $service) {
                $sum_1 += $service['price'];
            }

            $sum_1 += $element['accruals_for_sale'];
            $sum_1 += $element['sale_commission'];

            $sum_2 = $element['amount'];

            $operation_id = $element['operation_id'];
            $operation_date = (new DateTime($element['operation_date']))->format('Y-m-d');
            $operation_type_name = $element['operation_type_name'];
            $posting__order_date = $element['posting__order_date'];
            $posting__posting_number = $element['posting__posting_number'];
            $items = json_decode($element['items'], true);
            $services = json_decode($element['services'], true);
            $accruals_for_sale = $element['accruals_for_sale'];
            $sale_commission = $element['sale_commission'];

            if (strcmp("$sum_1", "$sum_2") == 0) {
                $ozon_articles = array_map(function($item) {
                    return $item['sku'];
                }, $items);

                $string_ozon_articles = implode("<br/>", $ozon_articles);

                $rowspan = 1;
                
                $rowspan += count($services);

                if ($accruals_for_sale != 0) {
                    // echo "<p>$accruals_for_sale != 0</p>";
                    $rowspan += 1;
                }

                if ($sale_commission != 0) {
                    // echo "<p>$sale_commission != 0</p>";
                    $rowspan += 1;
                }

                echoHeadTr();

                echo "<tr>";
                echo "<td>$operation_id</td>";
                echo "<td>$operation_date</td>";
                echo "<td>$operation_type_name</td>";
                echo "<td>$posting__order_date</td>";
                echo "<td>$posting__posting_number</td>";
                echo "<td>$string_ozon_articles</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "</tr>";

                if($accruals_for_sale != 0) {
                    $prihod = "";
                    $rashod = "";
                    $price = $accruals_for_sale;
                    $name = 'accruals_for_sale';
                    $description = 'За продажу или возврат до вычета комиссий и услуг';

                    if ($price > 0) {
                        $prihod = $price;
                        $total_sum += $prihod;
                    }
                    else {
                        $rashod = $price;
                        $total_sum += $rashod;
                    }

                    echo "<tr>";
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echo "<td class='text-success'>$prihod</td>";
                    echo "<td class='text-danger'>$rashod</td>";
                    echo "<td>$total_sum</td>";
                    echo "<td>$description <br/> <span class='text-secondary'>$name</span></td>";
                    echo "</tr>"; 
                }

                if($sale_commission != 0) {
                    $prihod = "";
                    $rashod = "";
                    $price = $sale_commission;
                    $name = 'sale_commission';
                    $description = 'Комиссия за продажу';

                    if ($price > 0) {
                        $prihod = $price;
                        $total_sum += $prihod;
                    }
                    else {
                        $rashod = $price;
                        $total_sum += $rashod;
                    }


                    echo "<tr>";
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echo "<td class='text-success'>$prihod</td>";
                    echo "<td class='text-danger'>$rashod</td>";
                    echo "<td>$total_sum</td>";
                    echo "<td>$description <br/> <span class='text-secondary'>$name</span></td>";
                    echo "</tr>"; 
                }

                foreach($services as $service) {
                    $prihod = "";
                    $rashod = "";
                    $price = $service['price'];
                    $name = $service['name'];
                    $description = getDescription($name);

                    if ($price > 0) {
                        $prihod = $price;
                        $total_sum += $prihod;
                    }
                    else {
                        $rashod = $price;
                        $total_sum += $rashod;
                    }


                    echo "<tr>";
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echoViewUpperTd();
                    echo "<td class='text-success'>$prihod</td>";
                    echo "<td class='text-danger'>$rashod</td>";
                    echo "<td>$total_sum</td>";
                    echo "<td>$description <br/> <span class='text-secondary'>$name</span></td>";
                    echo "</tr>";
                }
            }
            else {
                echoHeadTr();

                $prihod = "";
                $rashod = "";
                $price = $element['amount'];

                if ($price > 0) {
                    $prihod = $price;
                    $total_sum += $prihod;
                }
                else {
                    $rashod = $price;
                    $total_sum += $rashod;
                }


                echo "<tr>";
                echo "<td>$operation_id</td>";
                echo "<td>$operation_date</td>";
                echo "<td>$operation_type_name</td>";
                echo "<td>$posting__order_date</td>";
                echo "<td>$posting__posting_number</td>";
                echo "<td>$string_ozon_articles</td>";
                echo "<td class='text-secondary'>$prihod</td>";
                echo "<td class='text-secondary'>$rashod</td>";
                echo "<td>$total_sum</td>";
                echo "<td></td>";
                echo "</tr>";
            }
        }

        echo "</table>";
    ?>
</div>
