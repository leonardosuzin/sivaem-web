<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'site_vagas');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coletar os dados do formulário
$descricao = $_POST['descricao'];
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];

// Inserir a nova vaga no banco de dados
$sql = "INSERT INTO vagas (descricao, cargo, salario) VALUES ('$descricao', '$cargo', '$salario')";
if ($conn->query($sql) === TRUE) {
    echo "Vaga adicionada com sucesso!";
} else {
    echo "Erro ao adicionar vaga: " . $conn->error;
}

// Fechar conexão com o banco de dados
$conn->close();
?>
