<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false,
    'httponly' => true
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = $_POST['senha'] ?? '';

    // Mensagem genérica para impedir que hackers descubram se o e-mail/RA existe
    $erroGenerico = "Credenciais inválidas. Verifique os dados digitados.";

    if (empty($usuario) || empty($senha)) {
        header("Location: ../../login-estudante.php?erro=" . urlencode("Preencha todos os campos"));
        exit();
    }

    // Busca por e-mail ou RA (sem revelar o perfil na consulta)
    $stmt = $conn->prepare("SELECT id_estudante, nome, senha, tipo_usuario FROM estudantes WHERE email = ? OR ra = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Validação segura de senha criptografada
        if (password_verify($senha, $user['senha'])) {
            
            // Grava os dados essenciais na sessão
            $_SESSION['usuario_id']   = $user['id_estudante'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

            session_write_close();

            // Redirecionamento inteligente baseado no tipo de perfil
            switch ($user['tipo_usuario']) {
                case 'admin':
                    header("Location: ../../painel-admin.php");
                    break;
                case 'professor':
                    header("Location: ../../painel-professor.php");
                    break;
                case 'estudante':
                default:
                    header("Location: ../../painel.php");
                    break;
            }
            exit();
        }
    }

    // Se o utilizador não existir ou a senha for incorreta, devolve o mesmo erro
    header("Location: ../../login-estudante.php?erro=" . urlencode($erroGenerico));
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Seleção de Perfil</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-gradient-hero {
            background: linear-gradient(120deg, #020205 0%, #0a1026 40%, #1e3a8a 100%);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-full flex flex-col justify-between py-10 px-4">

    <!-- Container Central -->
    <div class="max-w-xl mx-auto w-full">
        
        <!-- Voltar para a Home -->
        <div class="mb-6">
            <a href="index.php" class="inline-flex items-center text-sm text-slate-500 hover:text-blue-900 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Voltar para a página inicial
            </a>
        </div>

        <!-- Cabeçalho -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-900 text-white flex items-center justify-center font-bold text-2xl shadow-lg border border-blue-700/50">
                E
            </div>
            <h1 class="text-2xl font-black text-slate-900">Banco ERAS</h1>
            <p class="text-xs text-slate-500 mt-1">O banco do ecossistema escolar</p>
            
            <div class="mt-6">
                <span class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Selecione seu perfil</span>
            </div>
        </div>

        <!-- Lista de Perfis (Links de redirecionamento) -->
        <div class="space-y-4">
            
            <!-- Estudante -->
            <a href="http://localhost/banco-eras-main/login-estudante.php" class="block bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-400 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-2xl shadow-inner">E</div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Estudante</h2>
                            <p class="text-slate-500 text-xs mt-0.5">Consulte saldo e faça pagamentos</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

            <!-- Responsável / Pai -->
            <a href="#" class="block bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-400 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-2xl shadow-inner">R</div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Responsável</h2>
                            <p class="text-slate-500 text-xs mt-0.5">Monitore e controle os gastos</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

            <!-- Professor(a) -->
            <a href="#" class="block bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-purple-400 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl shadow-inner">P</div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Professor(a)</h2>
                            <p class="text-slate-500 text-xs mt-0.5">Consulte saldo e faça pagamentos</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-purple-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

            <!-- Vendedor / Cantina -->
            <a href="#" class="block bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-orange-400 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl shadow-inner">V</div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Vendedor / Cantina</h2>
                            <p class="text-slate-500 text-xs mt-0.5">Gerencie vendas e produtos</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

            <!-- Escola / Gestão -->
            <a href="#" class="block bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-400 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-2xl shadow-inner">ES</div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">Escola / Gestão</h2>
                            <p class="text-slate-500 text-xs mt-0.5">Painel administrativo completo</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </a>

        </div>

    </div>

    <!-- Rodapé simples -->
    <footer class="text-center mt-10 text-xs text-slate-400">
        &copy; 2026 ERAS Banco Escolar. Segurança e inovação.
    </footer>

</body>
</html>