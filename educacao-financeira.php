<?php
session_start();

// Verifica se o estudante está logado
if (!isset($_SESSION['ra'])) {
    header("Location: login-estudante.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Educação Financeira</title>
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

        /* Topo Laranja */
        .header-banner {
            background: linear-gradient(135deg, #ea580c, #f97316);
            color: white;
            padding: 24px 20px;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .header-top-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
        }
        .header-title {
            font-size: 18px;
            font-weight: 700;
        }
        .progress-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            padding: 16px;
            border-radius: 16px;
        }
        .progress-label {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .progress-val {
            font-size: 20px;
            font-weight: 700;
        }
        .progress-circle {
            width: 52px;
            height: 52px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
        }

        /* Corpo */
        .content-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .section-heading {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        /* Módulos Cards */
        .module-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        }
        .module-card.completed {
            border-color: #22c55e;
        }
        .module-top {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .module-icon {
            width: 48px;
            height: 48px;
            background: #f8fafc;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .module-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .module-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .module-name {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }
        .module-desc {
            font-size: 12px;
            color: #64748b;
            line-height: 1.4;
            margin-top: 2px;
        }
        .module-meta {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .status-badge {
            font-size: 11px;
            font-weight: 600;
            color: #16a34a;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 6px;
        }
        .lock-icon {
            font-size: 15px;
            color: #94a3b8;
        }

        /* Barra de Progresso Interna */
        .progress-bar-container {
            width: 100%;
            background: #e2e8f0;
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 4px;
        }
        .progress-bar-fill {
            background: #f97316;
            height: 100%;
            width: 60%;
        }
        .progress-text-sm {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
            font-weight: 500;
        }

        /* Botão Continuar */
        .btn-continue {
            background: #f97316;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: background 0.2s;
            margin-top: 4px;
        }
        .btn-continue:hover {
            background: #ea580c;
        }

        /* Menu Inferior Fixo */
        .nav-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; display: grid; grid-template-columns: repeat(5, 1fr); padding: 10px 0; text-align: center; z-index: 1000; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; text-decoration: none; color: #94a3b8; font-size: 11px; font-weight: 500; }
        .nav-item.active { color: #2563eb; }
        .nav-item span { font-size: 20px; }
    </style>
</head>
<body>

    <div class="app-container">
        <!-- Topo Laranja -->
        <div class="header-banner">
            <div class="header-top-row">
                <a href="painel.php" class="back-btn">←</a>
                <div class="header-title">Educação Financeira</div>
            </div>
            <div class="progress-card-row">
                <div>
                    <div class="progress-label">Progresso geral</div>
                    <div class="progress-val">1/5 módulos</div>
                </div>
                <div class="progress-circle">20%</div>
            </div>
        </div>

        <!-- Corpo da Página -->
        <div class="content-body">
            <div class="section-heading">Módulos disponíveis</div>

            <!-- Módulo 1 (Concluído) -->
            <div class="module-card completed">
                <div class="module-top">
                    <div class="module-icon">💵</div>
                    <div class="module-info">
                        <div class="module-title-row">
                            <div class="module-name">O que é dinheiro?</div>
                            <span style="color: #16a34a; font-size: 16px;">✔</span>
                        </div>
                        <div class="module-desc">Entenda a história e função do dinheiro na sociedade</div>
                        <div class="module-meta">⏱️ 8 min</div>
                        <div class="status-badge">✓ Módulo concluído!</div>
                    </div>
                </div>
            </div>

            <!-- Módulo 2 (Em andamento) -->
            <div class="module-card">
                <div class="module-top">
                    <div class="module-icon">📊</div>
                    <div class="module-info">
                        <div class="module-name">Orçamento pessoal</div>
                        <div class="module-desc">Aprenda a planear seus gastos e poupar para objetivos</div>
                        <div class="module-meta">⏱️ 12 min</div>
                    </div>
                </div>
                <div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: 60%;"></div>
                    </div>
                    <div class="progress-text-sm">60% concluído</div>
                </div>
                <a href="#" class="btn-continue">▶ Continuar</a>
            </div>

            <!-- Módulo 3 (Bloqueado) -->
            <div class="module-card" style="opacity: 0.85;">
                <div class="module-top">
                    <div class="module-icon">📈</div>
                    <div class="module-info">
                        <div class="module-title-row">
                            <div class="module-name">Poupança e Investimento</div>
                            <span class="lock-icon">🔒</span>
                        </div>
                        <div class="module-desc">Como fazer seu dinheiro trabalhar por você</div>
                        <div class="module-meta">⏱️ 15 min</div>
                    </div>
                </div>
            </div>

            <!-- Módulo 4 (Bloqueado) -->
            <div class="module-card" style="opacity: 0.85;">
                <div class="module-top">
                    <div class="module-icon">🛒</div>
                    <div class="module-info">
                        <div class="module-title-row">
                            <div class="module-name">Consumo consciente</div>
                            <span class="lock-icon">🔒</span>
                        </div>
                        <div class="module-desc">Diferencie necessidade de desejo e evite dívidas</div>
                        <div class="module-meta">⏱️ 10 min</div>
                    </div>
                </div>
            </div>

            <!-- Módulo 5 (Bloqueado) -->
            <div class="module-card" style="opacity: 0.85;">
                <div class="module-top">
                    <div class="module-icon">🔒</div>
                    <div class="module-info">
                        <div class="module-title-row">
                            <div class="module-name">Segurança financeira</div>
                            <span class="lock-icon">🔒</span>
                        </div>
                        <div class="module-desc">Proteja seus dados e evite fraudes no dia a dia</div>
                        <div class="module-meta">⏱️ 8 min</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Inferior Fixo -->
        <div class="nav-bar">
            <a href="painel.php" class="nav-item"><span>🏠</span>Início</a>
            <a href="#" class="nav-item"><span>📷</span>Pagar</a>
            <a href="extrato.php" class="nav-item"><span>📄</span>Extrato</a>
            <a href="metas.php" class="nav-item"><span>🎯</span>Metas</a>
            <a href="perfil.php" class="nav-item"><span>👤</span>Perfil</a>
        </div>
    </div>

</body>
</html>