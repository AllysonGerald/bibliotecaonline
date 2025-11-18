<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Biblioteca Online') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: linear-gradient(to bottom, #f3e8ff, #ffffff); min-height: 100vh;">
    <nav style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 3px solid #e9d5ff; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.1); position: sticky; top: 0; z-index: 50;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 80px;">
                <div style="display: flex; align-items: center; gap: 32px;">
                    <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                            <i data-lucide="book-open" style="width: 28px; height: 28px; color: white;"></i>
                        </div>
                        <span style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Biblioteca Online</span>
                    </a>

                    <div style="display: none; gap: 4px; @media (min-width: 768px) { display: flex; }">
                        <a href="{{ route('admin.dashboard') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.dashboard') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Painel do Admin
                        </a>
                        <a href="{{ route('admin.livros.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.livros.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Livros
                        </a>
                        <a href="{{ route('admin.autores.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.autores.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Autores
                        </a>
                        <a href="{{ route('admin.categorias.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.categorias.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Categorias
                        </a>
                        <a href="{{ route('admin.alugueis.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.alugueis.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Aluguéis
                        </a>
                        <a href="{{ route('admin.reservas.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.reservas.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Reservas
                        </a>
                        <a href="{{ route('admin.usuarios.index') }}" style="padding: 10px 16px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ request()->routeIs('admin.usuarios.*') ? 'background: linear-gradient(135deg, #f3e8ff, #fce7f3); color: #8b5cf6;' : '' }}" onmouseover="if (!this.style.background.includes('gradient')) { this.style.background='#f3e8ff'; this.style.color='#8b5cf6'; }" onmouseout="if (!this.style.background.includes('gradient')) { this.style.background=''; this.style.color='#4b5563'; }">
                            Usuários
                        </a>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="position: relative;" x-data="{ open: false }">
                        <button @click="open = !open" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; border: none; background: transparent; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#f3e8ff'; this.style.color='#8b5cf6';" onmouseout="this.style.background='transparent'; this.style.color='#4b5563';">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span style="font-size: 14px; font-weight: 600; display: none; @media (min-width: 640px) { display: inline; }">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" style="width: 16px; height: 16px;"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak style="position: absolute; right: 0; margin-top: 8px; width: 200px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.2); border: 2px solid #e9d5ff; padding: 8px; z-index: 50;">
                            <a href="{{ route('home') }}" style="display: block; padding: 12px 16px; font-size: 14px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='#f3e8ff'; this.style.color='#8b5cf6';" onmouseout="this.style.background=''; this.style.color='#4b5563';">
                                Home
                            </a>
                            <hr style="margin: 8px 0; border: none; border-top: 1px solid #e9d5ff;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" style="display: block; width: 100%; text-align: left; padding: 12px 16px; font-size: 14px; color: #ef4444; font-weight: 600; text-decoration: none; border-radius: 8px; border: none; background: transparent; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#fee2e2';" onmouseout="this.style.background='transparent';">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div style="max-width: 1280px; margin: 0 auto; padding: 32px 24px;">
        @if (session('success'))
            <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 3px solid #86efac; border-radius: 12px; color: #065f46; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #10b981;"></i>
                        <span style="font-weight: 600;">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" style="background: transparent; border: none; cursor: pointer; color: #065f46; padding: 4px;" onmouseover="this.style.color='#047857';" onmouseout="this.style.color='#065f46';">
                        <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 3px solid #fca5a5; border-radius: 12px; color: #991b1b; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i data-lucide="alert-circle" style="width: 20px; height: 20px; color: #ef4444;"></i>
                        <span style="font-weight: 600;">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" style="background: transparent; border: none; cursor: pointer; color: #991b1b; padding: 4px;" onmouseover="this.style.color='#7f1d1d';" onmouseout="this.style.color='#991b1b';">
                        <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="{{ asset('js/utils/masks.js') }}"></script>
    <script>
        // Função para inicializar Lucide Icons
        function initLucideIcons() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        // Inicializar quando o DOM estiver pronto
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initLucideIcons);
        } else {
            initLucideIcons();
        }
        // Re-inicializar após mudanças dinâmicas (Alpine.js)
        document.addEventListener('alpine:init', () => {
            setTimeout(initLucideIcons, 100);
        });

        // Remove máscaras de formulários antes de enviar
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (typeof InputMasks !== 'undefined') {
                        InputMasks.removeMasksFromForm(this);
                    }
                });
            });
        });
    </script>
    <style>
        [x-cloak] { display: none !important; }

        /* Custom select styling - Remove native arrow and add custom one with proper spacing */
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 16px !important;
        }

        /* Override inline padding-right for selects to add space for icon */
        select[style*="padding"] {
            padding-right: 40px !important;
        }

        select:focus {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        }

        /* Custom datetime-local input styling - Keep native calendar functionality but style the icon */
        input[type="datetime-local"] {
            position: relative;
            padding-right: 12px !important;
        }

        /* Style the native calendar picker indicator to look like our custom icon - positioned more to the right */
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 16px !important;
            cursor: pointer !important;
            opacity: 1 !important;
            width: 16px !important;
            height: 16px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        input[type="datetime-local"]:focus::-webkit-calendar-picker-indicator {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        }

        /* Hide native spin buttons but keep functionality */
        input[type="datetime-local"]::-webkit-inner-spin-button,
        input[type="datetime-local"]::-webkit-clear-button {
            display: none !important;
        }

        /* Ensure inputs have proper text color */
        input, select {
            color: #374151 !important;
        }

        /* Improve date picker appearance - better styling for empty and filled states */
        input[type="datetime-local"]::-webkit-datetime-edit { color: #374151 !important; }
        input[type="datetime-local"]::-webkit-datetime-edit-fields-wrapper { color: #374151 !important; }
        input[type="datetime-local"]::-webkit-datetime-edit-text { color: #9ca3af !important; padding: 0 2px; }
        input[type="datetime-local"]::-webkit-datetime-edit-month-field,
        input[type="datetime-local"]::-webkit-datetime-edit-day-field,
        input[type="datetime-local"]::-webkit-datetime-edit-year-field,
        input[type="datetime-local"]::-webkit-datetime-edit-hour-field,
        input[type="datetime-local"]::-webkit-datetime-edit-minute-field { color: #374151 !important; padding: 0 2px; }
        input[type="datetime-local"]::-webkit-datetime-edit-ampm-field { color: #374151 !important; }
        /* Style placeholder/empty state - when field is empty or invalid */
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-text,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-text { color: #9ca3af !important; }
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-month-field,
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-day-field,
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-year-field,
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-hour-field,
        input[type="datetime-local"]:invalid::-webkit-datetime-edit-minute-field,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-month-field,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-day-field,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-year-field,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-hour-field,
        input[type="datetime-local"]:not([value])::-webkit-datetime-edit-minute-field { color: #9ca3af !important; }
    </style>
</body>
</html>
