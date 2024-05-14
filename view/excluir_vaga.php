<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Vaga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .vaga {
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
        <h2>Excluir Vaga</h2>
        <form id="editForm">
            <div class="mb-3">
                <label for="vaga_id" class="form-label">ID da Vaga:</label>
                <input type="text" class="form-control" id="vaga_id" name="vaga_id" required>
            <button type="submit" class="btn btn-info">Excluir</button>
            <a href="/sivaem-web-main/view/editar_vaga.php" class="btn btn-outline-danger">Cancelar</a>
        </form>
        <div id="resposta"></div>
        <div id="vagas"></div>
    </div>

    <?php include "footer.php";?>

    <script>
        // Função para buscar vagas sem um parâmetro específico
        function buscarVagasSemParametro() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var vagas = JSON.parse(xhr.responseText);
                        var vagasHTML = "";
                        vagas.forEach(function(vaga) {
                            vagasHTML += `
                                <div class="vaga">
                                    <p><strong>Id:</strong> ${vaga.vaga_id}</p>
                                    <p><strong>Descrição:</strong> ${vaga.descricao}</p>
                                    <p><strong>Cargo:</strong> ${vaga.cargo}</p>
                                    <p><strong>Salário:</strong> ${vaga.salario}</p>
                                </div>
                            `;
                        });
                        document.getElementById('vagas').innerHTML = vagasHTML;
                    } else {
                        console.error('Erro ao buscar vagas');
                        alert('Erro ao buscar vagas');
                    }
                }
            };
            xhr.open("GET", "/sivaem-web-main/control/processar_vaga.php", true);
            xhr.send();
        }

        // Chamando a função de busca ao carregar a página
        window.onload = function() {
            buscarVagasSemParametro();
        };

        // Adicionando evento de submit ao formulário
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState === XMLHttpRequest.DONE) {
                    if (request.status === 200) {
                        document.getElementById('resposta').innerText = request.responseText;
                        // Atualizando a lista de vagas após a exclusão
                        buscarVagasSemParametro();
                    } else {
                        console.error('Erro ao excluir vaga');
                        alert('Erro ao excluir vaga');
                    }
                }
            };

            // Utilizando o método DELETE e apenas o ID da vaga como parâmetro
            request.open("DELETE", "/sivaem-web-main/control/processar_vaga.php?vaga_id=" + formData.get('vaga_id'), true);
            request.send();
        });
    </script>
</body>
</html>
