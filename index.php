<!-- login_empresa.php -->
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos foram preenchidos
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Verificar as credenciais
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verificar se as credenciais são válidas para a empresa
        if ($username === 'empresa' && $password === '123456') {
            // Credenciais válidas, iniciar sessão e redirecionar para a página de cadastro de vaga
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: /sivaem-web-main/view/adicionar_vaga.php");
            exit;
        } else {
            // Verificar se as credenciais são válidas para o candidato
            if ($username === 'candidato' && $password === '123456') {
                // Credenciais válidas, iniciar sessão e redirecionar para a página de busca de vagas
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: /sivaem-web-main/view/busca_vagas.php");
                exit;
            } else {
                // Credenciais inválidas, exibir mensagem de erro
                $error = "Nome de usuário ou senha incorretos!";
                
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    </head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <div class="d-flex align-content-center flex-wrap">
            <div class="mx-auto p-3" style="width: 300px;">
                    <h3>Login</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table>
                <tr>
                    <td><br><input type="text" id="username" name="username" required placeholder="Usuário" ></td>
                </tr>
                <tr>
                    <td><br><input type="password" id="password" name="password" required placeholder="Senha"></td>
                </tr>
                <tr><td>
                    <br>
                    <input type="submit" class="btn btn-info" value="Login">
                    <a href="/sivaem-web-main/view/registro.php"><input type="button" class="btn btn-outline-primary" value="Cadastre-se"></a>
                </td>
                </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
    <footer>
        <div class="fixed-bottom">
			<div class="p-1 mb-0">
				<div class="text-black bg-info">
					<div class="text-center"> 
                        Ellen Woellner / Leonardo Suzin / Vinícius Souza - UTFPR 2024 ©
					</div>
				</div>
			</div>
		</div>
    </footer>
</div>
</body>
</html>