<?php
require_once 'CsvProcessor.php';

if (isset($_FILES['csv_file']) && isset($_POST['delimiter'])) {
    $csvPath    = $_FILES['csv_file']['tmp_name'];
    $delimiter  = $_POST['delimiter'];

    $csvProcessor   = new CsvProcessor($csvPath, $delimiter);
    $returnProducts = $csvProcessor->processFile();

    echo json_encode(['success' => true, 'products' => $returnProducts], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['success' => false, 'products' => $products]);
exit;
