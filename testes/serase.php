<?php
// endpoint.php
// Configuração dos cabeçalhos CORS
header("Access-Control-Allow-Origin: *"); // Permitir solicitações de qualquer origem
header("Access-Control-Allow-Methods: POST, OPTIONS, GET"); // Permitir métodos POST e OPTIONS
header("Access-Control-Allow-Headers: Content-Type"); // Permitir cabeçalhos Content-Type

// Verifica se a solicitação é do tipo OPTIONS (pré-voo) e retorna com status 200
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados enviados via POST
    $data = json_decode(file_get_contents('php://input'), true);
    // Verifica se os dados foram recebidos corretamente
    if (isset($data['name']) && isset($data['email'])) {
        $name = $data['name'];
        $email = $data['email'];

        // Aqui você pode fazer o que quiser com os dados, por exemplo, salvar em um banco de dados
        // Neste exemplo, apenas estamos imprimindo os dados recebidos
        echo "Nome25: $name, Email: $email";
    } else {
        http_response_code(400); // Bad Request
        echo "Dados inválidos";
    }
} else {
    http_response_code(405); // Método não permitido
    echo "Método não permitido";
}
?>
