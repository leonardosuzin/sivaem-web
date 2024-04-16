<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos foram preenchidos
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['tipo_usuario'])) {
        // Verificar as credenciais no banco de dados
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tipo_usuario = $_POST['tipo_usuario']; // Corrigido para corresponder ao nome da coluna no banco de dados

        // Conectar ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'site_vagas');
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Criptografar a senha antes de inserir no banco de dados
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar e executar a consulta SQL para inserir o novo usuário
        $stmt = $conn->prepare("INSERT INTO usuario (username, password, tipo_usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $tipo_usuario);
        $stmt->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($stmt->affected_rows > 0) {
            echo "Novo usuário registrado com sucesso!";
        } else {
            echo "Erro ao registrar novo usuário: " . $conn->error;
        }

        // Fechar a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }
}
?>
