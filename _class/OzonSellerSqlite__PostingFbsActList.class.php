<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include_once "$HOME/_class/Logger.class.php";
include_once "$HOME/_class/OzonSeller__PostingFbsActList.class.php";

class OzonSellerSqlite__PostingFbsActList {
    public function fetch__getArray() {
        return (new OzonSeller__PostingFbsActList())->getAll();
    }

    private function getDatabaseConnect() {
        $HOME = $_SERVER['DOCUMENT_ROOT'];

        $logger = new Logger();
        $logger->log(message: "Подкоючение к sqlite");

        $pdo = new PDO("sqlite:$HOME/database/database.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    function saveToDatabase() {
        $logger = new Logger();
        try {
            $HOME = $_SERVER['DOCUMENT_ROOT'];
            $logger->log(message: "Подкоючение к sqlite");

            $pdo = new PDO("sqlite:$HOME/database/database.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<p style='color: green;'>Успешное подключение к SQLite</p>";

            $products = $this->fetch__getArray();

            $sql = "DROP TABLE IF EXISTS DOC_OzonSellerPostingFbsActList";
            $logger->log("$sql");
            $pdo->prepare($sql)->execute();
       
            echo "<p style='color: green;'>Таблица удалена успешно DOC_OzonSellerPostingFbsActList</p>";

            $sql = "CREATE TABLE DOC_OzonSellerPostingFbsActList (
                        id INTEGER,
                        delivery_method_id INTEGER,
                        delivery_method_name TEXT,
                        integration_type TEXT,
                        containers_count INTEGER,
                        status TEXT,
                        departure_date TEXT,
                        created_at TEXT,
                        updated_at TEXT,
                        act_type TEXT,
                        related_docs__act_of_acceptance TEXT,
                        related_docs__act_of_mismatch TEXT,
                        related_docs__act_of_excess TEXT,
                        is_partial INTEGER,
                        has_postings_for_next_carriage INTEGER,
                        partial_num INTEGER
                    )
                    ";

            $logger->log("$sql");

            $pdo->prepare($sql)->execute();

            echo "<p style='color: green;'>Таблица создана успешно DOC_OzonSellerPostingFbsActList</p>";

            $sql = "INSERT INTO
                    DOC_OzonSellerPostingFbsActList
                    (
                        id,
                        delivery_method_id,
                        delivery_method_name,
                        integration_type,
                        containers_count,
                        status,
                        departure_date,
                        created_at,
                        updated_at,
                        act_type,
                        related_docs__act_of_acceptance,
                        related_docs__act_of_mismatch,
                        related_docs__act_of_excess,
                        is_partial,
                        has_postings_for_next_carriage,
                        partial_num
                    )
                    VALUES
                    ";

            $array_rows = [];
            $array_values = [];
            $count = 0;
            foreach($products as $element) {
                $array_values []= $element['id'];
                $array_values []= $element['delivery_method_id'];
                $array_values []= $element['delivery_method_name'];
                $array_values []= $element['integration_type'];
                $array_values []= $element['containers_count'];
                $array_values []= $element['status'];
                $array_values []= $element['departure_date'];
                $array_values []= $element['created_at'];
                $array_values []= $element['updated_at'];
                $array_values []= $element['act_type'];
                $array_values []= json_encode($element['related_docs']['act_of_acceptance'], true);
                $array_values []= json_encode($element['related_docs']['act_of_mismatch'], true);
                $array_values []= json_encode($element['related_docs']['act_of_excess'], true);
                $array_values []= $element['is_partial'] ? '1' : '0';
                $array_values []= $element['has_postings_for_next_carriage'] ? '1' : '0';
                $array_values []= $element['partial_num'];

                $count += 1;

                $array_rows []= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $sql .= implode(",\n", $array_rows);

            $logger->log("$sql");
            $logger->log(json_encode($array_values, true));

            $pdo->prepare($sql)->execute($array_values);

            echo "<p style='color: green;'>Таблица заполнена успешно DOC_OzonSellerPostingFbsActList</p>";
        }
        catch(Throwable $exception) {
            echo "<p style='color: red;'>Исключение</p>";
            echo "<p style='color: red;'>$exception</p>";
            $logger->log("$exception");
        }
    }

    public function getAll() {
        $pdo = $this->getDatabaseConnect();

        $sql = "SELECT
                    *
                FROM
                    DOC_OzonSellerPostingFbsActList
                ORDER BY
                    id DESC
                ";

        $smth = $pdo->prepare($sql); 
        $smth->execute();
        $result = $smth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
