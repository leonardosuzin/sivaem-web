<?php
//verifica se a sessão existe e está correta
    session_start();

    //caso a sessão não exista, redireciona para o login
    if(empty($_SESSION['loggedin']) || $_SESSION['loggedin'] == false){
        header('location: /sivaem-web-main/index.php');
    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Currículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container">
        <h2>Adicionar Currículo</h2>
        <form id="formAdicionarCurr" action="/sivaem-web-main/control/processar_curriculo.php" method="post">    
            <label for="descricao">Perfil pessoal:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br><br>
            <label for="cargo">Cargo desejado:</label><br>
            <input type="text" id="cargo" name="cargo" required><br><br>
            <label for="experiencias">Experiencias Previas:</label><br>
            <textarea id="experiencias" name="experiencias" required></textarea><br><br>
            <label for="salario">Salário desejado:</label><br>
            <input type="text" id="salario" name="salario" required><br><br>
            <button type="submit" class="btn btn-info">Adicionar Curriculo</button>
        </form>
        
        <div id="resultadoAdicionarCurriculo"></div>
        
        <p></p>
        <a href="/sivaem-web-main/view/busca_vagas.php"><input type="button" class="btn btn-outline-danger" value="Voltar"></a>
    </div>
<script>
document.getElementById('formAdicionarCurr').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = this;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao adicionar currículo');
        }
        return response.text();
    })
    .then(data => {
        document.getElementById('resultadoAdicionarCurriculo').innerHTML = data;
    })
    .catch(error => {
        console.error(error.message);
        alert('Erro ao adicionar currículo');
    });
});

</script>
    
</body>
<footer>
        <div class="fixed-bottom">
            <div class="p-1 mb-0">
                <div class="text-black bg-info">
                    <div class="text-center"> 
                        Ellen Woellner / Leonardo Suzin / Vinícius Souza - UTFPR 2024 ©
                    </div>
                </div>
            </div>
        </div>
    </footer>
</html>