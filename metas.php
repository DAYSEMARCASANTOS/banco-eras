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

// Cria a tabela de metas caso ela não exista
$sql_cria_tabela = "CREATE TABLE IF NOT EXISTS metas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ra VARCHAR(20) NOT NULL,
    titulo VARCHAR(100) NOT NULL,
    icone VARCHAR(10) NOT NULL,
    prazo DATE NOT NULL,
    valor_alvo DECIMAL(10,2) NOT NULL,
    valor_atual DECIMAL(10,2) DEFAULT 0.00
)";
$conexao->query($sql_cria_tabela);

// Processar Ações (Nova Meta ou Depósito)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] == 'nova_meta') {
        $titulo = $conexao->real_escape_string($_POST['titulo']);
        $icone = $conexao->real_escape_string($_POST['icone']);
        $prazo = $conexao->real_escape_string($_POST['prazo']);
        $valor_alvo = floatval($_POST['valor_alvo']);

        $sql_insere = "INSERT INTO metas (ra, titulo, icone, prazo, valor_alvo, valor_atual) VALUES ('$ra_logado', '$titulo', '$icone', '$prazo', '$valor_alvo', 0.00)";
        $conexao->query($sql_insere);
        header("Location: metas.php");
        exit;
    }

    if (isset($_POST['acao']) && $_POST['acao'] == 'depositar') {
        $meta_id = intval($_POST['meta_id']);
        $valor_deposito = floatval($_POST['valor_deposito']);

        if ($valor_deposito > 0) {
            $sql_atualiza = "UPDATE metas SET valor_atual = valor_atual + $valor_deposito WHERE id = $meta_id AND ra = '$ra_logado'";
            $conexao->query($sql_atualiza);
        }
        header("Location: metas.php");
        exit;
    }
}

// Buscar total poupado
$sql_total = "SELECT SUM(valor_atual) as total FROM metas WHERE ra = '$ra_logado'";
$res_total = $conexao->query($sql_total);
$row_total = $res_total->fetch_assoc();
$total_poupado = $row_total['total'] ? $row_total['total'] : 0.00;

// Buscar todas as metas do estudante
$sql_metas = "SELECT * FROM metas WHERE ra = '$ra_logado' ORDER BY prazo ASC";
$resultado_metas = $conexao->query($sql_metas);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ERAS - Minhas Metas</title>
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
        
        /* Topo Azul */
        .header-card { background: linear-gradient(135deg, #082258, #1d4ed8); color: white; padding: 24px 20px 32px 20px; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; }
        .top-row { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
        .back-btn { background: rgba(255,255,255,0.2); border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 18px; cursor: pointer; }
        .header-title { font-size: 20px; font-weight: 700; }

        /* Caixa Total Poupado */
        .balance-period-box { background: rgba(255, 255, 255, 0.12); padding: 18px; border-radius: 16px; text-align: center; }
        .balance-period-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; font-weight: 600; }
        .balance-period-value { font-size: 28px; font-weight: 700; margin-top: 4px; color: #ffffff; }

        /* Corpo de Conteúdo */
        .content-body { padding: 20px; flex: 1; }

        /* Cartão de Meta */
        .goal-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 18px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.01); position: relative; }
        .goal-card.completed { border-color: #10b981; }
        
        .goal-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .goal-info-left { display: flex; align-items: center; gap: 12px; }
        .goal-icon { width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #e2e8f0; }
        .goal-title { font-size: 15px; font-weight: 700; color: #0f172a; }
        .goal-date { font-size: 12px; color: #64748b; margin-top: 2px; }
        
        .goal-badge { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; background: #f1f5f9; color: #64748b; }
        .goal-badge.completed { background: #ecfdf5; color: #10b981; }

        /* Barra de Progresso da Meta */
        .goal-progress-bar { background: #f1f5f9; height: 7px; border-radius: 4px; overflow: hidden; margin-bottom: 10px; }
        .goal-progress-fill { background: #10b981; height: 100%; border-radius: 4px; }
        
        .goal-footer { display: flex; justify-content: space-between; font-size: 12px; color: #64748b; font-weight: 500; margin-bottom: 14px; }

        /* Botão Depositar na Meta */
        .btn-deposit { width: 100%; background: #f8fafc; border: 1px solid #e2e8f0; color: #1e3a8a; padding: 12px; border-radius: 14px; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; transition: background 0.2s; }
        .btn-deposit:hover { background: #f1f5f9; }

        /* Botão Nova Meta */
        .btn-new-goal { width: 100%; background: transparent; border: 2px dashed #cbd5e1; color: #64748b; padding: 16px; border-radius: 18px; font-size: 14px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; margin-top: 8px; transition: all 0.2s; }
        .btn-new-goal:hover { border-color: #1d4ed8; color: #1d4ed8; background: #f8fafc; }

        /* Modais */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center; padding: 20px; }
        .modal-card { background: white; width: 100%; max-width: 400px; padding: 24px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; color: #0f172a; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; outline: none; }
        .form-input:focus { border-color: #2563eb; }
        .modal-buttons { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save { flex: 1; background: #1d4ed8; color: white; border: none; padding: 12px; border-radius: 12px; font-weight: 600; cursor: pointer; }
        .btn-cancel { flex: 1; background: #f1f5f9; color: #64748b; border: none; padding: 12px; border-radius: 12px; font-weight: 600; cursor: pointer; }

        /* Menu Inferior Fixo */
        .nav-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: white; border-top: 1px solid #e2e8f0; display: grid; grid-template-columns: repeat(5, 1fr); padding: 10px 0; text-align: center; z-index: 1000; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; text-decoration: none; color: #94a3b8; font-size: 11px; font-weight: 500; }
        .nav-item.active { color: #2563eb; }
        .nav-item span { font-size: 20px; }
    </style>
</head>
<body>

    <div class="app-container">
        <!-- Topo Azul -->
        <div class="header-card">
            <div class="top-row">
                <a href="painel.php" class="back-btn">←</a>
                <div class="header-title">Minhas Metas</div>
            </div>

            <div class="balance-period-box">
                <div class="balance-period-label">Total Poupado</div>
                <div class="balance-period-value">R$ <?php echo number_format($total_poupado, 2, ',', '.'); ?></div>
            </div>
        </div>

        <div class="content-body">
            <?php if ($resultado_metas->num_rows > 0): ?>
                <?php while($meta = $resultado_metas->fetch_assoc()): 
                    $alvo = $meta['valor_alvo'];
                    $atual = $meta['valor_atual'];
                    $porcentagem = ($alvo > 0) ? min(100, round(($atual / $alvo) * 100)) : 0;
                    $faltam = max(0, $alvo - $atual);
                    $concluida = $atual >= $alvo;
                    
                    // Formata a data de AAAA-MM-DD para DD/MM/AAAA
                    $prazo_formatado = date('d/m/Y', strtotime($meta['prazo']));
                ?>
                    <div class="goal-card <?php echo $concluida ? 'completed' : ''; ?>">
                        <div class="goal-top">
                            <div class="goal-info-left">
                                <div class="goal-icon"><?php echo $meta['icone']; ?></div>
                                <div>
                                    <div class="goal-title"><?php echo htmlspecialchars($meta['titulo']); ?></div>
                                    <div class="goal-date">Prazo: <?php echo $prazo_formatado; ?></div>
                                </div>
                            </div>
                            <?php if ($concluida): ?>
                                <div class="goal-badge completed">Concluída ✓</div>
                            <?php else: ?>
                                <div class="goal-badge"><?php echo $porcentagem; ?>%</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="goal-progress-bar">
                            <div class="goal-progress-fill" style="width: <?php echo $porcentagem; ?>%;"></div>
                        </div>
                        
                        <div class="goal-footer">
                            <span>R$ <?php echo number_format($atual, 2, ',', '.'); ?> de R$ <?php echo number_format($alvo, 2, ',', '.'); ?></span>
                            <?php if ($concluida): ?>
                                <span style="color: #10b981; font-weight: 600;">Faltam R$ 0,00</span>
                            <?php else: ?>
                                <span style="color: #64748b;">Faltam R$ <?php echo number_format($faltam, 2, ',', '.'); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if (!$concluida): ?>
                            <button class="btn-deposit" onclick="abrirModalDeposito(<?php echo $meta['id']; ?>, '<?php echo htmlspecialchars($meta['titulo']); ?>')">+ Depositar na meta</button>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; color: #64748b; margin-top: 40px; font-size: 14px;">Ainda não tens nenhuma meta criada. Começa agora!</p>
            <?php endif; ?>

            <!-- Botão Nova Meta -->
            <button class="btn-new-goal" onclick="abrirModalMeta()">+ Nova meta de poupança</button>
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
            <a href="metas.php" class="nav-item active">
                <span>🎯</span>
                Metas
            </a>
            <a href="login-estudante.php" class="nav-item">
                <span>👤</span>
                Perfil
            </a>
        </div>
    </div>

    <!-- Modal Nova Meta -->
    <div class="modal-overlay" id="modalNovaMeta">
        <div class="modal-card">
            <div class="modal-title">Criar Nova Meta</div>
            <form method="POST">
                <input type="hidden" name="acao" value="nova_meta">
                <div class="form-group">
                    <label class="form-label">Título da Meta</label>
                    <input type="text" name="titulo" class="form-input" placeholder="Ex: Livro de Matemática" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Emoji (Ícone)</label>
                    <input type="text" name="icone" class="form-input" placeholder="Ex: 📖" maxlength="5" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Valor Alvo (R$)</label>
                    <input type="number" step="0.01" name="valor_alvo" class="form-input" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Prazo Limite</label>
                    <input type="date" name="prazo" class="form-input" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="fecharModalMeta()">Cancelar</button>
                    <button type="submit" class="btn-save">Criar Meta</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Depositar -->
    <div class="modal-overlay" id="modalDeposito">
        <div class="modal-card">
            <div class="modal-title" id="tituloModalDep">Depositar na Meta</div>
            <form method="POST">
                <input type="hidden" name="acao" value="depositar">
                <input type="hidden" name="meta_id" id="inputMetaId">
                <div class="form-group">
                    <label class="form-label">Valor do Depósito (R$)</label>
                    <input type="number" step="0.01" name="valor_deposito" class="form-input" placeholder="0.00" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="fecharModalDeposito()">Cancelar</button>
                    <button type="submit" class="btn-save">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalMeta() {
            document.getElementById('modalNovaMeta').style.display = 'flex';
        }
        function fecharModalMeta() {
            document.getElementById('modalNovaMeta').style.display = 'none';
        }

        function abrirModalDeposito(id, nome) {
            document.getElementById('inputMetaId').value = id;
            document.getElementById('tituloModalDep').innerText = 'Depositar em: ' + nome;
            document.getElementById('modalDeposito').style.display = 'flex';
        }
        function fecharModalDeposito() {
            document.getElementById('modalDeposito').style.display = 'none';
        }
    </script>

</body>
</html>