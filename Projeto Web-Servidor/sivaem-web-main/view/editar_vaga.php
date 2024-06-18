<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .custom-btn {
            margin-top: 10px;
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
            <a href="/sivaem-web-main/view/excluir_vaga.php" class="btn btn-outline-warning custom-btn">Excluir Vaga</a>
            <a href="/sivaem-web-main/view/adicionar_vaga.php" class="btn btn-outline-danger custom-btn">Cancelar</a>
        </form>
        <div id="resposta" class="mt-4"></div>
        <div id="vagas" class="mt-4"></div> 
    </div>

    <?php include "footer.php";?>

    <script>
        // Função para buscar vagas sem um parâmetro específico
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

        // Função para buscar vagas ao carregar a página
        window.onload = function() {
            buscarVagasSemParametro();
        };

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const vagaId = formData.get('vaga_id');
            const token = sessionStorage.getItem('auth_token');

            const data = {
                descricao: formData.get('descricao'),
                cargo: formData.get('cargo'),
                salario: formData.get('salario')
            };

            const url = `http://localhost:8000/api/vagas/${vagaId}`;

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao editar vaga');
                }
                return response.json();
            })
            .then(responseData => {
                document.getElementById('resposta').innerText = 'Vaga editada com sucesso!';
                buscarVagasSemParametro(); // Atualiza a lista de vagas após a edição
            })
            .catch(error => {
                console.error('Ocorreu um erro:', error);
                alert('Erro ao editar vaga');
            });
        });
    </script>
</body>
</html>
