<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Biblioteca Online') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(to bottom, #f3e8ff, white); min-height: 100vh; margin: 0; padding: 0;">
    @php
        $navLinks = [
            ['route' => 'admin.dashboard', 'label' => 'Painel do Admin', 'pattern' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
            ['route' => 'admin.livros.index', 'label' => 'Livros', 'pattern' => 'admin.livros.*', 'icon' => 'book'],
            ['route' => 'admin.autores.index', 'label' => 'Autores', 'pattern' => 'admin.autores.*', 'icon' => 'user'],
            ['route' => 'admin.categorias.index', 'label' => 'Categorias', 'pattern' => 'admin.categorias.*', 'icon' => 'folder'],
            ['route' => 'admin.alugueis.index', 'label' => 'Aluguéis', 'pattern' => 'admin.alugueis.*', 'icon' => 'book-open'],
            ['route' => 'admin.reservas.index', 'label' => 'Reservas', 'pattern' => 'admin.reservas.*', 'icon' => 'calendar'],
            ['route' => 'admin.multas.index', 'label' => 'Multas', 'pattern' => 'admin.multas.index', 'icon' => 'alert-circle'],
            ['route' => 'admin.multas.payment-requests', 'label' => 'Solicitações de Pagamento', 'pattern' => 'admin.multas.payment-requests', 'icon' => 'clock'],
            ['route' => 'admin.usuarios.index', 'label' => 'Usuários', 'pattern' => 'admin.usuarios.*', 'icon' => 'users'],
        ];
    @endphp

    <div style="display: flex; min-height: 100vh;">
        <!-- Sidebar -->
        <x-ui.sidebar :navLinks="$navLinks" />

        <!-- Main Content Area -->
        <div class="main-content-wrapper" style="flex: 1; margin-left: 280px; display: flex; flex-direction: column; min-height: 100vh; transition: margin-left 0.3s ease;">
            <!-- Top Bar -->
            <header style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px); border-bottom: 3px solid #e9d5ff; box-shadow: 0 4px 20px rgba(139, 92, 246, 0.1); position: sticky; top: 0; z-index: 50;">
                <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px 0 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; height: 80px; gap: 24px;">
                        <!-- Lado Esquerdo: Botão Mobile + Botão Colapsar + Título -->
                        <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0;">
                            <!-- Botão para abrir/fechar sidebar em mobile -->
                            <button
                                class="mobile-sidebar-toggle"
                                style="display: none; padding: 8px; background: transparent; border: none; cursor: pointer; border-radius: 8px; transition: all 0.3s;"
                            >
                                <x-ui.icon name="menu" size="24" style="color: #8b5cf6;" />
                            </button>

                            <!-- Botão Colapsar Sidebar (Desktop) -->
                            <button
                                id="sidebar-collapse-btn"
                                class="desktop-sidebar-toggle"
                                style="display: flex; align-items: center; justify-content: center; padding: 6px; background: linear-gradient(135deg, #f3e8ff, #fdf2f8); border: 2px solid #e9d5ff; border-radius: 8px; cursor: pointer; transition: all 0.3s; flex-shrink: 0; pointer-events: auto;"
                                title="Colapsar/Expandir menu"
                            >
                                <x-ui.icon name="panel-left" size="18" class="sidebar-toggle-icon" style="color: #8b5cf6; transition: transform 0.3s; pointer-events: none;" />
                            </button>

                            <!-- Page Title -->
                            <div>
                                <h1 style="font-size: 18px; font-weight: 900; color: #1f2937; margin: 0;">@yield('title', 'Painel Administrativo')</h1>
                            </div>
                        </div>

                        <!-- Lado Direito: User Menu -->
                        <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0;">
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
                                        href="{{ route('home') }}"
                                        class="user-menu-link"
                                        style="display: block; padding: 12px 16px; font-size: 14px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;"
                                    >
                                        Home
                                    </a>
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
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main style="flex: 1; padding: 24px;">
                <div style="max-width: 1280px; margin: 0 auto;">
                    @if (session('success'))
                        <x-ui.alert type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-ui.alert type="error" :message="session('error')" />
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <style>
        .desktop-sidebar-toggle {
            pointer-events: auto !important;
            user-select: none;
        }
        .desktop-sidebar-toggle:hover .sidebar-toggle-icon {
            color: white !important;
        }
        .desktop-sidebar-toggle:active {
            transform: scale(0.95);
        }
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .mobile-sidebar-toggle {
                display: block !important;
            }
            .desktop-sidebar-toggle {
                display: none !important;
            }
            div[style*="margin-left: 280px"] {
                margin-left: 0 !important;
            }
            .user-name {
                display: none !important;
            }
        }
        /* Overlay para mobile */
        @media (max-width: 1024px) {
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 35;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>

    <!-- Overlay para mobile -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <x-layout.scripts />
</body>
</html>
