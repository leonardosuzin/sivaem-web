<!DOCTYPE html>
<html>
<head>
    <title>Busca de Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h2>Busca de Vagas</h2>
    <form method="get" action="busca_vagas.php">
        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo">
        <input type="submit" class="btn btn-info" value="Buscar">
    </form>

    <?php
    // Verificar se a busca foi submetida
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cargo'])) {
        // Conectar ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'site_vagas');
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Recuperar vagas do banco de dados com base no cargo fornecido
        $cargo = $_GET['cargo'];
        $sql = "SELECT * FROM vagas WHERE cargo LIKE '%$cargo%'";
        $result = $conn->query($sql);

        // Exibir vagas encontradas
        if ($result->num_rows > 0) {
            echo "<h3>Vagas Encontradas:</h3>";
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Descrição:</strong> " . $row['descricao'] . "<br>";
                echo "<strong>Cargo:</strong> " . $row['cargo'] . "<br>";
                echo "<strong>Salário:</strong> " . $row['salario'] . "</p>";
            }
        } else {
            echo "<p>Nenhuma vaga encontrada.</p>";
        }

        // Fechar conexão com o banco de dados
        $conn->close();
    }
    ?>
</body>
</html>
