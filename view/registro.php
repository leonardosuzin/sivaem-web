<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <!-- Barra de navegação -->
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    
    <div class="container px-4 text-center">
        <div class="d-flex align-content-center flex-wrap">
            <div class="mx-auto p-3" style="width: 300px;">
                <h3>Registro de Novo Usuário</h3>
                
                <!-- Formulário de registro de novo usuário -->
                <form id="formRegistroUsuario" method="post" action="/sivaem-web-main/control/processar_registro.php">
                    <table class="table table-borderless">
                        <tbody>
                            <!-- Campo de entrada para o nome de usuário -->
                            <tr>
                                <td><input type="text" id="username" name="username" required placeholder="Nome de usuário"><br><br></td>
                            </tr>
                            <!-- Campo de entrada para a senha -->
                            <tr>
                                <td><input type="password" id="password" name="password" required placeholder="Senha"><br><br></td>
                            </tr>
                            <!-- Seleção do tipo de usuário -->
                            <tr>
                                <td>
                                    <label for="tipo_usuario"><h3>Tipo de Usuário:</h3></label>
                                    <div class="form-check">
                                        <!-- Radiobutton exclusivo para Candidato -->
                                        <input class="form-check-input" type="radio" name="tipo_usuario" id="selectCandidato" value="1" checked>
                                        <label class="form-check-label" for="selectCandidato">Candidato</label>
                                    </div>
                                    <div class="form-check">
                                        <!-- Radiobutton exclusivo para Empresa -->
                                        <input class="form-check-input" type="radio" name="tipo_usuario" id="selectEmpresa" value="2">
                                        <label class="form-check-label" for="selectEmpresa">Empresa</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Botões para enviar o formulário ou cancelar -->
                    <input type="submit" class="btn btn-info" value="Registrar">
                    <a href="/sivaem-web-main/index.php"><input type="button" class="btn btn-outline-danger" value="Cancelar"></a>
                </form>
                
                <!-- Div para exibir o resultado do registro -->
                <div id="resultadoRegistroUsuario"></div>
            </div>
        </div>
    </div>

    <!-- Script para enviar o formulário via AJAX -->
    <script>
        document.getElementById('formRegistroUsuario').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário
            
            // Obtém os dados do formulário
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var tipo_usuario = document.querySelector('input[name="tipo_usuario"]:checked').value;
            
            // Cria uma nova solicitação AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Exibe o resultado na div correspondente
                        document.getElementById('resultadoRegistroUsuario').innerHTML = xhr.responseText;
                    } else {
                        console.error('Ocorreu um erro ao enviar a solicitação.');
                    }
                }
            };
            
            // Abre a conexão e envia os dados do formulário
            xhr.open("POST", "/sivaem-web-main/control/processar_registro.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&password=" + password + "&tipo_usuario=" + tipo_usuario);
        });
    </script>
    <?php include "footer.php";?>
</body>
</html>
