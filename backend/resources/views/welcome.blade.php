<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Biblioteca Online') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-purple { background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 50%, #d946ef 100%); }
        .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #f472b6 50%, #fb7185 100%); }
        .gradient-orange { background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #fdba74 100%); }
        .gradient-hero { background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 50%, #fff1f2 100%); }
        .text-gradient { background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body style="background: linear-gradient(to bottom, #f3e8ff, #ffffff);">
    <nav style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 3px solid #e9d5ff; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.1);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 80px;">
                <div style="display: flex; align-items: center;">
                    <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                            <i data-lucide="book-open" style="width: 32px; height: 32px; color: white;"></i>
                        </div>
                        <span style="font-size: 24px; font-weight: 800; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Biblioteca Online</span>
                    </a>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    @auth
                        <a href="{{ route('home') }}" style="padding: 10px 20px; color: #4b5563; font-weight: 600; text-decoration: none;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="padding: 10px 20px; color: #4b5563; font-weight: 600; text-decoration: none;">Entrar</a>
                        <a href="{{ route('register') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">Cadastrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        <!-- Hero Section -->
        <section style="position: relative; min-height: 85vh; display: flex; align-items: center; justify-content: center; overflow: hidden; background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 50%, #fff1f2 100%);">
            <div style="position: absolute; top: 80px; left: 40px; width: 400px; height: 400px; background: rgba(196, 181, 253, 0.4); border-radius: 50%; filter: blur(80px);"></div>
            <div style="position: absolute; bottom: 80px; right: 40px; width: 400px; height: 400px; background: rgba(251, 113, 133, 0.4); border-radius: 50%; filter: blur(80px);"></div>
            <div style="position: absolute; top: 50%; left: 50%; width: 500px; height: 500px; background: rgba(249, 115, 22, 0.3); border-radius: 50%; filter: blur(80px); transform: translate(-50%, -50%);"></div>
            
            <div style="position: relative; max-width: 1152px; margin: 0 auto; padding: 64px 24px; text-align: center; z-index: 10;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 96px; height: 96px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 24px; margin-bottom: 32px; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5);">
                    <i data-lucide="book-open" style="width: 48px; height: 48px; color: white;"></i>
                </div>
                
                <h1 style="font-size: clamp(3rem, 8vw, 6rem); font-weight: 900; color: #1f2937; margin-bottom: 32px; line-height: 1.2;">
                    <span style="display: block; margin-bottom: 8px;">Explore milhares de</span>
                    <span style="display: block; background: linear-gradient(135deg, #8b5cf6, #ec4899, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">livros incríveis</span>
                </h1>
                
                <p style="margin-top: 32px; max-width: 768px; margin-left: auto; margin-right: auto; font-size: 24px; color: #4b5563; line-height: 1.6; font-weight: 500;">
                    Reserve, alugue e mergulhe no mundo da leitura. Tudo isso de forma simples e rápida.
                </p>
                
                <div style="margin-top: 48px; display: flex; flex-direction: column; gap: 24px; justify-content: center; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 20px 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; font-size: 20px; font-weight: 700; border-radius: 16px; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5); text-decoration: none; min-width: 240px;">
                        <span>Começar Agora</span>
                        <i data-lucide="arrow-right" style="width: 24px; height: 24px; margin-left: 12px;"></i>
                    </a>
                    <a href="#recursos" style="display: inline-flex; align-items: center; justify-content: center; padding: 20px 40px; background: white; color: #4b5563; font-size: 20px; font-weight: 700; border-radius: 16px; border: 4px solid #e9d5ff; text-decoration: none; min-width: 240px; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2);">
                        Saiba Mais
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="recursos" style="padding: 80px 0; background: white;">
            <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
                <div style="text-align: center; margin-bottom: 64px;">
                    <h2 style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; color: #1f2937; margin-bottom: 24px;">
                        Por que escolher nossa biblioteca?
                    </h2>
                    <p style="font-size: 24px; color: #4b5563; max-width: 768px; margin: 0 auto; font-weight: 600;">
                        Tudo o que você precisa em um só lugar
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
                    <!-- Card 1 -->
                    <div style="position: relative; background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 24px; padding: 40px; border: 4px solid #e9d5ff; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.2);">
                        <div style="position: absolute; top: 0; right: 0; width: 160px; height: 160px; background: rgba(196, 181, 253, 0.3); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
                        <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 24px; margin-bottom: 32px; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                            <i data-lucide="book-open" style="width: 40px; height: 40px; color: white;"></i>
                        </div>
                        <h3 style="position: relative; z-index: 1; font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Vasto Acervo</h3>
                        <p style="position: relative; z-index: 1; font-size: 18px; color: #4b5563; line-height: 1.6; font-weight: 500;">
                            Milhares de títulos dos mais variados gêneros à sua disposição.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div style="position: relative; background: linear-gradient(135deg, #fce7f3, #fdf2f8, white); border-radius: 24px; padding: 40px; border: 4px solid #fbcfe8; box-shadow: 0 20px 50px rgba(236, 72, 153, 0.2);">
                        <div style="position: absolute; top: 0; right: 0; width: 160px; height: 160px; background: rgba(251, 113, 133, 0.3); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
                        <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 24px; margin-bottom: 32px; box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4);">
                            <i data-lucide="clock" style="width: 40px; height: 40px; color: white;"></i>
                        </div>
                        <h3 style="position: relative; z-index: 1; font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Reservas Rápidas</h3>
                        <p style="position: relative; z-index: 1; font-size: 18px; color: #4b5563; line-height: 1.6; font-weight: 500;">
                            Reserve seus livros favoritos com apenas alguns cliques.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div style="position: relative; background: linear-gradient(135deg, #fff1f2, #fff7ed, white); border-radius: 24px; padding: 40px; border: 4px solid #fed7aa; box-shadow: 0 20px 50px rgba(249, 115, 22, 0.2);">
                        <div style="position: absolute; top: 0; right: 0; width: 160px; height: 160px; background: rgba(251, 146, 60, 0.3); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
                        <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 24px; margin-bottom: 32px; box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);">
                            <i data-lucide="globe" style="width: 40px; height: 40px; color: white;"></i>
                        </div>
                        <h3 style="position: relative; z-index: 1; font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">100% Online</h3>
                        <p style="position: relative; z-index: 1; font-size: 18px; color: #4b5563; line-height: 1.6; font-weight: 500;">
                            Gerencie seus empréstimos de qualquer lugar, a qualquer hora.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section style="padding: 96px 0; background: linear-gradient(135deg, #1f2937, #111827, #0f172a); position: relative; overflow: hidden;">
            <div style="position: absolute; inset: 0; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4='); opacity: 0.3;"></div>
            <div style="position: relative; max-width: 1152px; margin: 0 auto; padding: 0 24px; text-align: center; z-index: 10;">
                <h2 style="font-size: clamp(3rem, 7vw, 5rem); font-weight: 900; color: white; margin-bottom: 24px; line-height: 1.2;">
                    <span style="display: block; margin-bottom: 8px;">Pronto para começar?</span>
                    <span style="display: block; background: linear-gradient(135deg, #a78bfa, #f472b6, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Cadastre-se gratuitamente hoje.</span>
                </h2>
                <p style="margin-top: 24px; font-size: 24px; color: #d1d5db; max-width: 768px; margin-left: auto; margin-right: auto; font-weight: 600;">
                    Junte-se a milhares de leitores e descubra seu próximo livro favorito.
                </p>
                <div style="margin-top: 48px;">
                    <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 24px 48px; background: linear-gradient(135deg, #8b5cf6, #ec4899, #f97316); color: white; font-size: 24px; font-weight: 900; border-radius: 16px; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5); text-decoration: none;">
                        <span>Criar Conta Grátis</span>
                        <i data-lucide="arrow-right" style="width: 28px; height: 28px; margin-left: 12px;"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer style="background: linear-gradient(135deg, #1f2937, #111827); border-top: 4px solid rgba(139, 92, 246, 0.5);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 48px 24px;">
            <div style="display: flex; flex-direction: column; gap: 16px; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                        <i data-lucide="book-open" style="width: 32px; height: 32px; color: white;"></i>
                    </div>
                    <span style="font-size: 20px; font-weight: 700; color: white;">Biblioteca Online</span>
                </div>
                <p style="font-size: 16px; color: #9ca3af; font-weight: 600;">
                    © {{ date('Y') }} Biblioteca Online. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/lucide@latest"></script>
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
    </script>
</body>
</html>
