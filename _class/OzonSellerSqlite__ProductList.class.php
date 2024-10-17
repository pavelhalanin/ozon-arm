<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include_once "$HOME/_class/Logger.class.php";
include_once "$HOME/_class/OzonSeller__ProductList.class.php";

class OzonSellerSqlite__ProductList {
    private function getAllProducts() {
        return (new OzonSeller__ProductList())->fetchJson__getAllProducts();
    }

    function saveToDatabase() {
        $logger = new Logger();
        try {
            $HOME = $_SERVER['DOCUMENT_ROOT'];
            $logger->log(message: "Подкоючение к sqlite");

            $pdo = new PDO("sqlite:$HOME/database/database.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<p style='color: green;'>Успешное подключение к SQLite</p>";

            $products = $this->getAllProducts();

            $sql = "DROP TABLE IF EXISTS CTL_OzonSellerProductList";
            $logger->log("$sql");
            $pdo->prepare($sql)->execute();

            echo "<p style='color: green;'>Таблица удалена успешно CTL_OzonSellerProductList</p>";
       
            $sql = "CREATE TABLE CTL_OzonSellerProductList (
                        product_id INTEGER,
                        offer_id TEXT,
                        is_fbo_visible INTEGER,
                        is_fbs_visible INTEGER,
                        archived INTEGER,
                        is_discounted INTEGER
                    )
                    ";

            echo "<p style='color: green;'>Таблица создана успешно CTL_OzonSellerProductList</p>";

            $logger->log("$sql");

            $pdo->prepare($sql)->execute();

            $sql = "INSERT INTO
                    CTL_OzonSellerProductList
                    (product_id, offer_id, is_fbo_visible, is_fbs_visible, archived, is_discounted)
                    VALUES
                    ";

            $array_rows = [];
            $array_values = [];
            foreach($products as $element) {
                $array_values []= $element['product_id'];
                $array_values []= $element['offer_id'];
                $array_values []= $element['is_fbo_visible'] ? 1 : 0;
                $array_values []= $element['is_fbs_visible'] ? 1 : 0;
                $array_values []= $element['archived'] ? 1 : 0;
                $array_values []= $element['is_discounted'] ? 1 : 0;
                $array_rows []= "(?, ?, ?, ?, ?, ?)";
            }

            $sql .= implode(",\n", $array_rows);

            $logger->log("$sql");

            $pdo->prepare($sql)->execute($array_values);

            echo "<p style='color: green;'>Таблица заполнена успешно CTL_OzonSellerProductList</p>";
        }
        catch(Throwable $exception) {
            echo "<p style='color: red;'>Исключение</p>";
            echo "<p style='color: red;'>$exception</p>";
            $logger->log("$exception");
        }
    }
}
