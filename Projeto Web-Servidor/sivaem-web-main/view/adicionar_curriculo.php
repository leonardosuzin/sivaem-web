<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Adicionar Currículo</title>
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
        <h2>Adicionar Currículo</h2>
        <form id="formAdicionarCurr">    
            <label for="descricao">Perfil pessoal:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br><br>
            <label for="cargo">Cargo desejado:</label><br>
            <input type="text" id="cargo" name="cargo" required><br><br>
            <label for="experiencias">Experiências Anteriores:</label><br>
            <textarea id="experiencias" name="experiencias" required></textarea><br><br>
            <label for="salario">Salário desejado:</label><br>
            <input type="text" id="salario" name="salario" required><br><br>
            <button type="submit" id="btnAdicionar" class="btn btn-info">Adicionar Currículo</button>
        </form>

        <p></p>
        <a href="/sivaem-web-main/view/alterar_curriculo.php"><input type="button" class="btn btn-outline-success" value="Alterar Currículo"></a>
        <a href="/sivaem-web-main/view/excluir_curriculo.php"><input type="button" class="btn btn-outline-warning" value="Excluir Currículo"></a>
        <a href="/sivaem-web-main/view/busca_vagas.php"><input type="button" class="btn btn-outline-info" value="Buscar Vagas"></a>
        <div id="resultadoAdicionarCurriculo"></div>
        <p></p>
        <a href="/sivaem-web-main/control/logout.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
        <div id="resultadoBuscarCurriculos"></div>
        <p></p>
    </div>
    <?php include "footer.php";?>

    <script>
        document.getElementById('formAdicionarCurr').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Obter os valores dos campos de entrada
            const descricao = document.getElementById('descricao').value;
            const cargo = document.getElementById('cargo').value;
            const experiencias = document.getElementById('experiencias').value;
            const salario = document.getElementById('salario').value;

            // Construir o objeto de dados a ser enviado como JSON
            const data = {
                descricao: descricao,
                cargo: cargo,
                experiencia: experiencias,
                salario: salario
            };

            // Obter o token salvo na sessionStorage
            const token = sessionStorage.getItem('auth_token');

            // Verificar se o token está presente
            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Erro ao adicionar currículo. Por favor, realize o login novamente.');
                return;
            }

            // Enviar a requisição para a rota de adicionar currículo API Laravel
            fetch('http://127.0.0.1:8000/api/curriculos', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                document.getElementById('resultadoAdicionarCurriculo').innerText = data.message;
            })
            .catch(error => {
                console.error('Erro ao adicionar currículo:', error);
                alert('Erro ao adicionar currículo. Por favor, tente novamente.');
            });
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
