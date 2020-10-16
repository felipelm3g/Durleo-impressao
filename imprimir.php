<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST");
header('Content-type: application/json');

require 'class/vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

//$pedido = $_POST["pedido"];
$nomeimpress = "ELGINi9";

try {

    $connector = new WindowsPrintConnector($nomeimpress);
    $printer = new Printer($connector);
    $printer->text("Pedido\n");
    $printer->cut();
    $printer->close();
    
    echo json_encode(true);
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    //echo json_encode(false);
}

?>
