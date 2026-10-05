<?php
session_start();
header('Content-Type: application/json');

// Se o aluno não estiver logado, retorna erro
if (!isset($_SESSION['ra'])) {
    echo json_encode(['erro' => 'Não logado']);
    exit;
}

$ra = $_SESSION['ra'];

$servidor = "localhost";
$usuario = "root";
$senha_db = "";
$banco = "banco_eras";

$conexao = new mysqli($servidor, $usuario, $senha_db, $banco);
if ($conexao->connect_error) {
    echo json_encode(['erro' => 'Erro de conexão']);
    exit;
}

// 1. Busca o saldo atual do estudante
$sql_estudante = "SELECT saldo FROM estudantes WHERE ra = '$ra'";
$res_estudante = $conexao->query($sql_estudante);
$saldo = 0.00;
if ($res_estudante && $res_estudante->num_rows > 0) {
    $dados = $res_estudante->fetch_assoc();
    $saldo = floatval($dados['saldo']);
}

// 2. Busca notificações não lidas deste estudante
$sql_notif = "SELECT id, mensagem FROM notificacoes WHERE ra = '$ra' AND lida = 0 ORDER BY id DESC";
$res_notif = $conexao->query($sql_notif);
$notificacoes = [];
while ($row = $res_notif->fetch_assoc()) {
    $notificacoes[] = $row;
}

// Opcional: Marcar as notificações como lidas após puxá-las (ou pode marcar via clique)
if (!empty($notificacoes)) {
    $ids_para_marcar = [];
    foreach ($notificacoes as $n) {
        $ids_para_marcar[] = $n['id'];
    }
    $ids_str = implode(',', $ids_para_marcar);
    $conexao->query("UPDATE notificacoes SET lida = 1 WHERE id IN ($ids_str)");
}

$conexao->close();

// Retorna os dados em formato JSON para o JavaScript ler
echo json_encode([
    'saldo' => number_format($saldo, 2, ',', '.'),
    'notificacoes' => $notificacoes
]);
?>