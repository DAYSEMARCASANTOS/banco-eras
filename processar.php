<?php
$servidor = "localhost";
$usuario = "root";
$senha_db = "";
$banco = "banco_eras";

// Conecta ao banco de dados
$conexao = new mysqli($servidor, $usuario, $senha_db, $banco);

// Verifica se houve erro na conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Verifica se os dados vieram via POST do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_completo = $_POST['nome_completo'];
    $responsavel   = $_POST['responsavel'];
    $escola        = $_POST['escola'];
    $cpf           = $_POST['cpf'];
    $matricula     = $_POST['matricula'];
    $senha         = $_POST['senha'];

    // Insere os dados na tabela estudantes
    $sql = "INSERT INTO estudantes (nome_completo, responsavel, escola, cpf, ra, senha) 
            VALUES ('$nome_completo', '$responsavel', '$escola', '$cpf', '$matricula', '$senha')";

    if ($conexao->query($sql) === TRUE) {
        echo "<h2>Cadastro realizado com sucesso!</h2>";
        echo "<br><a href='login-estudante.php'>Ir para a página de Login</a>";
    } else {
        echo "Erro ao cadastrar: " . $conexao->error;
    }
}

$conexao->close();
?>