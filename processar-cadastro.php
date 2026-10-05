<?php
$servidor = "localhost";
$usuario = "root";
$senha_db = "";
$banco = "banco_eras";

$conexao = new mysqli($servidor, $usuario, $senha_db, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_completo = $_POST['nome_completo'];
    $responsavel   = $_POST['responsavel'];
    $escola        = $_POST['escola'];
    $cpf           = $_POST['cpf'];
    $matricula     = $_POST['matricula'];
    $senha         = $_POST['senha'];
    
    // Valores iniciais para o painel do aluno
    $saldo_inicial = 47.50;
    $limite_inicial = 20.00;

    // Insere os dados junto com o saldo e o limite na tabela estudantes
    $sql = "INSERT INTO estudantes (nome_completo, responsavel, escola, cpf, ra, senha, saldo, limite_diario) 
            VALUES ('$nome_completo', '$responsavel', '$escola', '$cpf', '$matricula', '$senha', '$saldo_inicial', '$limite_inicial')";

    if ($conexao->query($sql) === TRUE) {
        // Redireciona direto para a tela de login após cadastrar
        header("Location: login-estudante.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $conexao->error;
    }
}

$conexao->close();
?>