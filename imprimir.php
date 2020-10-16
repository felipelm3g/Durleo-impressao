<?php
date_default_timezone_set('America/Fortaleza');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST");
header('Content-type: application/json');

require 'class/vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$codigo = $_POST["pedido"];
$pedido = substr($codigo, 14, 11);
$nomeimpress = "ELGINi9";
$data = date('d/m/Y');
$hora = date('H:i:s');

try {

    $connector = new WindowsPrintConnector($nomeimpress);
    $printer = new Printer($connector);
    
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("Pedido - {$pedido}\n");
    $printer->text("\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("1x Calabresa\n");
    $printer->text("1x Calabresa\n");
    $printer->text("1x Calabresa\n");
    $printer->text("\n");
    $printer->text("Observação: Isso é uma observação grande precisamos ver como é o comportamento dessa linha no ticket\n");
    $printer->text("\n");
    $printer->text("Nome: Felipe Lopes\n");
    $printer->text("Tel: 81 995285816\n");
    $printer->text("End: Rua João Luiz Santiago, 647\n");
    $printer->text("Pagamento: Cartão\n");
    $printer->text("Valor R$10.00\n");
    $printer->text("\n");
    $printer->text("\n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("{$data} - {$hora}\n");
    $printer->text("\n");
    $printer->text("\n");
    $printer->text("\n");
//    $printer->text("\n");
    $printer->cut();
    $printer->close();
    
    echo json_encode(true);
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    //echo json_encode(false);
}

?>
