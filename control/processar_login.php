<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos foram preenchidos
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Verificar as credenciais no banco de dados
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Conectar ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'site_vagas');
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Consultar o banco de dados para verificar as credenciais
        $stmt = $conn->prepare("SELECT username, password FROM usuario WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se o usuário existe e se a senha está correta
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // As credenciais estão corretas, iniciar sessão
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                
                // Redirecionar para a página de boas-vindas
                header("Location: welcome.php");
                exit;
            } else {
                $error = "Senha incorreta!";
            }
        } else {
            $error = "Nome de usuário não encontrado!";
        }

        // Fechar a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }
    // Se as credenciais não estiverem corretas
    $error = "Nome de usuário ou senha incorretos!";
}

// Se não houver postagem ou se houver erros, redirecione de volta para a página de login com uma mensagem de erro
header("Location: login.php?error=" . urlencode($error));
exit;
?>