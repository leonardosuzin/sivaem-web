<?php

// Inclua o arquivo SessionManager.php
require __DIR__ . '/../vendor/autoload.php';

// Crie uma instância da classe SessionManager
$sessionManager = new SessionManager();

// Chame o método checkSession() para verificar a sessão
$sessionManager->checkSessionCliente();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Busca de Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <input type="text" id="cargo" name="cargo">
            <button type="submit" class="btn btn-info">Buscar</button>
        </form>

        <div id="resultadoBusca"></div>
        <a href="/sivaem-web-main/view/adicionar_curriculo.php"><input type="button" class="btn btn-outline-warning" value="Cadastrar Currículo"></a>
        <a href="/sivaem-web-main/control/logout.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
    </div>
    <?php include "footer.php";?>

    <script>
    document.getElementById('formBusca').addEventListener('submit', function(event) {
        event.preventDefault();
        var cargo = document.getElementById('cargo').value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var vagas = JSON.parse(xhr.responseText);
                    var resultadoHTML = "";
                    if (vagas.length > 0) {
                        for (var i = 0; i < vagas.length; i++) {
                            resultadoHTML += "<div>";
                            resultadoHTML += "<p>Descrição: " + vagas[i].descricao + "</p>";
                            resultadoHTML += "<p>Cargo: " + vagas[i].cargo + "</p>";
                            resultadoHTML += "<p>Salário: " + vagas[i].salario + "</p>";
                            resultadoHTML += "---------------------------------------------------";
                            resultadoHTML += "</div>";
                        }
                    } else {
                        resultadoHTML = "<p>Nenhuma vaga encontrada.</p>";
                    }
                    resultadoHTML += "</table>";
                    document.getElementById('resultadoBusca').innerHTML = resultadoHTML;
                } else {
                    console.error('Ocorreu um erro ao enviar a solicitação.');
                }
            }
        };
        xhr.open("GET", "/sivaem-web-main/control/processar_vaga.php?cargo=" + cargo, true);
        xhr.send();
    });
</script>
</body>
</html>
