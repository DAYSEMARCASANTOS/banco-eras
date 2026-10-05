<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$senha_db = "";
$banco = "banco_eras";

$conexao = new mysqli($servidor, $usuario, $senha_db, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $senha = $_POST['senha'];

    // Procura o estudante usando a coluna 'ra' do banco e a variável 'matricula' do form
    $sql = "SELECT * FROM estudantes WHERE ra = '$matricula' AND senha = '$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows == 1) {
        // Guarda a sessão e redireciona para o painel
        $_SESSION['ra'] = $matricula;
        header("Location: painel.php");
        exit;
    } else {
        echo "<script>alert('RA ou senha incorretos!'); window.location.href='login-estudante.php';</script>";
    }
}

$conexao->close();
?>