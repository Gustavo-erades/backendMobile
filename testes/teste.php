<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Recebe os dados enviados pelo aplicativo React Native
$data = json_decode(file_get_contents("php://input"));

// Verifica se o nome foi enviado
if (isset($data->name)) {
    // Adiciona "1" na frente do nome
    $modifiedName = "1" . $data->name;

    // Retorna o nome modificado como JSON
    echo json_encode(array("modifiedName" => $modifiedName));
} else {
    // Se o nome não foi enviado, retorna uma mensagem de erro
    echo json_encode(array("error" => "Nome não recebido"));
}

?>
