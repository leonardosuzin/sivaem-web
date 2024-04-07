<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    </head>
<body>
    <nav class="navbar bg-info">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SiVaEm - Sistema de Vagas de Emprego</span>
        </div>
    </nav>
    <div class="container px-4 text-center">
        <div class="d-flex align-content-center flex-wrap">
            <div class="mx-auto p-3" style="width: 300px;">
                <h3>Registro de Novo Usuário</h3>
                <form method="post" action="processar_registro.php">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td><input type="text" id="username" name="username" required placeholder="Nome de usuário"><br><br></td><br>
                        </tr>
                        <tr>
                            <td><input type="password" id="password" name="password" required placeholder="Senha"><br><br></td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tipo_usuario">Tipo de Usuário:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="selectCandidato" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">Candidato</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="selectEmpresa">
                                    <label class="form-check-label" for="flexRadioDefault2">Empresa</label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                        <input type="submit" class="btn btn-info" value="Registrar">
                        <a href="/teste/index.php"><input type="button" class="btn btn-outline-danger" value="Cancelar"></a>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>
