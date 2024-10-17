<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];
include_once "$HOME/_class/Logger.class.php";
include_once "$HOME/_class/OzonSeller__ProductInfo.class.php";

class OzonSellerSqlite__ProductInfo {
    private function getAllProducts() {
        return (new OzonSeller__ProductInfo())->fetchJson__getAllProducts();
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

            $sql = "DROP TABLE IF EXISTS CTL_OzonSellerProductInfo";
            $logger->log("$sql");
            $pdo->prepare($sql)->execute();
       
            echo "<p style='color: green;'>Таблица удалена успешно CTL_OzonSellerProductInfo</p>";

            $sql = "CREATE TABLE CTL_OzonSellerProductInfo (
                        id INTEGER,
                        name TEXT,
                        offer_id TEXT,
                        barcode TEXT,
                        buybox_price TEXT,
                        category_id INTEGER,
                        created_at TEXT,
                        images TEXT,
                        marketing_price REAL,
                        min_ozon_price TEXT,
                        old_price REAL,
                        premium_price TEXT,
                        price REAL,
                        recommended_price TEXT,
                        min_price TEXT,
                        sources TEXT,
                        stocks__coming INTEGER,
                        stocks__present INTEGER,
                        stocks__reserved INTEGER,
                        errors TEXT,
                        vat REAL,
                        visible INTEGER,
                        visibility_details__has_price INTEGER,
                        visibility_details__has_stock INTEGER,
                        visibility_details__active_product INTEGER,
                        price_index REAL,

                        commissions_fbo__percent INTEGER,
                        commissions_fbo__min_value INTEGER,
                        commissions_fbo__value REAL,
                        commissions_fbo__sale_schema TEXT,
                        commissions_fbo__delivery_amount INTEGER,
                        commissions_fbo__return_amount INTEGER,

                        commissions_fbs__percent INTEGER,
                        commissions_fbs__min_value INTEGER,
                        commissions_fbs__value REAL,
                        commissions_fbs__sale_schema TEXT,
                        commissions_fbs__delivery_amount INTEGER,
                        commissions_fbs__return_amount INTEGER,

                        commissions_rfbs__percent INTEGER,
                        commissions_rfbs__min_value INTEGER,
                        commissions_rfbs__value REAL,
                        commissions_rfbs__sale_schema TEXT,
                        commissions_rfbs__delivery_amount INTEGER,
                        commissions_rfbs__return_amount INTEGER,

                        commissions_fbp__percent INTEGER,
                        commissions_fbp__min_value INTEGER,
                        commissions_fbp__value REAL,
                        commissions_fbp__sale_schema TEXT,
                        commissions_fbp__delivery_amount INTEGER,
                        commissions_fbp__return_amount INTEGER,
                        
                        volume_weight REAL,
                        is_prepayment INTEGER,
                        is_prepayment_allowed INTEGER,
                        images360 TEXT,
                        color_image TEXT,
                        primary_image TEXT,

                        status__state TEXT,
                        status__state_failed TEXT,
                        status__moderate_status TEXT,
                        status__decline_reasons TEXT,
                        status__validation_state TEXT,
                        status__state_name TEXT,
                        status__state_description TEXT,
                        status__is_failed INTEGER,
                        status__is_created INTEGER,
                        status__state_tooltip TEXT,

                        status__item_errors__code TEXT,
                        status__item_errors__field TEXT,
                        status__item_errors__attribute_id INTEGER,
                        status__item_errors__state TEXT,
                        status__item_errors__level TEXT,
                        status__item_errors__description TEXT,

                        status__state_updated_at TEXT,

                        state TEXT,
                        service_type TEXT,
                        fbo_sku INTEGER,
                        fbs_sku INTEGER,
                        currency_code TEXT,
                        is_kgt INTEGER,

                        discounted_stocks__coming INTEGER,
                        discounted_stocks__present INTEGER,
                        discounted_stocks__reserved INTEGER,

                        is_discounted INTEGER,
                        has_discounted_item INTEGER,
                        barcodes TEXT,
                        updated_at TEXT,
                        price_indexes__price_index TEXT,
                        price_indexes__external_index_data__minimal_price TEXT,
                        price_indexes__external_index_data__minimal_price_currency TEXT,
                        price_indexes__external_index_data__price_index_value INTEGER,
                        price_indexes__ozon_index_data__minimal_price TEXT,
                        price_indexes__ozon_index_data__minimal_price_currency TEXT,
                        price_indexes__ozon_index_data__price_index_value INTEGER,
                        price_indexes__self_marketplaces_index_data__minimal_price TEXT,
                        price_indexes__self_marketplaces_index_data__minimal_price_currency TEXT,
                        price_indexes__self_marketplaces_index_data__price_index_value INTEGER,
                        sku INTEGER,
                        description_category_id INTEGER,
                        type_id INTEGER,
                        is_archived INTEGER,
                        is_autoarchived INTEGER
                    )
                    ";

            $logger->log("$sql");

            $pdo->prepare($sql)->execute();

            echo "<p style='color: green;'>Таблица создана успешно CTL_OzonSellerProductInfo</p>";

            $sql = "INSERT INTO
                    CTL_OzonSellerProductInfo
                    (
                        id,
                        name,
                        offer_id,
                        barcode,
                        buybox_price,
                        category_id,
                        created_at,
                        images,
                        marketing_price,
                        min_ozon_price,
                        old_price,
                        premium_price,
                        price,
                        recommended_price,
                        min_price,
                        sources,
                        stocks__coming,
                        stocks__present,
                        stocks__reserved,
                        errors,
                        vat,
                        visible,
                        visibility_details__has_price,
                        visibility_details__has_stock,
                        visibility_details__active_product,
                        price_index,
                        commissions_fbo__percent,
                        commissions_fbo__min_value,
                        commissions_fbo__value,
                        commissions_fbo__sale_schema,
                        commissions_fbo__delivery_amount,
                        commissions_fbo__return_amount,
                        commissions_fbs__percent,
                        commissions_fbs__min_value,
                        commissions_fbs__value,
                        commissions_fbs__sale_schema,
                        commissions_fbs__delivery_amount,
                        commissions_fbs__return_amount,
                        commissions_rfbs__percent,
                        commissions_rfbs__min_value,
                        commissions_rfbs__value,
                        commissions_rfbs__sale_schema,
                        commissions_rfbs__delivery_amount,
                        commissions_rfbs__return_amount,
                        commissions_fbp__percent,
                        commissions_fbp__min_value,
                        commissions_fbp__value,
                        commissions_fbp__sale_schema,
                        commissions_fbp__delivery_amount,
                        commissions_fbp__return_amount,
                        volume_weight,
                        is_prepayment,
                        is_prepayment_allowed,
                        images360,
                        color_image,
                        primary_image,
                        status__state,
                        status__state_failed,
                        status__moderate_status,
                        status__decline_reasons,
                        status__validation_state,
                        status__state_name,
                        status__state_description,
                        status__is_failed,
                        status__is_created,
                        status__state_tooltip,
                        status__item_errors__code,
                        status__item_errors__field,
                        status__item_errors__attribute_id,
                        status__item_errors__state,
                        status__item_errors__level,
                        status__item_errors__description,
                        status__state_updated_at,
                        state,
                        service_type,
                        fbo_sku,
                        fbs_sku,
                        currency_code,
                        is_kgt,
                        discounted_stocks__coming,
                        discounted_stocks__present,
                        discounted_stocks__reserved,
                        is_discounted,
                        has_discounted_item,
                        barcodes,
                        updated_at,
                        price_indexes__price_index,
                        price_indexes__external_index_data__minimal_price,
                        price_indexes__external_index_data__minimal_price_currency,
                        price_indexes__external_index_data__price_index_value,
                        price_indexes__ozon_index_data__minimal_price,
                        price_indexes__ozon_index_data__minimal_price_currency,
                        price_indexes__ozon_index_data__price_index_value,
                        price_indexes__self_marketplaces_index_data__minimal_price,
                        price_indexes__self_marketplaces_index_data__minimal_price_currency,
                        price_indexes__self_marketplaces_index_data__price_index_value,
                        sku,
                        description_category_id,
                        type_id,
                        is_archived,
                        is_autoarchived
                    )
                    VALUES
                    ";

            $array_rows = [];
            $array_values = [];
            $count = 0;
            foreach($products as $el) {
                $element = $el['result'];
                
                $array_values []= $element['id'];
                $array_values []= $element['name'];
                $array_values []= $element['offer_id'];
                $array_values []= $element['barcode'];
                $array_values []= $element['buybox_price'];
                $array_values []= $element['category_id'];
                $array_values []= $element['created_at'];
                $array_values []= implode("\n", $element['images']);
                $array_values []= $element['marketing_price'];
                $array_values []= $element['min_ozon_price'];
                $array_values []= $element['old_price'];
                $array_values []= $element['premium_price'];
                $array_values []= $element['price'];
                $array_values []= $element['recommended_price'];
                $array_values []= $element['min_price'];
                $array_values []= implode("\n", $element['sources']);
                $array_values []= $element['stocks']['coming'] ?? "";
                $array_values []= $element['stocks']['present'] ?? "";
                $array_values []= $element['stocks']['reserved'] ?? "";
                $array_values []= implode("\n", $element['errors']);
                $array_values []= $element['vat'];
                $array_values []= $element['visible'];
                $array_values []= $element['visibility_details']['has_price'] ? 1 : 0;
                $array_values []= $element['visibility_details']['has_stock'] ? 1 : 0;
                $array_values []= $element['visibility_details']['active_product'] ? 1 : 0;
                $array_values []= $element['price_index'];

                $array_values []= $element['commissions'][0]['percent'] ?? "";
                $array_values []= $element['commissions'][0]['min_value'] ?? "";
                $array_values []= $element['commissions'][0]['value'] ?? "";
                $array_values []= $element['commissions'][0]['sale_schema'] ?? "";
                $array_values []= $element['commissions'][0]['delivery_amount'] ?? "";
                $array_values []= $element['commissions'][0]['return_amount'] ?? "";

                $array_values []= $element['commissions'][1]['percent'] ?? "";
                $array_values []= $element['commissions'][1]['min_value'] ?? "";
                $array_values []= $element['commissions'][1]['value'] ?? "";
                $array_values []= $element['commissions'][1]['sale_schema'] ?? "";
                $array_values []= $element['commissions'][1]['delivery_amount'] ?? "";
                $array_values []= $element['commissions'][1]['return_amount'] ?? "";

                $array_values []= $element['commissions'][2]['percent'] ?? "";
                $array_values []= $element['commissions'][2]['min_value'] ?? "";
                $array_values []= $element['commissions'][2]['value'] ?? "";
                $array_values []= $element['commissions'][2]['sale_schema'] ?? "";
                $array_values []= $element['commissions'][2]['delivery_amount'] ?? "";
                $array_values []= $element['commissions'][2]['return_amount'] ?? "";

                $array_values []= $element['commissions'][3]['percent'] ?? "";
                $array_values []= $element['commissions'][3]['min_value'] ?? "";
                $array_values []= $element['commissions'][3]['value'] ?? "";
                $array_values []= $element['commissions'][3]['sale_schema'] ?? "";
                $array_values []= $element['commissions'][3]['delivery_amount'] ?? "";
                $array_values []= $element['commissions'][3]['return_amount'] ?? "";

                $array_values []= $element['volume_weight'];
                $array_values []= $element['is_prepayment'] ? 1 : 0;
                $array_values []= $element['is_prepayment_allowed'] ? 1 : 0;
                $array_values []= implode("\n", $element['images360']);
                $array_values []= $element['color_image'];
                $array_values []= $element['primary_image'];

                $array_values []= $element['status']['state'] ?? "";
                $array_values []= $element['status']['state_failed'] ?? "";
                $array_values []= $element['status']['moderate_status'] ?? "";
                $array_values []= implode("\n", $element['status']['decline_reasons'] ?? "");
                $array_values []= $element['status']['validation_state'] ?? "";
                $array_values []= $element['status']['state_name'] ?? "";
                $array_values []= $element['status']['state_description'] ?? "";
                $array_values []= $element['status']['is_failed'] ? 1 : 0;
                $array_values []= $element['status']['is_created'] ? 1 : 0;
                $array_values []= $element['status']['state_tooltip'] ?? "";

                $array_values []= $element['status']['item_errors']['code'] ?? "";
                $array_values []= $element['status']['item_errors']['field'] ?? "";
                $array_values []= $element['status']['item_errors']['attribute_id'] ?? "";
                $array_values []= $element['status']['item_errors']['state'] ?? "";
                $array_values []= $element['status']['item_errors']['level'] ?? "";
                $array_values []= $element['status']['item_errors']['description'] ?? "";
                
                $array_values []= $element['status']['state_updated_at'] ?? "";

                $array_values []= $element['state'];
                $array_values []= $element['service_type'];
                $array_values []= $element['fbo_sku'];
                $array_values []= $element['fbs_sku'];
                $array_values []= $element['currency_code'];
                $array_values []= $element['is_kgt'] ? 1 : 0;

                $array_values []= $element['discounted_stocks']['coming'] ?? "";
                $array_values []= $element['discounted_stocks']['present'] ?? "";
                $array_values []= $element['discounted_stocks']['reserved'] ?? "";

                $array_values []= $element['is_discounted'] ? 1 : 0;
                $array_values []= $element['has_discounted_item'] ? 1 : 0;
                $array_values []= implode("\n", $element['barcodes']);
                $array_values []= $element['updated_at'];
                $array_values []= $element['price_indexes']['price_index'];
                $array_values []= $element['price_indexes']['external_index_data']['minimal_price'] ?? "";
                $array_values []= $element['price_indexes']['external_index_data']['minimal_price_currency'] ?? "";
                $array_values []= $element['price_indexes']['external_index_data']['price_index_value'] ?? "";
                $array_values []= $element['price_indexes']['ozon_index_data']['minimal_price'] ?? "";
                $array_values []= $element['price_indexes']['ozon_index_data']['minimal_price_currency'] ?? "";
                $array_values []= $element['price_indexes']['ozon_index_data']['price_index_value'] ?? "";
                $array_values []= $element['price_indexes']['self_marketplaces_index_data']['minimal_price'] ?? "";
                $array_values []= $element['price_indexes']['self_marketplaces_index_data']['minimal_price_currency'] ?? "";
                $array_values []= $element['price_indexes']['self_marketplaces_index_data']['price_index_value'] ?? "";
                $array_values []= $element['sku'];
                $array_values []= $element['description_category_id'];
                $array_values []= $element['type_id'];
                $array_values []= $element['is_archived'] ? 1 : 0;
                $array_values []= $element['is_autoarchived'] ? 1 : 0;

                $count += 1;

                $array_rows []= "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            }

            $sql .= implode(",\n", $array_rows);

            $logger->log("$sql");

            $pdo->prepare($sql)->execute($array_values);

            echo "<p style='color: green;'>Таблица заполнена успешно CTL_OzonSellerProductInfo</p>";
        }
        catch(Throwable $exception) {
            echo "<p style='color: red;'>Исключение</p>";
            echo "<p style='color: red;'>$exception</p>";
            $logger->log("$exception");
        }
    }
}
