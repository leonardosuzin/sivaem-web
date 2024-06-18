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
                <form id="loginForm">
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
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário

            // Obter os valores dos campos de entrada
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            // Construir o objeto de dados a ser enviado como JSON
            var data = {
                username: username,
                password: password
            };

            // Enviar a requisição para a rota de login API Laravel
            fetch('http://127.0.0.1:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Verificar a estrutura da resposta no console

                if (data.access_token) {
                    // Armazenar o token recebido na sessionStorage
                    sessionStorage.setItem('auth_token', data.access_token);

                    // Redirecionar para a página adequada com base no tipo de usuário
                    if (data.tipo_usuario == 1) {
                        window.location.href = '/sivaem-web-main/view/adicionar_curriculo.php';
                    } else if (data.tipo_usuario == 2) {
                        window.location.href = '/sivaem-web-main/view/adicionar_vaga.php';
                    } else {
                        console.error('Tipo de usuário desconhecido:', data.tipo_usuario);
                    }
                } else {
                    console.error('Token não recebido ou inválido.');
                    alert('Falha no login. Verifique suas credenciais.');
                }
            })
            .catch(error => {
                console.error('Erro ao processar requisição:', error);
                alert('Erro ao processar requisição. Por favor, tente novamente mais tarde.');
            });
        });
    </script>

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
