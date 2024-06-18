<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Busca de Currículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Busca de Currículos</h2>
        <form id="formBusca">
            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" class="form-control">
            <button type="submit" class="btn btn-info mt-2">Buscar</button>
        </form>

        <div id="resultadoBusca" class="mt-4"></div>

        <div class="mt-4">
            <a href="/sivaem-web-main/view/adicionar_vaga.php" class="btn btn-outline-danger">Voltar</a>
        </div>
    </div>

    <?php include "footer.php";?>

    <script>
        // Função para buscar currículos sem um parâmetro específico
        function buscarCurriculosSemParametro() {
            const url = new URL("http://localhost:8000/api/curriculos");
            const token = sessionStorage.getItem('auth_token');

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
                showSearchResults(data);
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                displayError('Ocorreu um erro ao buscar os currículos.');
            });
        }

        // Carregar currículos automaticamente ao entrar na página
        window.onload = function() {
            buscarCurriculosSemParametro();
        };

        // Função para buscar currículos com base no cargo fornecido pelo usuário
        document.getElementById('formBusca').addEventListener('submit', function(event) {
            event.preventDefault();
            const cargo = document.getElementById('cargo').value;

            const url = new URL("http://localhost:8000/api/curriculos");
            const params = { cargo: cargo };
            url.search = new URLSearchParams(params).toString();

            const token = sessionStorage.getItem('auth_token');

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
                showSearchResults(data);
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                displayError('Ocorreu um erro ao buscar os currículos.');
            });
        });

        // Função para exibir os resultados da busca
        function showSearchResults(data) {
            let resultadoHTML = "";
            if (data.length > 0) {
                data.forEach(curriculo => {
                    resultadoHTML += `<div class="border border-secondary rounded p-3 mb-3">
                        <p><strong>Nome do funcionário:</strong> ${curriculo.nome}</p>
                        <p><strong>Perfil do funcionário:</strong> ${curriculo.descricao}</p>
                        <p><strong>Cargo desejado:</strong> ${curriculo.cargo}</p>
                        <p><strong>Experiência prévia:</strong> ${curriculo.experiencia}</p>
                        <p><strong>Salário desejado:</strong> ${curriculo.salario}</p>
                    </div>`;
                });
            } else {
                resultadoHTML = "<p>Nenhum currículo encontrado.</p>";
            }
            document.getElementById('resultadoBusca').innerHTML = resultadoHTML;
        }

        // Função para exibir mensagens de erro
        function displayError(message) {
            document.getElementById('resultadoBusca').innerHTML = `<p>${message}</p>`;
        }
    </script>
</body>
</html>
