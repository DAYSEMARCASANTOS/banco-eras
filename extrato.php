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

// Pega os dados do estudante para exibir informações se necessário
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
    <title>Banco ERAS - Extrato</title>
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
        
        /* Topo Azul do Extrato */
        .header-card { background: linear-gradient(135deg, #082258, #1d4ed8); color: white; padding: 24px 20px 32px 20px; border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; }
        .top-row { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
        .back-btn { background: rgba(255,255,255,0.2); border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 18px; cursor: pointer; }
        .header-title { font-size: 20px; font-weight: 700; }

        /* Caixa de Saldo do Período */
        .balance-period-box { background: rgba(255, 255, 255, 0.12); padding: 18px; border-radius: 16px; text-align: center; }
        .balance-period-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; font-weight: 600; }
        .balance-period-value { font-size: 28px; font-weight: 700; margin-top: 4px; color: #4ade80; }

        /* Corpo e Filtros */
        .content-body { padding: 20px; flex: 1; }
        
        /* Barra de Pesquisa */
        .search-box { position: relative; margin-bottom: 16px; }
        .search-input { width: 100%; padding: 14px 16px 14px 44px; border: 1px solid #e2e8f0; border-radius: 16px; font-size: 14px; background: #fff; outline: none; transition: border-color 0.2s; }
        .search-input:focus { border-color: #2563eb; }
        .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; }

        /* Filtros de Categoria */
        .filter-scroll { display: flex; gap: 8px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 4px; }
        .filter-btn { padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; white-space: nowrap; border: none; cursor: pointer; }
        .filter-btn.active { background: #082258; color: white; }
        .filter-btn.inactive { background: #f1f5f9; color: #64748b; }

        /* Lista de Transações */
        .transaction-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #f1f5f9; border-radius: 18px; margin-bottom: 12px; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.01); }
        .transaction-left { display: flex; align-items: center; gap: 14px; }
        .transaction-icon { width: 44px; height: 44px; background: #fff1f2; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .transaction-icon.positive { background: #ecfdf5; }
        .transaction-name { font-size: 14px; font-weight: 600; color: #0f172a; }
        .transaction-details { font-size: 12px; color: #64748b; margin-top: 2px; }
        .transaction-value { font-size: 14px; font-weight: 700; }
        .transaction-value.negative { color: #ef4444; }
        .transaction-value.positive { color: #10b981; }

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
                <div class="header-title">Extrato</div>
            </div>

            <div class="balance-period-box">
                <div class="balance-period-label">Saldo do Período</div>
                <div class="balance-period-value">+R$ 79,50</div>
            </div>
        </div>

        <div class="content-body">
            <!-- Barra de Pesquisa -->
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" placeholder="Buscar transação...">
            </div>

            <!-- Filtros -->
            <div class="filter-scroll">
                <button class="filter-btn active">Todos</button>
        
            </div>

            <!-- Itens de Extrato -->
            <div class="transaction-item">
                <div class="transaction-left">
                    <div class="transaction-icon">🌭</div>
                    <div>
                        <div class="transaction-name">Cantina do Seu Jorge</div>
                        <div class="transaction-details">Salgado · 23/08, 10:15</div>
                    </div>
                </div>
                <div class="transaction-value negative">-R$ 6,00</div>
            </div>

            <div class="transaction-item">
                <div class="transaction-left">
                    <div class="transaction-icon">🧃</div>
                    <div>
                        <div class="transaction-name">Cantina do Seu Jorge</div>
                        <div class="transaction-details">Suco Natural · 23/08, 10:15</div>
                    </div>
                </div>
                <div class="transaction-value negative">-R$ 4,00</div>
            </div>

            <div class="transaction-item">
                <div class="transaction-left">
                    <div class="transaction-icon positive">💰</div>
                    <div>
                        <div class="transaction-name">Recarga – Maria Santos</div>
                        <div class="transaction-details">Mesada · 22/08, 18:30</div>
                    </div>
                </div>
                <div class="transaction-value positive">+R$ 30,00</div>
            </div>

            <div class="transaction-item">
                <div class="transaction-left">
                    <div class="transaction-icon">✏️</div>
                    <div>
                        <div class="transaction-name">Papelaria da Dona Maria</div>
                        <div class="transaction-details">Material · 21/08, 14:20</div>
                    </div>
                </div>
                <div class="transaction-value negative">-R$ 5,00</div>
            </div>
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
            <a href="extrato.php" class="nav-item active">
                <span>📄</span>
                Extrato
            </a>
            <a href="#" class="nav-item">
                <span>🎯</span>
                Metas
            </a>
            <a href="login-estudante.php" class="nav-item">
                <span>👤</span>
                Perfil
            </a>
        </div>
    </div>
    <script>
    // Seleciona o campo de busca e todos os itens da lista de transações
    const inputBusca = document.querySelector('.search-input');
    const itensTransacao = document.querySelectorAll('.transaction-item');

    inputBusca.addEventListener('input', function() {
        const termo = inputBusca.value.toLowerCase().trim();

        itensTransacao.forEach(item => {
            // Pega o texto do nome da transação e dos detalhes (ex: "Cantina", "Salgado")
            const textoItem = item.innerText.toLowerCase();

            // Se o texto incluir o que foi digitado, mostra o item; senão, esconde
            if (textoItem.includes(termo)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>