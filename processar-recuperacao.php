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
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $nova_senha = $_POST['nova_senha'];

    // Verifica se existe um estudante com esse RA e CPF corretos
    $sql_verifica = "SELECT * FROM estudantes WHERE ra = '$matricula' AND cpf = '$cpf'";
    $resultado = $conexao->query($sql_verifica);

    if ($resultado->num_rows > 0) {
        // Atualiza a senha do estudante
        $sql_atualiza = "UPDATE estudantes SET senha = '$nova_senha' WHERE ra = '$matricula'";
        
        if ($conexao->query($sql_atualiza) === TRUE) {
            echo "<h2>Senha alterada com sucesso!</h2>";
            echo "<br><a href='login-estudante.php'>Ir para a página de Login</a>";
        } else {
            echo "Erro ao atualizar a senha: " . $conexao->error;
        }
    } else {
        echo "<h2>Dados não encontrados!</h2>";
        echo "<p>O RA ou o CPF informados não conferem com nenhum cadastro.</p>";
        echo "<br><a href='esqueci-senha.php'>Tentar novamente</a>";
    }
}

$conexao->close();
?>