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
            </div>
            <button type="submit" class="btn btn-info">Excluir</button>
            <a href="/sivaem-web-main/view/adicionar_vaga.php" class="btn btn-outline-danger">Cancelar</a>
        </form>
        <div id="resposta"></div>
        <div id="vagas"></div>
    </div>

    <?php include "footer.php";?>

    <script>
        function buscarVagasSemParametro() {
            const url = new URL("http://localhost:8000/api/vagas");
            const token = sessionStorage.getItem('auth_token');

            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Por favor, realize o login novamente.');
                return;
            }

            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar vagas');
                }
                return response.json();
            })
            .then(vagas => {
                let vagasHTML = "";
                vagas.forEach(vaga => {
                    vagasHTML += `
                        <div class="border border-secondary rounded p-3 mb-3">
                            <p><strong>ID:</strong> ${vaga.id}</p>
                            <p><strong>Descrição:</strong> ${vaga.descricao}</p>
                            <p><strong>Cargo:</strong> ${vaga.cargo}</p>
                            <p><strong>Salário:</strong> ${vaga.salario}</p>
                        </div>
                    `;
                });
                document.getElementById('vagas').innerHTML = vagasHTML;
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                alert('Erro ao buscar vagas');
            });
        }

        // Chamando a função de busca ao carregar a página
        window.onload = function() {
            buscarVagasSemParametro();
        };

        // Adicionando evento de submit ao formulário
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var vagaId = document.getElementById('vaga_id').value;
            var token = sessionStorage.getItem('auth_token');

            if (!token) {
                console.error('Token de acesso não encontrado na sessionStorage.');
                alert('Erro ao excluir vaga. Por favor, realize o login novamente.');
                return;
            }

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState === XMLHttpRequest.DONE) {
                    if (request.status === 200) {
                        document.getElementById('resposta').innerText = 'Vaga excluída com sucesso!';
                        // Atualizando a lista de vagas após a exclusão
                        buscarVagasSemParametro();
                    } else {
                        console.error('Erro ao excluir vaga');
                        alert('Erro ao excluir vaga');
                    }
                }
            };

            request.open("DELETE", `http://127.0.0.1:8000/api/vagas/${vagaId}`, true);
            request.setRequestHeader("Authorization", "Bearer " + token);
            request.send();
        });
    </script>
</body>
</html>
