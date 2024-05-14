<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Adicionar Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Adicionar Vaga</h2>
        <form id="formAdicionarVaga" action="/sivaem-web-main/control/processar_vaga.php" method="post">    
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
        <a href="/sivaem-web-main/view/busca_curriculo.php"><input type="button" class="btn btn-outline-warning" value="Buscar Currículos"></a>
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
            
            // Cria uma nova solicitação AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Exibe o resultado na div correspondente
                        document.getElementById('resultadoAdicionarVaga').innerHTML = xhr.responseText;
                    } else {
                        console.error('Ocorreu um erro ao enviar a solicitação.');
                    }
                }
            };
            
            // Abre a conexão e envia os dados do formulário
            xhr.open("POST", "/sivaem-web-main/control/processar_vaga.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("descricao=" + descricao + "&cargo=" + cargo + "&salario=" + salario);
        });

        $(document).ready(function() {
            // Verificar sessão ao carregar a página
            verificarSessao();

            // Função para verificar sessão
            function verificarSessao() {
                $.ajax({
                    url: 'verificar_sessao.php',
                    method: 'GET',
                    success: function(response) {
                        alert('Sessão está ativa.');
                    },
                    error: function(xhr, status, error) {
                        alert('Sessão não está ativa ou expirou.');
                    }
                });
            }
        });
    </script>
</body>
</html>
