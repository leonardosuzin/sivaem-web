<?php

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "site_vagas");

    // Verifica se houve erro na conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Preparar e executar a inserção do currículo
    $descricao = $_POST['descricao'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $experiencias = $_POST['experiencias'] ?? '';
    $salario = $_POST['salario'] ?? '';


    if (strlen($descricao) > 255) {
        echo "O perfil pessoal é muito longo!";
    } elseif (strlen($cargo) > 20) {
        echo "O nome do cargo é muito longo!";
    } elseif (strlen($descricao) < 5) {
        echo "Preencha o perfil pessoal!";
    } elseif (strlen($cargo) < 2) {
        echo "O nome do cargo é muito curto!";
    }elseif (strlen($experiencias) > 255) {
        echo "O campo de experiencias excedeu o limite de caracteres!";
    }elseif (!is_numeric($salario)) {
        echo "O valor do salário não é numérico!";
    }else{
        $stmt = $conexao->prepare("INSERT INTO curriculo (descricao, cargo, experiencia, salario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $descricao, $cargo, $experiencias, $salario);
    
        if ($stmt->execute()) {
            echo "Currículo adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar currículo: " . $stmt->error;
        }
        $stmt->close();
         $conexao->close();
    }
   

    // Fechar a conexão
    
}
?>