<?php

require __DIR__ . '/../vendor/autoload.php';

require_once 'C:\xampp\htdocs\sivaem-web-main\models\curriculo_model.php'; 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $curModel = new CurriculoModel();
    // Verificar se o parâmetro de consulta 'cargo' está presente
    if (isset($_GET['cargo'])) {
        // Recuperar currículos com base no nome do cargo
        
        $cargo = $_GET['cargo'];

        $curriculos = $curModel->buscarCurriculosPorCargo($cargo);
        echo json_encode($curriculos);
    } else {
        // Se 'cargo' não estiver presente, assumimos que o usuário deseja recuperar seus próprios currículos
        $curriculos = $curModel->buscarCurriculosPorNome();
        echo json_encode($curriculos);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Lê o corpo da requisição como string
    $input_str = file_get_contents('php://input');
    // Decodifica a string para um array associativo
    parse_str($input_str, $input);
    
    // Extrai os dados do array associativo
    $curriculoId = $input['curriculo_id'] ?? '';
    $descricao = $input['descricao'] ?? '';
    $cargo = $input['cargo'] ?? '';
    $experiencia = $input['experiencia'] ?? '';
    $salario = $input['salario'] ?? '';

    if(!is_numeric($curriculoId)){
        echo "O id não é numérico!";
    }elseif (strlen($descricao) > 255){
        echo "A descrição é muito longa!";
    } elseif (strlen($cargo) > 255){
        echo "O nome do cargo é muito longo!";
    } elseif (strlen($experiencia) > 255){
        echo "A experiência é muito longa!";
    } elseif (strlen($descricao) < 5){
        echo "A descrição é muito curta!";
    } elseif (strlen($cargo) < 2){
        echo "O nome do cargo é muito curto!";
    } elseif (!is_numeric($salario)){
        echo "O valor do salário não é numérico!";
    } else{
        $model = new CurriculoModel(); // Supondo que CurriculoModel seja a classe que lida com as operações do banco de dados para os currículos
        $resultado = $model->atualizarCurriculo($curriculoId, $descricao, $cargo, $experiencia, $salario);
        echo $resultado;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $curriculoId = $_DELETE['curriculo_id'] ?? '';

    if ($curriculoId == '') {
        echo "ID do currículo não fornecido!";
    } else {
        $curModel = new CurriculoModel();
        $resposta = $curModel->excluirCurriculo($curriculoId);
        echo $resposta;
    }
}

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $descricao = $_POST['descricao'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $experiencias = $_POST['experiencias'] ?? '';
    $salario = $_POST['salario'] ?? '';

    if ($descricao == null || $cargo == null || $experiencias == null || $salario == null){
        echo "Preencha todos os campos com dados";
    }elseif (strlen($descricao) > 255) {
        echo "O perfil pessoal é muito longo!";
    } elseif (strlen($cargo) > 20) {
        echo "O nome do cargo é muito longo!";
    } elseif (strlen($descricao) < 5) {
        echo "Preencha o perfil pessoal!";
    } elseif (strlen($cargo) < 2) {
        echo "O nome do cargo é muito curto!";
    } elseif (strlen($experiencias) > 255) {
        echo "O campo de experiencias excedeu o limite de caracteres!";
    } elseif (!is_numeric($salario)) {
        echo "O valor do salário não é numérico!";
    } else {
        $curModel = new CurriculoModel($descricao, $cargo, $experiencias, $salario);

        $curModel->adicionarCurriculo($descricao, $cargo, $experiencias, $salario);
    }
    
   
}
?>