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
        <div id="resposta"></div>
        <div id="curriculos"></div>
    </div>

    <?php include "footer.php";?>

    <script>
        // Função para buscar currículos sem um parâmetro específico
        function buscarCurriculosSemParametro() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var curriculos = JSON.parse(xhr.responseText);
                        var curriculosHTML = "";
                        curriculos.forEach(function(curriculo) {
                            curriculosHTML += `
                                <div class="curriculo">
                                    <p><strong>Nome do Funcionário:</strong> ${curriculo.nome}</p>
                                    <p><strong>Perfil do Funcionário:</strong> ${curriculo.descricao}</p>
                                    <p><strong>Cargo Desejado:</strong> ${curriculo.cargo}</p>
                                    <p><strong>Experiência Prévia:</strong> ${curriculo.experiencia}</p>
                                    <p><strong>Salário Desejado:</strong> ${curriculo.salario}</p>
                                </div>
                            `;
                        });
                        document.getElementById('curriculos').innerHTML = curriculosHTML;
                    } else {
                        console.error('Erro ao buscar currículos');
                        alert('Erro ao buscar currículos');
                    }
                }
            };
            xhr.open("GET", "/sivaem-web-main/control/processar_curriculo.php", true);
            xhr.send();
        }

        // Chamando a função de busca ao carregar a página
        window.onload = function() {
            buscarCurriculosSemParametro();
        };

        // Adicionando evento de submit ao formulário
        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState === XMLHttpRequest.DONE) {
                    if (request.status === 200) {
                        document.getElementById('resposta').innerText = request.responseText;
                    } else {
                        console.error('Erro ao excluir currículo');
                        alert('Erro ao excluir currículo');
                    }
                }
            };

            request.open("DELETE", "/sivaem-web-main/control/processar_curriculo.php", true);
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send("curriculo_id=" + formData.get('curriculo_id'));
        });
    </script>
</body>
</html>