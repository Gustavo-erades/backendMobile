<?php 
$selectAnestesicos = $conn->query("SELECT * FROM anestesicoTabela WHERE anestesicoLocal='Bupivacaína 0.5%'");
$anestesicosTabela = $selectAnestesicos->fetchAll(PDO::FETCH_ASSOC);
$dadosBdJson=json_encode($anestesicosTabela);
// separa os dados para efetuar o calculo
$dadosArray=json_decode($dadosBdJson,true);
if ($dadosArray === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Erro ao decodificar o JSON: " . json_last_error_msg();
} else {
    $anestesicoLocal=$dadosArray[0]['anestesicoLocal'];
    $doseMaxima=floatval($dadosArray[0]['doseMaxima']);
    $maximoAbsoluto=floatval($dadosArray[0]['maximoAbsoluto']);
    $numTubetes=floatval($dadosArray[0]['numTubetes']);
    $porcentagem=floatval($dadosArray[0]['porcentagem']);
}
