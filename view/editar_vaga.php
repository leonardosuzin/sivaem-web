<?php
// Inclua o arquivo SessionManager.php
require __DIR__ . '/../vendor/autoload.php';

// Crie uma instância da classe SessionManager
$sessionManager = new SessionManager();

// Chame o método checkSession() para verificar a sessão
$sessionManager->checkSessionEmpresa();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Editar Vaga</h2>
        <form id="editForm">
            <div class="mb-3">
                <label for="vaga_id" class="form-label">ID da Vaga:</label>
                <input type="text" class="form-control" id="vaga_id" name="vaga_id" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" required>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Salário:</label>
                <input type="text" class="form-control" id="salario" name="salario" required>
            </div>
            <button type="submit" class="btn btn-info">Salvar</button>
            <a href="/sivaem-web-main/view/excluir_vaga.php"><input type="button" class="btn btn-outline-warning" value="Excluir Vaga"></a>
            <a href="/sivaem-web-main/view/adicionar_vaga.php" class="btn btn-outline-danger">Cancelar</a>
        </form>
        <div id="resposta"></div>
        <div id="vagas"></div> 
    </div>

    <?php include "footer.php";?>

    <script>

        window.onload = function() {
            buscarVagasSemParametro();
        };
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

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
        var formData = new FormData(form);
        var vagaId = formData.get('vaga_id');

        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState === XMLHttpRequest.DONE) {
                if (request.status === 200) {
                    document.getElementById('resposta').innerText = request.responseText;
                } else {
                    console.error('Erro ao editar vaga');
                    alert('Erro ao editar vaga');
                }
            }
        };

        

        request.open("PUT", "/sivaem-web-main/control/processar_vaga.php?id=" + vagaId, true);
        request.setRequestHeader("Content-Type", "application/json");
        request.send(JSON.stringify(Object.fromEntries(formData)));
    });
</script>
</body>
</html>