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
                <form id="loginForm" action="/sivaem-web-main/control/processar_login.php" method="POST">
                    <table>
                        <tr>
                            <td><br><input type="text" id="username" name="username" required placeholder="Usuário"></td>
                        </tr>
                        <tr>
                            <td><br><input type="password" id="password" name="password" required placeholder="Senha"></td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <button type="submit" class="btn btn-info">Login</button>
                                <a href="/sivaem-web-main/view/registro.php"><button type="button" class="btn btn-outline-primary">Cadastre-se</button></a>
                            </td>
                        </tr>
                    </table>
                </form>
                
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formRegistroUsuario').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulári
        })
    </script>>
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
</body>
</html>
