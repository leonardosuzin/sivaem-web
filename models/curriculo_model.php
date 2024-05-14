<?php
session_start();

class CurriculoModel {
    
    private $conn;
   
    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'site_vagas');
        if ($this->conn->connect_error) {
            die("Erro de conexão: " . $this->conn->connect_error);
        }
    }

    public function adicionarCurriculo($descricao, $cargo, $experiencias, $salario) {
        $nome = $_SESSION['username'];
        
        // Verifica se os campos são válidos
        if (strlen($descricao) > 255) {
            return "O perfil pessoal é muito longo!";
        } elseif (strlen($cargo) > 20) {
            return "O nome do cargo é muito longo!";
        } elseif (strlen($descricao) < 5) {
            return "Preencha o perfil pessoal!";
        } elseif (strlen($cargo) < 2) {
            return "O nome do cargo é muito curto!";
        } elseif (strlen($experiencias) > 255) {
            return "O campo de experiencias excedeu o limite de caracteres!";
        } elseif (!is_numeric($salario)) {
            return "O valor do salário não é numérico!";
        } else {
        $conn = new mysqli('localhost', 'root', '', 'site_vagas');
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }
            $stmt = $this->conn->prepare("INSERT INTO curriculo (nome, descricao, cargo, experiencia, salario) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssd", $nome, $descricao, $cargo, $experiencias, $salario);
        
            if ($stmt->execute()) {
                echo "Currículo adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar currículo: " . $stmt->error;
            }
            // Fechar a conexão
            $stmt->close();
        }
    }

    public function atualizarCurriculo($curriculoId, $descricao, $cargo, $experiencia, $salario) {
        $nome = $_SESSION['username'];
        // Verifica se os campos são válidos
        if (strlen($descricao) > 255) {
            return "A descrição é muito longa!";
        } elseif (strlen($cargo) > 255) {
            return "O nome do cargo é muito longo!";
        } elseif (strlen($experiencia) > 255) {
            return "A experiência é muito longa!";
        } elseif (strlen($descricao) < 5) {
            return "A descrição é muito curta!";
        } elseif (strlen($cargo) < 2) {
            return "O nome do cargo é muito curto!";
        } elseif (!is_numeric($salario)) {
            return "O valor do salário não é numérico!";
        } else {
            $sql = "UPDATE curriculo SET descricao='$descricao', cargo='$cargo', experiencia='$experiencia', salario='$salario' WHERE curriculo_id=$curriculoId AND nome='$nome'";
            if ($this->conn->query($sql) === TRUE) {
                if ($this->conn->affected_rows > 0) {
                    return "Currículo atualizado com sucesso!";
                } else {
                    return "Currículo não encontrado, nenhuma alteração realizada.";
                }
            } else {
                return "Erro ao atualizar currículo: " . $this->conn->error;
            }
        }
    }
    
   

    public function buscarCurriculosPorCargo($cargo) {
        // Recuperar currículos do banco de dados com base no cargo fornecido
        $sql = "SELECT * FROM curriculo WHERE cargo LIKE '%$cargo%'";
        $result = $this->conn->query($sql);
        // Exibir currículos encontrados
        if ($result->num_rows > 0) {
            $curriculos = [];
            while ($row = $result->fetch_assoc()) {
                $curriculos[] = $row;
            }
            return $curriculos;
        } else {
            return $curriculos = [];
        }
    }

    public function buscarCurriculosPorNome() {
        $nome = $_SESSION['username'];
        // Recuperar currículos do banco de dados com base na sessão ativa
        $sql = "SELECT * FROM curriculo WHERE nome LIKE '%$nome%'";
        $result = $this->conn->query($sql);
        // Exibir currículos encontrados
        if ($result->num_rows > 0) {
            $curriculos = [];
            while ($row = $result->fetch_assoc()) {
                $curriculos[] = $row;
            }
            return $curriculos;
        } else {
            return "Nenhum currículo encontrado.";
        }
    }
}
?>