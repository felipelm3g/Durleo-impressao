<?php

date_default_timezone_set('America/Fortaleza');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST");
//header('Content-type: application/json');

require 'class/vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

//$codigo = $_POST["pedido"];
$codigo = "3778233200018520201014A03";
$empresa = substr($codigo, 0, 14);
$pedido = substr($codigo, 14, 11);
$nomeimpress = "ELGINi9";
$data = date('d/m/Y');
$hora = date('H:i:s');

try {

    $url1 = "https://menu.durleo.com.br/api/pedido.php?id=" . $codigo;
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_URL, $url1);
    $result1 = curl_exec($ch1);
    curl_close($ch1);
    $infos = json_decode($result1, true);

    $url2 = "https://menu.durleo.com.br/api/produtos.php?emp=" . $empresa;
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_URL, $url2);
    $result2 = curl_exec($ch2);
    curl_close($ch2);
    $prods = json_decode($result2, true);

    $connector = new WindowsPrintConnector($nomeimpress);
    $printer = new Printer($connector);

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("Pedido - {$pedido}\n");
    $printer->text("\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    foreach ($infos['ITN'] as $i) {
        foreach ($prods as $p) {
            if ($i['ITN_PROD'] == $p['PRD_ID']) {
                $printer->text(intval($i['ITN_QNT']) . "x " . $p["PRD_NOM"] . "\n");
            }
        }
    }
    $printer->text("\n");
    $printer->text("Observação: {$infos["PED"]["PED_OBS"]}\n");
    $printer->text("\n");
    $printer->text("Nome: {$infos["PED"]["PED_NOM"]}\n");
    $printer->text("Tel: {$infos["PED"]["PED_TEL"]}\n");
    $printer->text("End: {$infos["PED"]["PED_END"]}\n");
    switch ($infos["PED"]["PED_PAG"]) {
        case "0":
            $printer->text("Pagamento: Dinheiro\n");
            break;
        case "1":
            $printer->text("Pagamento: Cartão\n");
            break;
    }
    $printer->text("Valor R$ {$infos["PED"]["PED_VLR"]}\n");
    $printer->text("\n");
    $printer->text("\n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("{$data} - {$hora}\n");
    $printer->text("\n");
    $printer->text("\n");
    $printer->text("\n");
    $printer->cut();
    $printer->close();

    echo json_encode(true);
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    //echo json_encode(false);
}
?>
