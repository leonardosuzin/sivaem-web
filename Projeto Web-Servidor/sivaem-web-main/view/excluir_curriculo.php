<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Currículo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .curriculo {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Excluir Currículo</h2>
        <form id="deleteForm">
            <div class="mb-3">
                <label for="curriculo_id" class="form-label">ID do Currículo:</label>
                <input type="text" class="form-control" id="curriculo_id" name="curriculo_id" required>
            </div>
            <button type="submit" class="btn btn-danger">Excluir</button>
            <a href="/sivaem-web-main/view/adicionar_curriculo.php" class="btn btn-outline-info">Voltar</a>
        </form>
        <div id="curriculos" class="mt-4"></div>
    </div>

    <?php include "footer.php";?>

    <script>
        // Função para buscar currículos sem um parâmetro específico
        function buscarCurriculosSemParametro() {
            const url = new URL("http://localhost:8000/api/curriculos");
            const token = sessionStorage.getItem('auth_token');

            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Por favor, realize o login novamente.');
                return;
            }

            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar currículos');
                }
                return response.json();
            })
            .then(data => {
                showCurriculos(data);
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                alert('Erro ao buscar currículos');
            });
        }

        // Função para exibir currículos
        function showCurriculos(data) {
            let curriculosHTML = "";
            if (data.length > 0) {
                data.forEach(curriculo => {
                    curriculosHTML += `<div class="border border-secondary rounded p-3 mb-3">
                        <p><strong>Id do Currículo:</strong> ${curriculo.id}</p>
                        <p><strong>Nome do Funcionário:</strong> ${curriculo.nome}</p>
                        <p><strong>Perfil do Funcionário:</strong> ${curriculo.descricao}</p>
                        <p><strong>Cargo Desejado:</strong> ${curriculo.cargo}</p>
                        <p><strong>Experiência Prévia:</strong> ${curriculo.experiencia}</p>
                        <p><strong>Salário Desejado:</strong> ${curriculo.salario}</p>
                    </div>`;
                });
            } else {
                curriculosHTML = "<p>Nenhum currículo encontrado.</p>";
            }
            document.getElementById('curriculos').innerHTML = curriculosHTML;
        }

        // Função para verificar sessão
        function verificarSessao() {
            const token = sessionStorage.getItem('auth_token');
            if (!token) {
                alert('Sessão expirada. Por favor, faça login novamente.');
                window.location.href = '/sivaem-web-main/view/login.php';
            }
        }

        // Chamando a função de busca ao carregar a página
        window.onload = function() {
            verificarSessao();
            buscarCurriculosSemParametro();
        };

        // Adicionando evento de submit ao formulário
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Obtém o valor do campo de ID do currículo
            const curriculo_id = document.getElementById('curriculo_id').value;
            
            // Obtém o token salvo na sessionStorage
            const token = sessionStorage.getItem('auth_token');

            // Verifica se o token está presente
            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Erro ao excluir currículo. Por favor, realize o login novamente.');
                return;
            }

            // Envia a requisição para a rota de exclusão de currículo na API Laravel
            fetch(`http://127.0.0.1:8000/api/curriculos/${curriculo_id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao excluir currículo');
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                document.getElementById('curriculo_id').value = ''; // Limpa o campo de ID após a exclusão
                buscarCurriculosSemParametro(); // Atualiza a lista de currículos
            })
            .catch(error => {
                console.error('Erro ao excluir currículo:', error);
                alert('Erro ao excluir currículo. Por favor, tente novamente.');
            });
        });
    </script>
</body>
</html>
