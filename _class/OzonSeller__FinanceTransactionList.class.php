<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include "$HOME/config/env.php";

class OzonSeller__FinanceTransactionList {
 
    private function getData($startDate, $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end->modify('last day of this month'); // Получаем последний день месяца для конечной даты
        $data = [];
    
        while ($start <= $end) {
            $startOfMonth = $start->format('Y-m-01\T00:00:00.000\Z');
            $endOfMonth = $start->format('Y-m-t\T23:59:59.999\Z');
    
            $data[] = [
                'start' => $startOfMonth,
                'end' => $endOfMonth
            ];
    
            // Переход к следующему месяцу
            $start->modify('first day of next month');
        }
    
        return $data;
    }

    public function getAll() {
        $startDate = '2024-01-10';
        $endDate = (new DateTime('tomorrow'))->format('Y-m-d');

        $result = $this->getData($startDate, $endDate);

        $resultArray = [];
        for ($i = 0; $i < count($result); $i++) {
            $data = $this->fetchJson__getTransactionsOnPeriod($result[$i]['start'], $result[$i]['end']);
            $arr = $data['result']['operations'];
            for ($j = 0; $j < count($arr); $j++) {
                $resultArray []= $arr[$j];
            }
        }

        return $resultArray;
    }

    public function fetchJson__getTransactionsOnPeriod($dateFrom, $dateTo) {        
        return $this->fetchJson([
            "filter" => [
                "date" => [
                    "from" => $dateFrom,
                    "to" => $dateTo,
                ],
                "operation_type" => [],
                "posting_number" => "",
                "transaction_type" => "all",
            ],
            "page" => 1,
            "page_size" => 1000,
        ]);
    }

    public function fetchJson($HTTP_DATA) {
        global $env;
        $URI = "/v3/finance/transaction/list";
        $FETCH_URL = "https://api-seller.ozon.ru$URI";

        $jsonData = json_encode($HTTP_DATA);

        // Инициализируем cURL сессии
        $ch = curl_init($FETCH_URL);

        // Устанавливаем параметры cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);  // Устанавливаем метод POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Тело запроса

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        // Устанавливаем заголовки
        $ozonClientId = $env['ozon-client-id'];
        $ozonApiKey = $env['ozon-api-key'];

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json', // Указываем, что передаем данные в формате JSON
        "Client-Id: $ozonClientId",
        "Api-Key: $ozonApiKey",
        ));

        // Передаем куки
        // curl_setopt($ch, CURLOPT_COOKIE, "Client-Id=$ozonClientId; Api-Key=$ozonApiKey");

        // Выполняем запрос и получаем ответ
        $response = curl_exec($ch);

        // Проверяем на наличие ошибок
        if (curl_errno($ch)) {
            $err = curl_error($ch);
            // Закрываем cURL сессию
            curl_close($ch);
            throw new Error("Fetch error: $err");
        } else {
            // Закрываем cURL сессию
            curl_close($ch);
            $jsonString = $response;
            $phpObject = json_decode($jsonString, true);
            return $phpObject;
        }
    }
}