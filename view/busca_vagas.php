<?php
//verifica se a sessão existe e está correta
    session_start();

    //caso a sessão não exista, redireciona para o login
    if(empty($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['tipo_user'] == 2){
        header('location: /sivaem-web-main/index.php');
    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Busca de Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container">
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

    <script>
    // Adiciona um evento de "submit" ao formulário com o id 'formBusca'
    document.getElementById('formBusca').addEventListener('submit', function(event) {
        // Evita que o comportamento padrão do formulário (recarregar a página) ocorra
        event.preventDefault(); 

        // Obtém o valor do campo de entrada com o id 'cargo'
        var cargo = document.getElementById('cargo').value;

        // Cria um novo objeto XMLHttpRequest para fazer a solicitação AJAX
        var xhr = new XMLHttpRequest();

        // Define uma função para ser executada quando o estado da solicitação mudar
        xhr.onreadystatechange = function() {
            // Verifica se a solicitação foi concluída
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Verifica se a solicitação foi bem-sucedida (status 200)
                if (xhr.status === 200) {
                    // Atualiza o conteúdo da div 'resultadoBusca' com a resposta da solicitação
                    document.getElementById('resultadoBusca').innerHTML = xhr.responseText;
                } else {
                    // Exibe uma mensagem de erro no console do navegador
                    console.error('Ocorreu um erro ao enviar a solicitação.');
                }
            }
        };

        // Abre a conexão com o servidor e configura a solicitação GET
        xhr.open("GET", "/sivaem-web-main/control/processar_vaga.php?cargo=" + cargo, true);
        
        // Envia a solicitação para o servidor
        xhr.send();
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
