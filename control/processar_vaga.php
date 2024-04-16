<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'site_vagas');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
// Coletar os dados do formulário
$descricao = $_POST['descricao'];
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];

// Verifica se os campos são válidos
if (strlen($descricao) > 255){
    echo "A descrição é muito longa!";
}elseif(strlen($cargo) > 20){
    echo "O nome do cargo é muito longoo";
}elseif (strlen($descricao) < 5){
    echo "A descrição é muito curta!";
}elseif(strlen($cargo) < 2){
    echo "O nome do cargo é muito curto";
}elseif(is_numeric($salario) == false){
    echo "O valor do salário não é numérico";
}else {
    // Inserir a nova vaga no banco de dados
    $sql = "INSERT INTO vaga (descricao, cargo, salario) VALUES ('$descricao', '$cargo', '$salario')";
    if ($conn->query($sql) === TRUE) {
        echo "Vaga adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar vaga: " . $conn->error;
    }
}

}

//receber informações das vagas
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cargo'])) {
    // Conectar ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'site_vagas');
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Recuperar vagas do banco de dados com base no cargo fornecido
    $cargo = $_GET['cargo'];
    $sql = "SELECT * FROM vaga WHERE cargo LIKE '%$cargo%'";
    $result = $conn->query($sql);
    // Exibir vagas encontradas
    if ($result->num_rows > 0) {
        echo "<h3>Vagas Encontradas:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "<br>";
            echo "<strong>Cargo:</strong> " . $row['cargo'] . "<br>";
            echo "<strong>Salário:</strong> " . $row['salario'] . "</p>";
        }
    } else {
        echo "<p>Nenhuma vaga encontrada.</p>";
    }

}


// Editar as vagas
// Verifica se a requisição é do tipo PUT
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


    // Verifica se os campos são válidos
    if (strlen($descricao) > 255) {
        echo "A descrição é muito longa!";
    } elseif (strlen($cargo) > 20) {
        echo "O nome do cargo é muito longo!";
    } elseif (strlen($descricao) < 5) {
        echo "A descrição é muito curta!";
    } elseif (strlen($cargo) < 2) {
        echo "O nome do cargo é muito curto!";
    } elseif (!is_numeric($salario)) {
        echo "O valor do salário não é numérico!";
    } else {
        $sql = "UPDATE vaga SET descricao='$descricao', cargo='$cargo', salario='$salario' WHERE vaga_id=$vagaId";
        if ($conn->query($sql) === TRUE) {
            echo "Vaga atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar vaga: " . $conn->error;
        }
    }
}

// Fechar conexão com o banco de dados
$conn->close();
?>
