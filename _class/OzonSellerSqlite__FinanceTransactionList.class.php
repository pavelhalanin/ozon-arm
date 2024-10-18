<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include_once "$HOME/_class/Logger.class.php";
include_once "$HOME/_class/OzonSeller__FinanceTransactionList.class.php";

class OzonSellerSqlite__FinanceTransactionList {
    public function getArray() {
        return (new OzonSeller__FinanceTransactionList())->getAll();
    }

    function saveToDatabase() {
        $logger = new Logger();
        try {
            $HOME = $_SERVER['DOCUMENT_ROOT'];
            $logger->log(message: "Подкоючение к sqlite");

            $pdo = new PDO("sqlite:$HOME/database/database.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<p style='color: green;'>Успешное подключение к SQLite</p>";

            $products = $this->getArray();

            $sql = "DROP TABLE IF EXISTS DOC_OzonSellerFinanceTransactionList";
            $logger->log("$sql");
            $pdo->prepare($sql)->execute();
       
            echo "<p style='color: green;'>Таблица удалена успешно DOC_OzonSellerFinanceTransactionList</p>";

            $sql = "CREATE TABLE DOC_OzonSellerFinanceTransactionList (
                        operation_id INTEGER,
                        operation_type TEXT,
                        operation_date TEXT,
                        operation_type_name TEXT,
                        delivery_charge REAL,
                        return_delivery_charge REAL,
                        accruals_for_sale REAL,
                        sale_commission REAL,
                        amount REAL,
                        type TEXT,
                        posting__delivery_schema TEXT,
                        posting__order_date REAL,
                        posting__posting_number TEXT,
                        posting__warehouse_id REAL,
                        items TEXT,
                        services TEXT
                    )
                    ";

            $logger->log("$sql");

            $pdo->prepare($sql)->execute();

            echo "<p style='color: green;'>Таблица создана успешно DOC_OzonSellerFinanceTransactionList</p>";

            $sql = "INSERT INTO
                    DOC_OzonSellerFinanceTransactionList
                    (
                        operation_id,
                        operation_type,
                        operation_date,
                        operation_type_name,
                        delivery_charge,
                        return_delivery_charge,
                        accruals_for_sale,
                        sale_commission,
                        amount,
                        type,
                        posting__delivery_schema,
                        posting__order_date,
                        posting__posting_number,
                        posting__warehouse_id,
                        items,
                        services
                    )
                    VALUES
                    ";

            $array_rows = [];
            $array_values = [];
            $count = 0;
            foreach($products as $element) {
                $array_values []= $element['operation_id'];
                $array_values []= $element['operation_type'];
                $array_values []= $element['operation_date'];
                $array_values []= $element['operation_type_name'];
                $array_values []= $element['delivery_charge'];
                $array_values []= $element['return_delivery_charge'];
                $array_values []= $element['accruals_for_sale'];
                $array_values []= $element['sale_commission'];
                $array_values []= $element['amount'];
                $array_values []= $element['type'];
                $array_values []= $element['posting']['delivery_schema'];
                $array_values []= $element['posting']['order_date'];
                $array_values []= $element['posting']['posting_number'];
                $array_values []= $element['posting']['warehouse_id'];
                $array_values []= json_encode($element['items']);
                $array_values []= json_encode($element['services']);

                $count += 1;

                $array_rows []= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $sql .= implode(",\n", $array_rows);

            $logger->log("$sql");

            $pdo->prepare($sql)->execute($array_values);

            echo "<p style='color: green;'>Таблица заполнена успешно DOC_OzonSellerFinanceTransactionList</p>";
        }
        catch(Throwable $exception) {
            echo "<p style='color: red;'>Исключение</p>";
            echo "<p style='color: red;'>$exception</p>";
            $logger->log("$exception");
        }
    }
}
