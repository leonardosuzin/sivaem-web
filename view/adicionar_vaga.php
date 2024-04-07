<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h2>Adicionar Vaga</h2>
    <form action="processar_vaga.php" method="post">    
        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br><br>
        <label for="cargo">Cargo:</label><br>
        <input type="text" id="cargo" name="cargo" required><br><br>
        <label for="salario">Salário:</label><br>
        <input type="text" id="salario" name="salario" required><br><br>
        <input type="submit" class="btn btn-info" value="Adicionar Vaga">
    </form>
</body>
</html>
