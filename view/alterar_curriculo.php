<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Currículo</title>
    <style>
        .curriculo {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <h2>Editar Currículo</h2>
        <form id="formEditarCurriculo">    
            <label for="curriculo_id">ID do Currículo:</label><br>
            <input type="text" id="curriculo_id" name="curriculo_id" required><br><br>
            <label for="descricao">Nova Descrição:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br><br>
            <label for="cargo">Novo Cargo:</label><br>
            <input type="text" id="cargo" name="cargo" required><br><br>
            <label for="experiencia">Nova Experiência:</label><br>
            <input type="text" id="experiencia" name="experiencia" required><br><br>
            <label for="salario">Novo Salário:</label><br>
            <input type="text" id="salario" name="salario" required><br><br>
            <button type="submit" class="btn btn-info">Editar Currículo</button>
        </form>
        
        <div id="resultadoEditarCurriculo"></div>
        
        
        <p></p>
        <a href="/sivaem-web-main/view/busca_vaga.php"><input type="button" class="btn btn-outline-warning" value="Buscar Vagas"></a>
        <a href="/sivaem-web-main/view/adicionar_curriculo.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
        <p></p>
        <div id="curriculos"></div>
    </div>
    <?php include "footer.php";?>

    <script>
        document.getElementById('formEditarCurriculo').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário
            
            // Obtém os dados do formulário
            var curriculo_id = document.getElementById('curriculo_id').value;
            var descricao = document.getElementById('descricao').value;
            var cargo = document.getElementById('cargo').value;
            var experiencia = document.getElementById('experiencia').value;
            var salario = document.getElementById('salario').value;
            
            // Cria uma nova solicitação AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Exibe o resultado na div correspondente
                        document.getElementById('resultadoEditarCurriculo').innerHTML = xhr.responseText;
                    } else {
                        console.error('Ocorreu um erro ao enviar a solicitação.');
                    }
                }
            };
            

            // Abre a conexão e envia os dados do formulário
            xhr.open("PUT", "/sivaem-web-main/control/processar_curriculo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("curriculo_id=" + curriculo_id + "&descricao=" + descricao + "&cargo=" + cargo + "&experiencia=" + experiencia + "&salario=" + salario);
        });


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
                                    <p><strong>ID do curriculo:</strong> ${curriculo.curriculo_id}</p>
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


        window.onload = function() {
            buscarCurriculosSemParametro();
        };
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
