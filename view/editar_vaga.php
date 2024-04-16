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
    <div class="container">
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
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="/sivaem-web-main/view/adicionar_vaga.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

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

    <script>
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const vagaId = formData.get('vaga_id');

            fetch(`/sivaem-web-main/control/processar_vaga.php?id=${vagaId}`, {
                method: 'PUT',
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao editar vaga');
                }
                alert('Vaga editada com sucesso!');
            })
            .catch(error => {
                console.error(error.message);
                alert('Erro ao editar vaga');
            });
        });
    </script>
</body>
</html>