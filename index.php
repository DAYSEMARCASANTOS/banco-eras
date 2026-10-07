<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERAS - Banco Escolar</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        erasBlue: '#1e3a8a',
                        erasDarkBlue: '#172554',
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Fundo em degradê personalizado de preto para azul */
        .bg-gradient-dark-blue {
            background: linear-gradient(135deg, #05050a 0%, #0d1224 50%, #1d3587 100%);
        }
        .bg-gradient-hero {
            background: linear-gradient(120deg, #020205 0%, #0a1026 40%, #1e3a8a 100%);
        }
        /* Animações suaves */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden">

    <!-- HEADER / NAVBAR FIXA -->
    <header class="w-full fixed top-0 left-0 z-50 bg-gradient-hero shadow-lg backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center font-bold text-xl shadow-md border border-blue-500/90">
                    E
                </div>
                <div>
                    <span class="text-white font-black tracking-wider text-lg">ERAS</span>
                    <span class="block text-[10px] text-blue-200 tracking-widest uppercase font-semibold">Banco Escolar</span>
                </div>
            </div>

            <!-- Botão Acessar -->
            <div>
                <a href="login.php" class="bg-white text-blue-900 font-semibold px-6 py-2.5 rounded-full shadow-lg hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                    Acessar
                </a>
            </div>
        </div>
    </header>

    <!-- SEÇÃO 1: HERO / CAPA PRINCIPAL -->
    <section class="min-h-screen bg-gradient-hero flex flex-col justify-between pt-28 pb-16 px-6 text-white relative overflow-hidden">
        <!-- Elementos decorativos de fundo -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-24 w-96 h-96 bg-indigo-900/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center my-auto z-10 reveal">
            <!-- Tag superior -->
            <div class="inline-block mb-6">
                <span class="bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-4 py-1.5 rounded-full tracking-wider uppercase backdrop-blur-sm shadow-inner">
                    Banco Escolar Brasileira
                </span>
            </div>

            <!-- Título Principal -->
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                O Banco da sua <br class="hidden md:block">comunidade escolar
            </h1>

            <!-- Subtítulo -->
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10 font-normal leading-relaxed">
                Pagamentos seguros por QR Code, controle parental inteligente e educação financeira para escolas públicas brasileiras.
            </p>

            <!-- Botão de Ação -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="login.php" class="w-full sm:w-auto bg-white text-blue-900 font-bold px-8 py-4 rounded-full shadow-xl hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center space-x-2 group">
                    <span>Começar agora</span>
                    <i class="fa-solid.fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    <span class="sr-only">Seta para a direita</span>
                </a>
            </div>

            <!-- Badges Inferiores -->
            <div class="flex flex-wrap items-center justify-center gap-6 mt-12 text-xs md:text-sm text-blue-200">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid.fa-circle-check text-emerald-400"></i>
                    <span>Gratuito para escolas</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid.fa-circle-check text-emerald-400"></i>
                    <span>Dados protegidos (LGPD)</span>
                </div>
            </div>
        </div>

        <!-- Indicador de rolagem -->
        <div class="text-center z-10 animate-bounce">
            <a href="login.html" class="text-blue-300 hover:text-white text-sm">
                <i class="fa-solid.fa-chevron-down text-xl"></i>
            </a>
        </div>
    </section>

    <!-- SEÇÃO 2: PARA TODA A COMUNIDADE ESCOLAR (5 PERFIS) -->
    <section id="perfis" class="py-24 px-6 bg-slate-50 relative">
        <div class="max-w-6xl mx-auto">
            <!-- Cabeçalho da Seção -->
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3">
                    Para toda a comunidade escolar
                </h2>
                <p class="text-slate-500 text-base md:text-lg">
                    5 perfis integrados em um único ecossistema digital
                </p>
            </div>

            <!-- Grade de Perfis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Card 1: Estudante -->
                <div class="bg-white p-6 rounded-2xl border border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between reveal group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-2xl shadow-inner">E</div>
                            <a  href="login.php" class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-100">ACESSAR</a>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Estudante</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Pague na cantina e acompanhe seu saldo.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-end text-blue-600 group-hover:translate-x-2 transition-transform">
                        <i class="fa-solid.fa-arrow-right text-lg"></i>
                    </div>
                </div>

                <!-- Card 2: Responsável -->
                <div class="bg-white p-6 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between reveal group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-2xl shadow-inner">R</div>
                            <a href="login.php" class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-100">ACESSAR</a>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Responsável</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Monitore os gastos, envie mesada e defina limites.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-end text-emerald-600 group-hover:translate-x-2 transition-transform">
                        <i class="fa-solid.fa-arrow-right text-lg"></i>
                    </div>
                </div>

                <!-- Card 3: Professor -->
                <div class="bg-white p-6 rounded-2xl border border-purple-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between reveal group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl shadow-inner">P</div>
                            <a href="login.php" class="bg-purple-50 text-purple-700 text-xs font-bold px-3 py-1 rounded-full border border-purple-100">ACESSAR</a>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Professor</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Pague na cantina e acompanhe seu saldo.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-end text-purple-600 group-hover:translate-x-2 transition-transform">
                        <i class="fa-solid.fa-arrow-right text-lg"></i>
                    </div>
                </div>

                <!-- Card 4: Vendedor -->
                <div class="bg-white p-6 rounded-2xl border border-orange-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between reveal group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl shadow-inner">V</div>
                            <a href="login.php" class="bg-orange-50 text-orange-700 text-xs font-bold px-3 py-1 rounded-full border border-orange-100">ACESSAR</a>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Vendedor</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Gerencie vendas, estoque e receba por QR Code.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-end text-orange-600 group-hover:translate-x-2 transition-transform">
                        <i class="fa-solid.fa-arrow-right text-lg"></i>
                    </div>
                </div>

            </div>

            <!-- Card 5: Escola (Centralizado embaixo) -->
            <div class="mt-6 max-w-2xl mx-auto bg-white p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between reveal group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-2xl shadow-inner">ES</div>
                        <a href="login.php" class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">ACESSAR</a>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Escola/Gestão</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Administre alunos e gerencie contas
                    </p>
                </div>
                <div class="mt-6 flex justify-end text-indigo-600 group-hover:translate-x-2 transition-transform">
                    <i class="fa-solid.fa-arrow-right text-lg"></i>
                </div>
            </div>

        </div>
    </section>

    <!-- SEÇÃO 3: TECNOLOGIA PARA A EDUCAÇÃO PÚBLICA -->
    <section class="py-24 px-6 bg-white border-t border-slate-100">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    Tecnologia para a educação pública
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Recurso 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all reveal flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid.fa-qrcode"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Pagamento por QR Code</h3>
                        <p class="text-slate-600 text-sm">Rápido, seguro e sem dinheiro físico na escola</p>
                    </div>
                </div>

                <!-- Recurso 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all reveal flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid.fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Controle parental</h3>
                        <p class="text-slate-600 text-sm">Pais definem limites e acompanham cada gasto em tempo real</p>
                    </div>
                </div>

                <!-- Recurso 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all reveal flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid.fa-mobile-screen-button"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">100% digital</h3>
                        <p class="text-slate-600 text-sm">Funciona em qualquer celular, mesmo os mais simples</p>
                    </div>
                </div>

                <!-- Recurso 4 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all reveal flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid.fa-book-open"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Educação financeira</h3>
                        <p class="text-slate-600 text-sm">Módulos interativos de finanças alinhados à BNCC</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SEÇÃO 4: POR QUE O ERAS? (COM PAINEL DE DEGRADÊ DE PRETO PARA AZUL) -->
    <section class="py-24 px-6 bg-slate-50 border-t border-slate-100">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Coluna de Textos e Vantagens -->
                <div class="reveal">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6">
                        Por que o ERAS?
                    </h2>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        Desenvolvido para o contexto das escolas públicas brasileiras, com interface leve e acessível em qualquer dispositivo.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 text-slate-700">
                            <i class="fa-solid.fa-circle-check text-emerald-500 text-lg"></i>
                            <span class="font-medium text-sm">Sem dinheiro físico = mais segurança</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700">
                            <i class="fa-solid.fa-circle-check text-emerald-500 text-lg"></i>
                            <span class="font-medium text-sm">Filas menores no intervalo</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700">
                            <i class="fa-solid.fa-circle-check text-emerald-500 text-lg"></i>
                            <span class="font-medium text-sm">Extrato detalhado de cada compra</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700">
                            <i class="fa-solid.fa-circle-check text-emerald-500 text-lg"></i>
                            <span class="font-medium text-sm">Metas de poupança para alunos</span>
                        </div>
                       
                    </div>
                </div>

                <!-- Coluna do Painel com o novo Degradê de Preto para Azul -->
                <div class="reveal">
                    <div class="bg-gradient-dark-blue p-8 md:p-10 rounded-3xl shadow-2xl text-white border border-blue-500/20">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            
                            <!-- Stat 1 -->
                            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 text-center">
                                <span class="block text-3xl md:text-4xl font-black text-blue-300 mb-1">Feita por Dayse</span>
                               
                            </div>

                            <!-- Stat 2 -->
                            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 text-center">
                                <span class="block text-3xl md:text-4xl font-black text-blue-300 mb-1">Objetivo fazer</span>
                                <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Transações</span>
                            </div>

                            <!-- Stat 3 -->
                            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 text-center">
                                <span class="block text-3xl md:text-4xl font-black text-blue-300 mb-1">Chegar em todas</span>
                                <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Escolas publicas</span>
                            </div>

                            <!-- Stat 4 -->
                            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 text-center">
                                <span class="block text-2xl md:text-3xl font-black text-blue-300 mb-1">LGPD
                                </span><br>
                                <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Segurança</span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- RODAPÉ -->
    <footer class="bg-gradient-hero text-white py-12 px-6 border-t border-blue-900/50">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow">
                    E
                </div>
                <span class="text-white font-bold tracking-wider">ERAS Banco Escolar</span>
            </div>
            <p class="text-xs text-blue-300">
                &copy; 2026 Banco ERAS. Transformando a educação financeira nas escolas públicas.
            </p> 
        </div>
    </footer>

    <!-- BANNER DE COOKIES LGPD -->
    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-md text-white border-t border-slate-800 p-4 md:p-6 shadow-2xl transition-all duration-500">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-slate-300 text-center md:text-left leading-relaxed">
                <p>Utilizamos cookies para melhorar a sua experiência em nossa plataforma e garantir a segurança dos dados conforme a <strong class="text-white">LGPD</strong>. Para mais detalhes, consulte nossa <a href="privacidade.html" class="text-blue-400 underline hover:text-blue-300">Política de Privacidade</a>.</p>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <button onclick="handleCookies('reject')" class="px-5 py-2 text-xs font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-full transition-colors border border-slate-700">
                    Recusar
                </button>
                <button onclick="handleCookies('accept')" class="px-6 py-2 text-xs font-bold text-blue-900 bg-white hover:bg-blue-50 rounded-full shadow-lg transition-all transform hover:scale-105">
                    Aceitar
                </button>
            </div>
        </div>
    </div>

  
    <!-- SCRIPTS DE ANIMAÇÃO E COOKIES -->
    <script>
        // Animação de rolagem (Reveal)
        function revealElements() {
            var reveals = document.querySelectorAll('.reveal');
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('active');
                }
            }
        }
        window.addEventListener('scroll', revealElements);
        window.addEventListener('load', revealElements);

        // Lógica do Banner de Cookies LGPD
        function handleCookies(action) {
            const banner = document.getElementById('cookie-banner');
            banner.style.transform = 'translateY(100%)';
            banner.style.opacity = '0';
            setTimeout(() => {
                banner.style.display = 'none';
            }, 500);
        }
    </script>

</body>
</html>