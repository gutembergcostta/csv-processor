<?php
require '../vendor/autoload.php';

use Services\CsvService;
use Controllers\ApiController;

if (isset($_FILES['file_upload']) && isset($_POST['delimiter'])) {
    $csvPath    = $_FILES['file_upload']['tmp_name'];
    $fileName   = $_FILES['file_upload']['name'];
    $delimiter  = $_POST['delimiter'];

    $csvService   = new CsvService($csvPath, $fileName, $delimiter);
    $controller = new ApiController($csvService);
    echo $controller->handleRequest();
}
