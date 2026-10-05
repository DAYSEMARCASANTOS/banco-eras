<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Cadastro de Estudante</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #f8fafc; display: flex; justify-content: center; align-items: center; min-height: 100vh; color: #1e293b; padding: 20px; }
        .login-container { width: 100%; max-width: 450px; padding: 30px; display: flex; flex-direction: column; background: #fff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .logo-box { background-color: #1e3a8a; color: white; font-size: 28px; font-weight: 700; width: 56px; height: 56px; display: flex; justify-content: center; align-items: center; border-radius: 14px; margin: 0 auto 16px auto; box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.2); }
        .brand-title { font-size: 22px; font-weight: 700; color: #0f172a; text-align: center; margin-bottom: 4px; }
        .brand-subtitle { font-size: 14px; color: #64748b; text-align: center; margin-bottom: 24px; }
        .form-group { width: 100%; margin-bottom: 16px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .form-group input { width: 100%; padding: 12px 16px; font-size: 14px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none; background-color: #fff; }
        .form-group input:focus { border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }
        .btn-entrar { width: 100%; background-color: #1e3a8a; color: white; border: none; padding: 14px; font-size: 15px; font-weight: 600; border-radius: 10px; cursor: pointer; transition: background-color 0.2s; margin-top: 10px; }
        .btn-entrar:hover { background-color: #172554; }
        .register-footer { margin-top: 20px; font-size: 13px; color: #64748b; text-align: center; }
        .register-footer a { color: #1e3a8a; text-decoration: none; font-weight: 600; }
        .register-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <form action="processar-cadastro.php" method="POST" class="login-container">
        <div class="logo-box">E</div>
        <h1 class="brand-title">Banco ERAS</h1>
        <p class="brand-subtitle">Cadastro de Novo Estudante</p>

        <div class="form-group">
            <label for="nome_completo">Nome Completo</label>
            <input type="text" id="nome_completo" name="nome_completo" placeholder="Digite seu nome completo" required>
        </div>

        <div class="form-group">
            <label for="responsavel">Nome do Responsável (Obrigatório)</label>
            <input type="text" id="responsavel" name="responsavel" placeholder="Nome do pai, mãe ou responsável" required>
        </div>

        <div class="form-group">
            <label for="escola">Nome da Escola</label>
            <input type="text" id="escola" name="escola" placeholder="Nome da instituição de ensino" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Apenas números ou com pontos" maxlength="14" required>
        </div>

        <div class="form-group">
            <label for="matricula">RA (Matrícula)</label>
            <input type="text" id="matricula" name="matricula" placeholder="Ex: 10 dígitos no total" maxlength="10" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
        </div>

        <a href="login-estudante.php" class="btn-entrar" style="display: block; text-align: center; text-decoration: none; box-sizing: border-box;">
    Ir para a Página de Login
</a>
        <div class="register-footer">
            Já tem uma conta? <a href="login-estudante.php">Faça login aqui</a>
        </div>
    </form>

</body>
</html>