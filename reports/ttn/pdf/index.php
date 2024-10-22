<?php
$HOME = $_SERVER['DOCUMENT_ROOT'];

try {
    include "$HOME/_class/OzonSeller__PostingFbsActList.class.php";
    
    $id = '';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    else {
        exit;
    }

    $filename = 'document.pdf';
    if (isset($_GET['filename'])) {
        $filename = $_GET['filename'];
    }
    
    $OzonSeller__PostingFbsActList = new OzonSeller__PostingFbsActList();
    $OzonSeller__PostingFbsActList->fetchJson__downloadPdf($id, $filename);
}
catch(Throwable $exception) {
    echo "<pre style='color: red;'>$exception</pre>";
}
