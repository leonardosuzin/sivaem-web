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
    <title>Adicionar Currículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
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
            <button type="button" id="btnAdicionar" class="btn btn-info">Adicionar Currículo</button>
        </form>

        <p></p>
        <a href="/sivaem-web-main/view/alterar_curriculo.php"><input type="button" class="btn btn-outline-success" value="Alterar Currículo"></a>
        <a href="/sivaem-web-main/view/excluir_curriculo.php"><input type="button" class="btn btn-outline-warning" value="Excluir Currículo"></a>
        <div id="resultadoAdicionarCurriculo"></div>
        <p></p>
        
        <div id="resultadoBuscarCurriculos"></div>
        <p></p>
        <a href="/sivaem-web-main/view/busca_vagas.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
    </div>
    <?php include "footer.php";?>

    <script>
        document.getElementById('btnAdicionar').addEventListener('click', function(event) {
            event.preventDefault();
            const descricao = document.getElementById('descricao').value;
            const cargo = document.getElementById('cargo').value;
            const experiencias = document.getElementById('experiencias').value;
            const salario = document.getElementById('salario').value;

            const formData = new FormData();
            formData.append('descricao', descricao);
            formData.append('cargo', cargo);
            formData.append('experiencias', experiencias);
            formData.append('salario', salario);

            fetch("/sivaem-web-main/control/processar_curriculo.php", {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultadoAdicionarCurriculo').innerHTML = data;
            })
            .catch(error => {
                console.error(error.message);
                alert('Erro ao adicionar currículo');
            });
        });

        document.getElementById('btnBuscar').addEventListener('click', function(event) {
            event.preventDefault();
            const cargoBusca = document.getElementById('cargoBusca').value;

            fetch(`/sivaem-web-main/control/processar_curriculos.php?cargo=${cargoBusca}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultadoBuscarCurriculos').innerHTML = data;
            })
            .catch(error => {
                console.error(error.message);
                alert('Erro ao buscar currículos');
            });
        });
    </script>
</body>
</html>
