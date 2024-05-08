<?php
// insert into anestesicos.anestesicotabela(anestesicoLocal,doseMaxima,maximoAbsoluto,numTubetes,porcentagem) values("Prilocaína 3%",6,400,7.4,3);
//importo a conexão com o banco de dados
session_start();
$_SESSION['padrao']='Prilocaína 3%';
include_once "connBanco.php";
//importo o arquivo que retira os dados do banco e separa eles
include_once "trataDados.php";
//importo as variáveis do banco $bancojson
include_once "varBanco.php";
//importo as variáveis do cálculo $calculoJson
include_once "boxCalculo.php";
// Definir cabeçalhos CORS 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS, GET");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['peso']) && isset($data['quantMax']) && isset($data['volTubete'])) {
        $peso = $data['peso']?$data['peso']:60;
        $quantMax = $data['quantMax'];
        $volTubete = $data['volTubete']?$data['volTubete']:1.8;
        echo "peso: $peso, quantMax: $quantMax, volTubete: $volTubete";
        //define variáveis de sessão
        $_SESSION['pesoCalculoJson']=$peso;
        $_SESSION['quantMaxCalculoJson']=$quantMax;
        $_SESSION['volTubeteCalculoJson']=$volTubete;
        //sobrepõe o cálculo
        $mlPorTubete=floatval(number_format($_SESSION['porcentagem']*10,2))*number_format($_SESSION['volTubeteCalculoJson'],1);
        $maxDosePorPeso=floatval(number_format($quantMax*$_SESSION['pesoCalculoJson'],2));
        $quantTubete=ceil(number_format($maxDosePorPeso/$mlPorTubete,1));
        echo "\n*** APÓS O CÁLCULO ***";
        echo "\nml por tubete: $mlPorTubete, quantidade de tubete: $quantTubete, mg por kg: $quantMax, máximo para o paciente: $maxDosePorPeso";
        echo "\n*******************************";
        $arqArray=array('mlPorTubete'=>$mlPorTubete,
                            'maxDosePorPeso'=>$maxDosePorPeso,
                            'quantTubete'=>$quantTubete,
                            'pesoPaciente'=>$_SESSION['pesoCalculoJson'],
                            'volTubetePaciente'=>$_SESSION['volTubeteCalculoJson'],
                            'maxPorKg'=>$quantMax
    );
        $calculoJson= json_encode($arqArray);
        $_SESSION['calculoJson']=$calculoJson;
    }
    if (isset($data['nomeAnestesico'])) {
        $nomeAnestesicoArray = implode($data['nomeAnestesico']);
        $nomeAnestesico=preg_replace('/\%\d+/', '%', $nomeAnestesicoArray);
        echo "Anestésico Local: ".$nomeAnestesico."";
        //define variável de sessão
        $_SESSION['nomeAnestesico']=$nomeAnestesico;
        //sobrepõe consulta
        $selectAnestesicos = $conn->query("SELECT * FROM anestesicoTabela WHERE anestesicoLocal='".$_SESSION['nomeAnestesico']."'");
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
        $anestesicoLocal=$dadosArray[0]['anestesicoLocal'];
        $doseMaxima=floatval($dadosArray[0]['doseMaxima']);
        $maximoAbsoluto=floatval($dadosArray[0]['maximoAbsoluto']);
        $numTubetes=floatval($dadosArray[0]['numTubetes']);
        $porcentagem=floatval($dadosArray[0]['porcentagem']);
        $arqArrayBd=array(
            'anestesicoLocal'=>$anestesicoLocal,
            'doseMaxima'=>$doseMaxima,
            'maximoAbsoluto'=>$maximoAbsoluto,
            'numTubetes'=>$numTubetes,
            'porcentagem'=>$porcentagem,
        );
        $_SESSION['bancojson']=json_encode($arqArrayBd);
        $_SESSION['porcentagem']=$porcentagem;
    }
    if(isset($data['nome'])&&isset($data['doseMax'])&&isset($data['maxAbs'])&&isset($data['numTubete'])&&isset($data['porcentagem'])){
        echo "Dados para cadastro recebidos com sucesso!\n";
        echo "dados enviados: ".$data['nome'].", ".$data['doseMax'].", ".$data['maxAbs'].", ".$data['numTubete'].", ".$data['porcentagem']."";
        $stmt = $conn->prepare("INSERT INTO anestesicos.anestesicotabela (anestesicoLocal, doseMaxima, maximoAbsoluto, numTubetes, porcentagem) VALUES (:nome, :doseMax, :maxAbs, :numTubete, :porcentagem)");
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':doseMax', $data['doseMax']);
        $stmt->bindParam(':maxAbs', $data['maxAbs']);
        $stmt->bindParam(':numTubete', $data['numTubete']);
        $stmt->bindParam(':porcentagem', $data['porcentagem']);
        $stmt->execute();
    }
    if(isset($data['nomeRemover'])){
        echo "\nDados para deleção recebidos com sucesso!\n";
        echo "Nome do anestésico para deletar:".$data['nomeRemover']."";
        $stmt = $conn->prepare('DELETE FROM anestesicos.anestesicotabela WHERE anestesicoLocal = :nomeRemover');
        $stmt->bindParam(':nomeRemover', $data['nomeRemover']);
        $stmt->execute();
    }
}
if($_SERVER['REQUEST_METHOD']=='GET'){
    if (isset($_GET['action'])) {
        if($_GET['action']=='boxCalculo'){
            echo $_SESSION['calculoJson'];
        }elseif($_GET['action']=='varBanco'){
            echo $_SESSION['bancojson'];
        }elseif($_GET['action']=='nomeAnestesicoDropdown'){
            echo $_SESSION['nomeAnestesico'];
        }elseif($_GET['action']=='nomesDropdown'){
            $procuraNomes = $conn->query("SELECT anestesicoLocal FROM anestesicos.anestesicoTabela;");
            $anestesicosDrop = $procuraNomes->fetchAll(PDO::FETCH_ASSOC);
            $dadosBdNomes=json_encode($anestesicosDrop);
            echo "\tNOMES DO BANCO DE DADOS\n";
            echo $dadosBdNomes;
            $dadosNomesArray=json_decode($dadosBdNomes,true);
            if ($dadosNomesArray === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Erro ao decodificar o JSON: " . json_last_error_msg();
            } else {
                echo "\t\nTESTE\n";
                $arrayTeste=[];
                for($i=0;$i<count($dadosNomesArray);$i++){
                    $arrayTeste[$i]=$dadosNomesArray[$i]['anestesicoLocal'];
                    echo $arrayTeste[$i]."\n";
                }
                echo "\n*********************\n";
            }
            echo json_encode($arrayTeste);
        }else {
            echo 'Método não permitido (GET)';
        }    
    }
}
