<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Biblioteca Online') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(to bottom, #f3e8ff, #ffffff); min-height: 100vh;">
    <nav style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 3px solid #e9d5ff; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.1); position: sticky; top: 0; z-index: 50;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 80px;">
                <div style="display: flex; align-items: center; gap: 32px;">
                    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                            <i data-lucide="book-open" style="width: 28px; height: 28px; color: white;"></i>
                        </div>
                        <span style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Biblioteca Online</span>
                    </a>

                    <div style="display: none; gap: 4px; @media (min-width: 768px) { display: flex; }">
                        <a href="{{ route('home') }}" class="nav-link{{ request()->routeIs('home') ? ' nav-link-active' : '' }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('home') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}">
                            Início
                        </a>
                        <a href="{{ route('livros.index') }}" class="nav-link{{ request()->routeIs('livros.*') ? ' nav-link-active' : '' }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('livros.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}">
                            Livros
                        </a>
                        <a href="{{ route('meus-alugueis') }}" class="nav-link{{ request()->routeIs('meus-alugueis') ? ' nav-link-active' : '' }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('meus-alugueis') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}">
                            Meus Aluguéis
                        </a>
                        <a href="{{ route('minhas-reservas') }}" class="nav-link{{ request()->routeIs('minhas-reservas') ? ' nav-link-active' : '' }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('minhas-reservas') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}">
                            Minhas Reservas
                        </a>
                        <a href="{{ route('minhas-multas') }}" class="nav-link nav-link-multas{{ request()->routeIs('minhas-multas') ? ' nav-link-active-multas' : '' }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('minhas-multas') ? 'background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444;' : '' }}">
                            Minhas Multas
                        </a>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0;">
                    @auth
                        <div style="position: relative;" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="user-menu-btn"
                                style="display: flex; align-items: center; gap: 10px; padding: 6px 12px; color: #4b5563; font-weight: 600; border-radius: 10px; border: none; background: transparent; cursor: pointer; transition: all 0.3s;"
                            >
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4); flex-shrink: 0;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="user-name" style="font-size: 15px; font-weight: 600; white-space: nowrap;">{{ auth()->user()->name }}</span>
                                <x-ui.icon name="chevron-down" size="18" style="color: #6b7280; flex-shrink: 0;" />
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-cloak
                                style="position: absolute; right: 0; margin-top: 8px; width: 192px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.2); border: 2px solid #e9d5ff; padding: 8px; z-index: 50;"
                            >
                                <a
                                    href="{{ route('perfil') }}"
                                    class="user-menu-link"
                                    style="display: block; padding: 12px 16px; font-size: 14px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;"
                                >
                                    Meu Perfil
                                </a>
                                <a
                                    href="{{ route('lista-desejos') }}"
                                    class="user-menu-link"
                                    style="display: block; padding: 12px 16px; font-size: 14px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;"
                                >
                                    Lista de Desejos
                                </a>
                                <a
                                    href="{{ route('minhas-multas') }}"
                                    class="user-menu-link-danger"
                                    style="display: block; padding: 12px 16px; font-size: 14px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;"
                                >
                                    Minhas Multas
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <hr style="margin: 8px 0; border: none; border-top: 1px solid #e9d5ff;">
                                    <a
                                        href="{{ route('admin.dashboard') }}"
                                        class="user-menu-link"
                                        style="display: block; padding: 12px 16px; font-size: 14px; color: #8b5cf6; font-weight: 700; text-decoration: none; border-radius: 8px; transition: all 0.3s;"
                                    >
                                        Painel do Admin
                                    </a>
                                @endif
                                <hr style="margin: 8px 0; border: none; border-top: 1px solid #e9d5ff;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="user-menu-link-danger"
                                        style="display: block; width: 100%; text-align: left; padding: 12px 16px; font-size: 14px; color: #ef4444; font-weight: 600; text-decoration: none; border-radius: 8px; border: none; background: transparent; cursor: pointer; transition: all 0.3s;"
                                    >
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login-link" style="padding: 10px 20px; color: #4b5563; font-weight: 600; text-decoration: none; transition: color 0.3s;">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="register-link" style="padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 10px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main style="padding: 32px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            @if (session('success'))
                <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-left: 4px solid #10b981; color: #065f46; border-radius: 12px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <svg style="width: 20px; height: 20px; margin-right: 12px; color: #10b981;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span style="font-weight: 600;">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" style="color: #10b981; background: transparent; border: none; cursor: pointer; padding: 4px;" onmouseover="this.style.color='#065f46';">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #fee2e2, #fecaca); border-left: 4px solid #ef4444; color: #991b1b; border-radius: 12px; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <svg style="width: 20px; height: 20px; margin-right: 12px; color: #ef4444;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span style="font-weight: 600;">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" style="color: #ef4444; background: transparent; border: none; cursor: pointer; padding: 4px;" onmouseover="this.style.color='#991b1b';">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-left: 4px solid #3b82f6; color: #1e40af; border-radius: 12px; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <svg style="width: 20px; height: 20px; margin-right: 12px; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span style="font-weight: 600;">{{ session('status') }}</span>
                        </div>
                        <button @click="show = false" style="color: #3b82f6; background: transparent; border: none; cursor: pointer; padding: 4px;" onmouseover="this.style.color='#1e40af';">
                            <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer style="background: white; border-top: 3px solid #e9d5ff; margin-top: 48px;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 32px 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 32px;">
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Sobre</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                        Biblioteca Online - Seu acesso aos melhores livros.
                    </p>
                </div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Links Úteis</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                        <li><a href="{{ route('livros.index') }}" style="font-size: 14px; color: #6b7280; text-decoration: none; font-weight: 500; transition: color 0.3s;" onmouseover="this.style.color='#8b5cf6';" onmouseout="this.style.color='#6b7280';">Catálogo</a></li>
                        <li><a href="{{ route('contato') }}" style="font-size: 14px; color: #6b7280; text-decoration: none; font-weight: 500; transition: color 0.3s;" onmouseover="this.style.color='#8b5cf6';" onmouseout="this.style.color='#6b7280';">Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Contato</h3>
                    <p style="font-size: 14px; color: #6b7280; line-height: 1.8;">
                        Email: contato@biblioteca.com<br>
                        Tel: (11) 1234-5678
                    </p>
                </div>
            </div>
            <div style="margin-top: 32px; padding-top: 32px; border-top: 2px solid #e9d5ff;">
                <p style="text-align: center; font-size: 14px; color: #9ca3af; font-weight: 500;">
                    © {{ date('Y') }} Biblioteca Online. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
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
        [x-cloak] { display: none !important; }

        /* Remove outline padrão preto do navegador e aplica cor de focus do projeto */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
        }

        @media (max-width: 1024px) {
            .user-name {
                display: none !important;
            }
        }
    </style>
</body>
</html>
