<?php
session_start();

// Verifica se o estudante está logado
if (!isset($_SESSION['ra'])) {
    header("Location: login-estudante.php");
    exit;
}

$servidor = "localhost";
$usuario = "root";
$senha_db = "";
$banco = "banco_eras";

$conexao = new mysqli($servidor, $usuario, $senha_db, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$ra_logado = $_SESSION['ra'];

// Processar alteração de senha se o formulário for enviado
$mensagem_sucesso = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'alterar_senha') {
    $nova_senha = $conexao->real_escape_string($_POST['nova_senha']);
    if (!empty($nova_senha)) {
        $sql_update_senha = "UPDATE estudantes SET senha = '$nova_senha' WHERE ra = '$ra_logado'";
        if ($conexao->query($sql_update_senha)) {
            $mensagem_sucesso = "Senha alterada com sucesso!";
        }
    }
}

// Busca os dados do estudante logado
$sql_estudante = "SELECT * FROM estudantes WHERE ra = '$ra_logado'";
$resultado_estudante = $conexao->query($sql_estudante);
$estudante = $resultado_estudante->fetch_assoc();

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #f1f5f9; min-height: 100vh; color: #1e293b; display: flex; justify-content: center; }
        
        .app-container { 
            width: 100%; 
            max-width: 100%; 
            background: #fff; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            position: relative; 
            padding-bottom: 90px; 
        }

        @media (min-width: 768px) {
            .app-container {
                max-width: 700px; 
                box-shadow: 0 0 25px rgba(0,0,0,0.08);
            }
        }
        
        /* Topo Azul do Perfil */
        .header-card { background: linear-gradient(135deg, #082258, #1d4ed8); color: white; padding: 32px 20px; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; display: flex; align-items: center; gap: 16px; }
        .profile-avatar { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0; }
        .profile-header-info { display: flex; flex-direction: column; gap: 3px; }
        .profile-name { font-size: 18px; font-weight: 700; }
        .profile-class { font-size: 13px; opacity: 0.9; }

        /* Corpo de Conteúdo */
        .content-body { padding: 20px; flex: 1; }

        /* Cartões de Secção */
        .section-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.01); }
        .section-title { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
        
        /* Campos de Informação */
        .info-group { margin-bottom: 12px; }
        .info-group:last-child { margin-bottom: 0; }
        .info-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 2px; }
        .info-value { font-size: 14px; font-weight: 600; color: #1e293b; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }

        /* Formulários e Inputs */
        .form-input { width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none; background: #f8fafc; margin-bottom: 12px; }
        .form-input:focus { border-color: #2563eb; background: #fff; }
        
        .btn-primary { width: 100%; background: #082258; color: white; border: none; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-primary:hover { background: #1d4ed8; }

        /* Notificações (Toggles) */
        .toggle-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .toggle-item:last-child { border-bottom: none; }
        .toggle-text-title { font-size: 13px; font-weight: 600; color: #0f172a; }
        .toggle-text-desc { font-size: 11px; color: #64748b; margin-top: 1px; }
        
        /* Simulação visual de Toggle Switch */
        .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        input:checked + .slider { background-color: #1d4ed8; }
        input:checked + .slider:before { transform: translateX(20px); }

        /* Botão Sair da Conta */
        .btn-logout { width: 100%; background: #fef2f2; border: 1px solid #fee2e2; color: #dc2626; padding: 14px; border-radius: 16px; font-size: 14px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; margin-top: 8px; transition: background 0.2s; }
        .btn-logout:hover { background: #fee2e2; }

        .alert-success { background: #ecfdf5; color: #065f46; padding: 10px; border-radius: 10px; font-size: 13px; margin-bottom: 12px; font-weight: 500; text-align: center; }

        /* Menu Inferior Fixo */
        .nav-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; display: grid; grid-template-columns: repeat(5, 1fr); padding: 10px 0; text-align: center; z-index: 1000; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; text-decoration: none; color: #94a3b8; font-size: 11px; font-weight: 500; }
        .nav-item.active { color: #2563eb; }
        .nav-item span { font-size: 20px; }
    </style>
</head>
<body>

    <div class="app-container">
        <!-- Topo Azul do Perfil -->
        <div class="header-card">
            <div class="profile-avatar">🎒</div>
            <div class="profile-header-info">
                <div class="profile-name">Minha Conta</div>
                <div class="profile-class">Banco ERAS - Estudante</div>
            </div>
        </div>

        <div class="content-body">
            <?php if (!empty($mensagem_sucesso)): ?>
                <div class="alert-success"><?php echo $mensagem_sucesso; ?></div>
            <?php endif; ?>

            <!-- Secção: Dados do Estudante -->
            <div class="section-card">
                <div class="section-title">👤 Informações da Conta</div>
                
                <div class="info-group">
                    <div class="info-label">Matrícula (RA)</div>
                    <div class="info-value"><?php echo htmlspecialchars($estudante['ra']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Escola</div>
                    <div class="info-value" style="border-bottom: none;"><?php echo htmlspecialchars($estudante['escola']); ?></div>
                </div>
            </div>

            <!-- Secção: Segurança -->
            <div class="section-card">
                <div class="section-title">🔒 Segurança</div>
                <form method="POST">
                    <input type="hidden" name="acao" value="alterar_senha">
                    <div class="info-label" style="margin-bottom: 6px;">Nova senha</div>
                    <input type="password" name="nova_senha" class="form-input" placeholder="••••••••" required>
                    <button type="submit" class="btn-primary">Alterar senha</button>
                </form>
            </div>

            <!-- Secção: Notificações -->
            <div class="section-card">
                <div class="section-title">🔔 Notificações</div>
                
                <div class="toggle-item">
                    <div>
                        <div class="toggle-text-title">Notificações no telemóvel</div>
                        <div class="toggle-text-desc">Alertas de pagamentos e avisos</div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-item">
                    <div>
                        <div class="toggle-text-title">E-mail</div>
                        <div class="toggle-text-desc">Resumo semanal por e-mail</div>
                    </div>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-item" style="border-bottom: none; padding-bottom: 0;">
                    <div>
                        <div class="toggle-text-title">Alerta de limite</div>
                        <div class="toggle-text-desc">Aviso quando atingir 80% do limite diário</div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <!-- Botão Sair da Conta -->
            <a href="login.html" class="btn-logout">🚪 Sair da conta</a>
        </div>

        <!-- Menu Inferior Fixo -->
        <div class="nav-bar">
            <a href="painel.php" class="nav-item">
                <span>🏠</span>
                Início
            </a>
            <a href="#" class="nav-item">
                <span>📷</span>
                Pagar
            </a>
            <a href="extrato.php" class="nav-item">
                <span>📄</span>
                Extrato
            </a>
            <a href="metas.php" class="nav-item">
                <span>🎯</span>
                Metas
            </a>
            <a href="perfil.php" class="nav-item active">
                <span>👤</span>
                Perfil
            </a>
        </div>
    </div>

</body>
</html>