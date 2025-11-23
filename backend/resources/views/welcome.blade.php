@extends('layouts.welcome')

@section('title', 'Biblioteca Online - Explore milhares de livros incríveis')

@section('content')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .hero-icon {
        animation: float 6s ease-in-out infinite;
    }
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    .fade-in-up-delay-1 {
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }
    .fade-in-up-delay-2 {
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }
    .fade-in-up-delay-3 {
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }
    .pulse-hover:hover {
        animation: pulse 1s ease-in-out;
    }
    @media (max-width: 768px) {
        .hero-buttons {
            flex-direction: column;
            width: 100%;
        }
        .hero-buttons > * {
            width: 100%;
        }
    }
</style>

<nav style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 3px solid #e9d5ff; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.1);">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; height: 80px;">
            <div style="display: flex; align-items: center;">
                <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                        <x-ui.icon name="book-open" size="32" style="color: white;" />
                    </div>
                    <span style="font-size: 24px; font-weight: 800; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Biblioteca Online</span>
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                @auth
                    <x-ui.button href="{{ route('home') }}" variant="link" class="font-size: 16px; font-weight: 600;">
                        Dashboard
                    </x-ui.button>
                @else
                    <x-ui.button href="{{ route('login') }}" variant="link" class="font-size: 16px; font-weight: 600; padding: 10px 20px;">
                        Entrar
                    </x-ui.button>
                    <x-ui.button href="{{ route('register') }}" variant="primary" class="padding: 12px 24px; font-size: 16px; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                        Cadastrar
                    </x-ui.button>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main>
    <!-- Hero Section -->
    <section style="position: relative; min-height: 90vh; display: flex; align-items: center; justify-content: center; overflow: hidden; background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 50%, #fff1f2 100%);">
        <!-- Decorative Background Blurs -->
        <div style="position: absolute; top: 80px; left: 40px; width: 400px; height: 400px; background: rgba(196, 181, 253, 0.4); border-radius: 50%; filter: blur(80px); animation: float 8s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: 80px; right: 40px; width: 400px; height: 400px; background: rgba(251, 113, 133, 0.4); border-radius: 50%; filter: blur(80px); animation: float 10s ease-in-out infinite reverse;"></div>
        <div style="position: absolute; top: 50%; left: 50%; width: 500px; height: 500px; background: rgba(249, 115, 22, 0.3); border-radius: 50%; filter: blur(80px); transform: translate(-50%, -50%); animation: float 12s ease-in-out infinite;"></div>

        <div style="position: relative; max-width: 1152px; margin: 0 auto; padding: 80px 24px; text-align: center; z-index: 10;">
            <div class="hero-icon fade-in-up" style="display: inline-flex; align-items: center; justify-content: center; width: 120px; height: 120px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 28px; margin-bottom: 40px; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5);">
                <i data-lucide="book-open" style="width: 72px; height: 72px; color: white; stroke-width: 2;"></i>
            </div>

            <h1 class="fade-in-up-delay-1" style="font-size: clamp(2.5rem, 8vw, 6rem); font-weight: 900; color: #1f2937; margin-bottom: 32px; line-height: 1.1;">
                <span style="display: block; margin-bottom: 12px;">Explore milhares de</span>
                <span style="display: block; background: linear-gradient(135deg, #8b5cf6, #ec4899, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">livros incríveis</span>
            </h1>

            <p class="fade-in-up-delay-2" style="margin-top: 32px; max-width: 768px; margin-left: auto; margin-right: auto; font-size: clamp(18px, 3vw, 24px); color: #4b5563; line-height: 1.7; font-weight: 500;">
                Reserve, alugue e mergulhe no mundo da leitura. Tudo isso de forma simples e rápida.
            </p>

            <div class="fade-in-up-delay-3 hero-buttons" style="margin-top: 56px; display: flex; gap: 24px; justify-content: center; align-items: center; flex-wrap: wrap;">
                <x-ui.button
                    href="{{ route('register') }}"
                    variant="primary"
                    icon="arrow-right"
                    class="padding: 20px 48px; font-size: clamp(16px, 2.5vw, 20px); min-width: 240px; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5); pulse-hover"
                >
                    Começar Agora
                </x-ui.button>
                <x-ui.button
                    href="#recursos"
                    variant="outline"
                    icon="arrow-down"
                    class="padding: 20px 48px; font-size: clamp(16px, 2.5vw, 20px); min-width: 240px; background: white; border-width: 4px; border-color: #8b5cf6; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2);"
                >
                    Saiba Mais
                </x-ui.button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="recursos" style="padding: 100px 0; background: linear-gradient(to bottom, white, #faf5ff); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(196, 181, 253, 0.2); border-radius: 50%; filter: blur(80px);"></div>
        <div style="position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; background: rgba(251, 113, 133, 0.2); border-radius: 50%; filter: blur(80px);"></div>

        <div style="position: relative; max-width: 1280px; margin: 0 auto; padding: 0 24px; z-index: 10;">
            <div style="text-align: center; margin-bottom: 80px;">
                <h2 style="font-size: clamp(2rem, 6vw, 4rem); font-weight: 900; color: #1f2937; margin-bottom: 24px; line-height: 1.2;">
                    Por que escolher nossa biblioteca?
                </h2>
                <p style="font-size: clamp(18px, 2.5vw, 24px); color: #4b5563; max-width: 768px; margin: 0 auto; font-weight: 600; line-height: 1.6;">
                    Tudo o que você precisa em um só lugar
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; justify-items: center; align-items: start;">
                <x-welcome.feature-card
                    icon="book-open"
                    title="Vasto Acervo"
                    iconGradient="linear-gradient(135deg, #8b5cf6, #a855f7)"
                    backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
                    borderColor="#e9d5ff"
                    shadowColor="rgba(139, 92, 246, 0.2)"
                    blurColor="rgba(196, 181, 253, 0.3)"
                >
                    Milhares de títulos dos mais variados gêneros à sua disposição.
                </x-welcome.feature-card>

                <x-welcome.feature-card
                    icon="clock"
                    title="Reservas Rápidas"
                    iconGradient="linear-gradient(135deg, #ec4899, #f472b6)"
                    backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
                    borderColor="#fbcfe8"
                    shadowColor="rgba(236, 72, 153, 0.2)"
                    blurColor="rgba(251, 113, 133, 0.3)"
                >
                    Reserve seus livros favoritos com apenas alguns cliques.
                </x-welcome.feature-card>

                <x-welcome.feature-card
                    icon="globe"
                    title="100% Online"
                    iconGradient="linear-gradient(135deg, #f97316, #fb923c)"
                    backgroundGradient="linear-gradient(135deg, #fff1f2, #fff7ed, white)"
                    borderColor="#fed7aa"
                    shadowColor="rgba(249, 115, 22, 0.2)"
                    blurColor="rgba(251, 146, 60, 0.3)"
                >
                    Gerencie seus empréstimos de qualquer lugar, a qualquer hora.
                </x-welcome.feature-card>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section style="padding: 80px 0; background: white; position: relative;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center;">
                <div style="padding: 32px;">
                    <div style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px;">10K+</div>
                    <div style="font-size: 18px; color: #4b5563; font-weight: 600;">Livros Disponíveis</div>
                </div>
                <div style="padding: 32px;">
                    <div style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; background: linear-gradient(135deg, #ec4899, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px;">5K+</div>
                    <div style="font-size: 18px; color: #4b5563; font-weight: 600;">Usuários Ativos</div>
                </div>
                <div style="padding: 32px;">
                    <div style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; background: linear-gradient(135deg, #f97316, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px;">50K+</div>
                    <div style="font-size: 18px; color: #4b5563; font-weight: 600;">Empréstimos Realizados</div>
                </div>
                <div style="padding: 32px;">
                    <div style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; background: linear-gradient(135deg, #8b5cf6, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px;">100%</div>
                    <div style="font-size: 18px; color: #4b5563; font-weight: 600;">Satisfação</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 120px 0; background: linear-gradient(135deg, #1f2937, #111827, #0f172a); position: relative; overflow: hidden;">
        <div style="position: absolute; inset: 0; background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4='); opacity: 0.3;"></div>
        <div style="position: absolute; top: -200px; right: -200px; width: 600px; height: 600px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(100px);"></div>
        <div style="position: absolute; bottom: -200px; left: -200px; width: 600px; height: 600px; background: rgba(236, 72, 153, 0.1); border-radius: 50%; filter: blur(100px);"></div>

        <div style="position: relative; max-width: 1152px; margin: 0 auto; padding: 0 24px; text-align: center; z-index: 10;">
            <h2 style="font-size: clamp(2.5rem, 7vw, 5rem); font-weight: 900; color: white; margin-bottom: 32px; line-height: 1.2;">
                <span style="display: block; margin-bottom: 12px;">Pronto para começar?</span>
                <span style="display: block; background: linear-gradient(135deg, #a78bfa, #f472b6, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Cadastre-se gratuitamente hoje.</span>
            </h2>
            <p style="margin-top: 24px; font-size: clamp(18px, 2.5vw, 24px); color: #d1d5db; max-width: 768px; margin-left: auto; margin-right: auto; font-weight: 600; line-height: 1.6;">
                Junte-se a milhares de leitores e descubra seu próximo livro favorito.
            </p>
            <div style="margin-top: 56px;">
                <x-ui.button
                    href="{{ route('register') }}"
                    variant="primary"
                    icon="arrow-right"
                    class="padding: 24px 56px; font-size: clamp(18px, 2.5vw, 24px); font-weight: 900; background: linear-gradient(135deg, #8b5cf6, #ec4899, #f97316); border-color: transparent; box-shadow: 0 20px 50px rgba(139, 92, 246, 0.5); pulse-hover"
                >
                    Criar Conta Grátis
                </x-ui.button>
            </div>
        </div>
    </section>
</main>

<footer style="background: linear-gradient(135deg, #1f2937, #111827); border-top: 4px solid rgba(139, 92, 246, 0.5); padding: 64px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; flex-direction: column; gap: 32px; align-items: center; text-align: center;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
                    <x-ui.icon name="book-open" size="32" style="color: white;" />
                </div>
                <span style="font-size: 24px; font-weight: 700; background: linear-gradient(135deg, #a78bfa, #f472b6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Biblioteca Online</span>
            </div>
            <div style="display: flex; gap: 32px; flex-wrap: wrap; justify-content: center;">
                <a href="#recursos" style="color: #9ca3af; text-decoration: none; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#9ca3af'">Recursos</a>
                <a href="{{ route('contato') }}" style="color: #9ca3af; text-decoration: none; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#9ca3af'">Contato</a>
                @guest
                    <a href="{{ route('login') }}" style="color: #9ca3af; text-decoration: none; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#9ca3af'">Entrar</a>
                    <a href="{{ route('register') }}" style="color: #9ca3af; text-decoration: none; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#9ca3af'">Cadastrar</a>
                @endguest
            </div>
            <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-top: 16px;">
                © {{ date('Y') }} Biblioteca Online. Todos os direitos reservados.
            </p>
        </div>
    </div>
</footer>

<script>
    // Smooth scroll para âncoras
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Garantir que o ícone do hero seja renderizado
    function initHeroIcon() {
        const heroIcon = document.querySelector('.hero-icon i[data-lucide="book-open"]');
        if (heroIcon && typeof lucide !== 'undefined') {
            lucide.createIcons();
        } else if (heroIcon) {
            setTimeout(initHeroIcon, 100);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroIcon);
    } else {
        initHeroIcon();
    }
</script>
@endsection
