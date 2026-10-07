<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Login Estudante</title>
    <!-- Importação da fonte Inter para um visual moderno -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1e293b;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Logo do Banco */
        .logo-box {
            background-color: #1e3a8a;
            color: white;
            font-size: 28px;
            font-weight: 700;
            width: 56px;
            height: 56px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 14px;
            box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.2);
            margin-bottom: 16px;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
        }

        /* Botão / Link de Trocar Perfil */
        .trocar-perfil {
            align-self: flex-start;
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .trocar-perfil:hover {
            color: #1e3a8a;
        }

        /* Card do Perfil Selecionado (Estudante) */
        .profile-card {
            width: 100%;
            background-color: #f0f6ff;
            border: 2px solid #dbeafe;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .profile-icon {
            font-size: 28px;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .profile-info h3 {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .profile-info p {
            font-size: 13px;
            color: #64748b;
        }

        /* Formulário de Login */
        .form-group {
            width: 100%;
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s;
            background-color: #fff;
        }

        .form-group input:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        /* Ícone de olho simulado na senha */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            font-size: 14px;
        }

        .forgot-password {
            align-self: flex-end;
            font-size: 13px;
            color: #1e3a8a;
            text-decoration: none;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Botão Entrar */
        .btn-entrar {
            width: 100%;
            background-color: #1e3a8a;
            color: white;
            border: none;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.2s;
            box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.2);
        }

        .btn-entrar:hover {
            background-color: #172554;
        }

        /* Rodapé de cadastro */
        .register-footer {
            margin-top: 24px;
            font-size: 13px;
            color: #64748b;
            text-align: center;
        }

        .register-footer a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <div class="logo-box">E</div>
        
        <h1 class="brand-title">Banco ERAS</h1>
        <p class="brand-subtitle">O banco do ecossistema escolar</p>

        <!-- Voltar / Trocar Perfil -->
        <a href="login.html" class="trocar-perfil">← Trocar perfil</a>

        <!-- Card Perfil Estudante Selecionado -->
        <div class="profile-card">
            <div class="profile-icon">🎒</div>
            <div class="profile-info">
                <h3>Estudante</h3>
                <p>Consulte saldo e faça pagamentos</p>
            </div>
        </div>

        <!-- Formulário junto(Unificado)-->
        <form action="services/auth-service/login.php" method="POST">
    
    <div class="form-group">
        <label for="usuario">E-mail, CPF ou RA</label>
        <input type="text" id="usuario" name="usuario" placeholder="Digite seu e-mail, CPF ou RA" required>
    </div>
    
    <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
    </div>

    <div style="margin-bottom: 15px; text-align: right;">
        <a href="esqueci-senha.php" style="font-size: 13px; color: #1e3a8a; text-decoration: none;">Esqueceu a senha?</a>
    </div>

    <!-- Botão Único de Submissão -->
    <button type="submit" class="btn-entrar" style="width: 100%; border: none; cursor: pointer; text-align: center; box-sizing: border-box; line-height: 30px;">Entrar</button>

    <div class="register-footer" style="margin-top: 15px; text-align: center;">
        Primeiro acesso? <a href="cadastro-estudante.php" style="color: #1e3a8a; font-weight: bold; text-decoration: none;">Cadastre-se aqui</a>
    </div>

</form>