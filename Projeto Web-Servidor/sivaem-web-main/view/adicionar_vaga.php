<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
            <button id="logoutBtn" class="btn btn-outline-danger">Logout</button>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Adicionar Vaga</h2>
        <form id="formAdicionarVaga">    
            <label for="descricao">Descrição:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br><br>
            <label for="cargo">Cargo:</label><br>
            <input type="text" id="cargo" name="cargo" required><br><br>
            <label for="salario">Salário:</label><br>
            <input type="text" id="salario" name="salario" required><br><br>
            <button type="submit" class="btn btn-info">Adicionar Vaga</button>
        </form>
        
        <div id="resultadoAdicionarVaga"></div>
        
        <p></p>
        <a href="/sivaem-web-main/view/editar_vaga.php"><input type="button" class="btn btn-outline-success" value="Editar Vaga"></a>
        <a href="/sivaem-web-main/view/busca_curriculo.php"><input type="button" class="btn btn-outline-info" value="Buscar Currículos"></a>
        <a href="/sivaem-web-main/view/excluir_vaga.php"><input type="button" class="btn btn-outline-warning" value="Excluir vaga"></a>
        <p></p>
        <a href="/sivaem-web-main/control/logout.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
    </div>
    <?php include "footer.php";?>

    <script>
        document.getElementById('formAdicionarVaga').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário
            
            // Obtém os dados do formulário
            var descricao = document.getElementById('descricao').value;
            var cargo = document.getElementById('cargo').value;
            var salario = document.getElementById('salario').value;
            
            // Obtém o token salvo na sessionStorage
            var token = sessionStorage.getItem('auth_token');
            
            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Por favor, realize o login novamente.');
                return;
            }

            // Cria uma nova solicitação AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Parse da resposta JSON
                        var response = JSON.parse(xhr.responseText);
                        
                        // Exibe o resultado na div correspondente
                        var mensagem = response.message || 'Vaga adicionada com sucesso!';
                        document.getElementById('resultadoAdicionarVaga').innerHTML = `
                            <div>
                                ${mensagem}
                            </div>`;
                        
                        // Limpa o formulário após o sucesso
                        document.getElementById('descricao').value = '';
                        document.getElementById('cargo').value = '';
                        document.getElementById('salario').value = '';
                    } else {
                        // Exibe mensagem de erro
                        var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'Erro ao adicionar vaga.';
                        document.getElementById('resultadoAdicionarVaga').innerHTML = `<div>${errorMessage}</div>`;
                    }
                }
            };
            
            // Abre a conexão e envia os dados do formulário
            xhr.open("POST", "http://127.0.0.1:8000/api/vagas", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("Authorization", "Bearer " + token);
            xhr.send(JSON.stringify({ descricao: descricao, cargo: cargo, salario: salario }));
        });

        // Função para fazer logout
        document.getElementById('logoutBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // Obter o token salvo na sessionStorage
            const token = sessionStorage.getItem('auth_token');

            // Verificar se o token está presente
            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Erro ao fazer logout. Por favor, realize o login novamente.');
                return;
            }

            // Enviar a requisição de logout para o servidor
            fetch('http://127.0.0.1:8000/api/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (response.ok) {
                    sessionStorage.removeItem('auth_token'); // Remover o token da sessionStorage
                    window.location.href = '/sivaem-web-main/view/login.php'; // Redirecionar para a página de login
                } else {
                    return response.json().then(data => {
                        console.error('Erro ao fazer logout:', data);
                        alert('Erro ao fazer logout. Por favor, tente novamente.');
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao fazer logout:', error);
                alert('Erro ao fazer logout. Por favor, tente novamente.');
            });
        });
    </script>
</body>
</html>
