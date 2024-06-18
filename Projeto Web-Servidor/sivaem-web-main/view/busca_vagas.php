<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Busca de Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-btn {
            margin-top: 10px;
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
        <h2>Busca de Vagas</h2>
        <form id="formBusca">
            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" class="form-control">
            <button type="submit" class="btn btn-info mt-2">Buscar</button>
        </form>

        <div id="resultadoBusca" class="mt-4"></div>

        <div class="mt-4">
            <a href="/sivaem-web-main/view/adicionar_curriculo.php" class="btn btn-outline-danger custom-btn">Voltar</a>
        </div>
    </div>

    <script>
        document.getElementById('formBusca').addEventListener('submit', function(event) {
            event.preventDefault();
            const cargo = document.getElementById('cargo').value;

            // Montando a URL com parâmetros em formato de query string
            const url = new URL("http://localhost:8000/api/vagas");
            const params = { cargo: cargo };
            url.search = new URLSearchParams(params).toString();

            
            var token = sessionStorage.getItem('auth_token');

            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar vagas');
                }
                return response.json();
            })
            .then(data => {
                showSearchResults(data);
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                displayError('Ocorreu um erro ao buscar as vagas.');
            });
        });

        function showSearchResults(data) {
            let resultadoHTML = "";
            if (data.length > 0) {
                data.forEach(vaga => {
                    resultadoHTML += `<div class="border border-secondary rounded p-3 mb-3">
                        <p><strong>Descrição:</strong> ${vaga.descricao}</p>
                        <p><strong>Cargo:</strong> ${vaga.cargo}</p>
                        <p><strong>Salário:</strong> ${vaga.salario}</p>
                    </div>`;
                });
            } else {
                resultadoHTML = "<p>Nenhuma vaga encontrada.</p>";
            }
            document.getElementById('resultadoBusca').innerHTML = resultadoHTML;
        }

        function displayError(message) {
            document.getElementById('resultadoBusca').innerHTML = `<p>${message}</p>`;
        }
    </script>

    <?php include "footer.php";?>
</body>
</html>
