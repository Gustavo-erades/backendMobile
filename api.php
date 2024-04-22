<?php
// insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Prilocaína 3%",6,400,7.4,3);
//importo a conexão com o banco de dados
include_once "connBanco.php";
//importo o arquivo que retira os dados do banco e separa eles
include_once "trataDados.php";
//importo as variáveis do banco $bancojson
include_once "varBanco.php";
//importo as variáveis do cálculo $calculoJson
include_once "boxCalculo.php";
// Definir cabeçalhos CORS 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Permitir solicitações de qualquer origem
header("Access-Control-Allow-Methods: POST, OPTIONS, GET"); // Permitir métodos POST, OPTIONS, GET
header("Access-Control-Allow-Headers: Content-Type"); // Permitir cabeçalhos Content-Type
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
if($_SERVER['REQUEST_METHOD']=='GET'){
    if (isset($_GET['action'])) {
        if($_GET['action']=='boxCalculo'){
            echo $calculoJson;
        }elseif($_GET['action']=='varBanco'){
            echo $bancojson;
        }
    } else {
        echo 'Método não permitido (GET)';
    }    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['peso']) && isset($data['quantMax']) && isset($data['volTubete'])) {
        $peso = $data['peso'];
        $quantMax = $data['quantMax'];
        $volTubete = $data['volTubete'];
        echo "peso: $peso, quantMax: $quantMax, volTubete: $volTubete, ";
    }
    if (isset($data['nomeAnestesico'])) {
        $nomeAnestesicoArray = implode($data['nomeAnestesico']);
        $nomeAnestesico=preg_replace('/\%\d+/', '%', $nomeAnestesicoArray);
        echo "Anestésico Local: ".$nomeAnestesico."";
    }
}

