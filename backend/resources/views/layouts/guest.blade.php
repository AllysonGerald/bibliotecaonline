<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Biblioteca Online') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="min-height: 100vh; background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 50%, #fff1f2 100%); position: relative; overflow-x: hidden;">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(196, 181, 253, 0.3); border-radius: 50%; filter: blur(80px);"></div>
    <div style="position: absolute; bottom: -100px; right: -100px; width: 400px; height: 400px; background: rgba(251, 113, 133, 0.3); border-radius: 50%; filter: blur(80px);"></div>

    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; position: relative; z-index: 1;">
        <div style="width: 100%; max-width: 480px;">
            @if (session('success'))
                <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-left: 4px solid #10b981; color: #065f46; border-radius: 12px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div style="display: flex; align-items: center;">
                        <svg style="width: 20px; height: 20px; margin-right: 12px; color: #10b981;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span style="font-weight: 600;">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #fee2e2, #fecaca); border-left: 4px solid #ef4444; color: #991b1b; border-radius: 12px; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div style="display: flex; align-items: center;">
                        <svg style="width: 20px; height: 20px; margin-right: 12px; color: #ef4444;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span style="font-weight: 600;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Garantir que lucide está disponível globalmente imediatamente
        (function() {
            function ensureLucide() {
                if (typeof lucide !== 'undefined') {
                    window.lucide = lucide;
                    // Inicializar ícones imediatamente se o DOM estiver pronto
                    if (document.readyState === 'complete' || document.readyState === 'interactive') {
                        lucide.createIcons();
                    } else {
                        document.addEventListener('DOMContentLoaded', function() {
                            lucide.createIcons();
                        });
                    }
                } else {
                    // Se ainda não carregou, tentar novamente
                    setTimeout(ensureLucide, 50);
                }
            }
            ensureLucide();
        })();
    </script>
    @vite(['resources/js/app.js'])
    <style>
        /* Remove outline padrão preto do navegador e aplica cor de focus do projeto */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            border-color: #ec4899 !important;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1) !important;
        }
    </style>
</body>
</html>
