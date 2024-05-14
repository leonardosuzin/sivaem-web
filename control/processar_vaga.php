<?php

require __DIR__ . '/../vendor/autoload.php';

$model = new VagaModel();
$vagas;


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $cargo = $_GET['cargo'] ?? '';
    $tipo_user = $_SESSION['tipo_user'];
    if($cargo == null &&  $_SESSION['tipo_user'] == 2){
        $vagas = $model -> buscarVagasPorId();
        echo json_encode($vagas);
    }else{
        $vagas = $model -> buscarVagasPorCargo($cargo);
        echo json_encode($vagas);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cargo = $_POST['cargo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $salario = $_POST['salario'] ?? '';

    if (strlen($descricao) > 255){
        echo "A descrição é muito longa!";
    } elseif (strlen($cargo) > 20){
        echo "O nome do cargo é muito longoo";
    } elseif (strlen($descricao) < 5){
        echo "A descrição é muito curta!";
    } elseif (strlen($cargo) < 2){
        echo "O nome do cargo é muito curto";
    } elseif (!is_numeric($salario)){
        echo "O valor do salário não é numérico";
    } else{
        $vagas = $model -> adicionarVaga($descricao, $cargo, $salario);
        echo "Adicionado com sucesso!";
    }
        
}


if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Ler o corpo da requisição como JSON
    $json_str = file_get_contents('php://input');
    // Decodificar o JSON para um array associativo
    $input = json_decode($json_str, true);
    // Verificar se o JSON foi decodificado corretamente
    if ($input === null) {
        // O JSON não pôde ser decodificado
        echo "Erro ao decodificar JSON";
        exit;
    }
    // Extrair os dados do array associativo
    $vagaId = $input['vaga_id'] ?? '';
    $descricao = $input['descricao'] ?? '';
    $cargo = $input['cargo'] ?? '';
    $salario = $input['salario'] ?? '';


    if(!is_numeric($vagaId)){
        echo "O id não é numérico!";
    }elseif (strlen($descricao) > 255){
        echo "A descrição é muito longa!";
    } elseif (strlen($cargo) > 20){
        echo "O nome do cargo é muito longo!";
    } elseif (strlen($descricao) < 5){
        echo "A descrição é muito curta!";
    } elseif (strlen($cargo) < 2){
        echo "O nome do cargo é muito curto!";
    } elseif (!is_numeric($salario)){
        echo "O valor do salário não é numérico!";
    } else{
        $vagas = $model -> atualizarVaga($vagaId, $descricao, $cargo, $salario);
        echo $vagas;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $vagaId = $_GET['vaga_id'] ?? '';

    if ($vagaId == '') {
        echo "ID da vaga não fornecido!";
    } else {
        $resposta = $model->excluirVaga($vagaId); 
        echo $resposta;
    }
}
?>