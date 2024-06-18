<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Currículo</title>
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
            <div class="mb-3">
                <label for="curriculo_id" class="form-label">ID do Currículo:</label>
                <input type="text" class="form-control" id="curriculo_id" name="curriculo_id" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Nova Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Novo Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" required>
            </div>
            <div class="mb-3">
                <label for="experiencia" class="form-label">Nova Experiência:</label>
                <input type="text" class="form-control" id="experiencia" name="experiencia" required>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Novo Salário:</label>
                <input type="text" class="form-control" id="salario" name="salario" required>
            </div>
            <button type="submit" class="btn btn-info">Editar Currículo</button>
        </form>
        
        <div id="resultadoEditarCurriculo" class="mt-4"></div>
        
        <div class="mt-4">
            <a href="/sivaem-web-main/view/busca_vaga.php" class="btn btn-outline-warning">Buscar Vagas</a>
            <a href="/sivaem-web-main/view/adicionar_curriculo.php" class="btn btn-outline-danger">Voltar</a>
        </div>
        <div id="curriculos" class="mt-4"></div>
    </div>
    <?php include "footer.php";?>

    <script>
        document.getElementById('formEditarCurriculo').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão do formulário
            
            // Obtém os valores dos campos de entrada
            const curriculo_id = document.getElementById('curriculo_id').value;
            const descricao = document.getElementById('descricao').value;
            const cargo = document.getElementById('cargo').value;
            const experiencia = document.getElementById('experiencia').value;
            const salario = document.getElementById('salario').value;

            // Constrói o objeto de dados a ser enviado como JSON
            const data = {
                descricao: descricao,
                cargo: cargo,
                experiencia: experiencia,
                salario: salario
            };

            // Obtém o token salvo na sessionStorage
            const token = sessionStorage.getItem('auth_token');

            // Verifica se o token está presente
            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Erro ao editar currículo. Por favor, realize o login novamente.');
                return;
            }

            // Envia a requisição para a rota de editar currículo na API Laravel
            fetch(`http://127.0.0.1:8000/api/curriculos/${curriculo_id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                document.getElementById('resultadoEditarCurriculo').innerText = data.message;
                buscarCurriculosSemParametro();
            })
            .catch(error => {
                console.error('Erro ao editar currículo:', error);
                alert('Erro ao editar currículo. Por favor, tente novamente.');
            });
        });

        // Função para buscar currículos sem parâmetros
        function buscarCurriculosSemParametro() {
            const url = new URL("http://localhost:8000/api/curriculos");
            const token = sessionStorage.getItem('auth_token');

            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar currículos');
                }
                return response.json();
            })
            .then(data => {
                showCurriculos(data);
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                alert('Erro ao buscar currículos');
            });
        }

        // Função para exibir currículos
        function showCurriculos(data) {
            let curriculosHTML = "";
            if (data.length > 0) {
                data.forEach(curriculo => {
                    curriculosHTML += `<div class="border border-secondary rounded p-3 mb-3">
                        <p><strong>ID do currículo:</strong> ${curriculo.id}</p>
                        <p><strong>Nome do Funcionário:</strong> ${curriculo.nome}</p>
                        <p><strong>Perfil do Funcionário:</strong> ${curriculo.descricao}</p>
                        <p><strong>Cargo Desejado:</strong> ${curriculo.cargo}</p>
                        <p><strong>Experiência Prévia:</strong> ${curriculo.experiencia}</p>
                        <p><strong>Salário Desejado:</strong> ${curriculo.salario}</p>
                    </div>`;
                });
            } else {
                curriculosHTML = "<p>Nenhum currículo encontrado.</p>";
            }
            document.getElementById('curriculos').innerHTML = curriculosHTML;
        }

        // Função para verificar sessão
        function verificarSessao() {
            const token = sessionStorage.getItem('auth_token');
            if (!token) {
                alert('Sessão expirada. Por favor, faça login novamente.');
                window.location.href = '/sivaem-web-main/view/login.php';
            }
        }

        // Executa a função ao carregar a página
        window.onload = function() {
            verificarSessao();
            buscarCurriculosSemParametro();
        };
    </script>
</body>
</html>
