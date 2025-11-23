/**
 * Event Handlers Utilitários
 * Centraliza todos os event listeners para evitar conflitos
 */

class EventHandlers {
    constructor() {
        this.initialized = false;
        this.listeners = new Map();
    }

    /**
     * Inicializa todos os event handlers
     */
    init() {
        if (this.initialized) return;
        this.initialized = true;

        // Sidebar collapse toggle
        this.initSidebarToggle();

        // Mobile sidebar toggle
        this.initMobileSidebar();

        // Sidebar links - garantir navegação imediata
        this.initSidebarLinks();

        // User menu (Alpine.js já cuida, mas garantimos)
        this.initUserMenu();

        // Garantir clicabilidade de botões de ícone
        this.initIconButtons();
    }

    /**
     * Inicializa toggle de colapso da sidebar (desktop)
     */
    initSidebarToggle() {
        const collapseBtn = document.getElementById('sidebar-collapse-btn');
        if (!collapseBtn) return;

        // Remover listeners anteriores se existirem
        if (this.listeners.has('sidebar-collapse')) {
            const { element, handler } = this.listeners.get('sidebar-collapse');
            element.removeEventListener('click', handler);
        }

        const handler = (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggleSidebarCollapse();
        };

        collapseBtn.addEventListener('click', handler, { capture: true, passive: false });
        this.listeners.set('sidebar-collapse', { element: collapseBtn, handler });
    }

    /**
     * Toggle sidebar collapse
     */
    toggleSidebarCollapse() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const toggleIcon = document.querySelector('.desktop-sidebar-toggle .sidebar-toggle-icon');

        if (!sidebar) return;

        const isCollapsed = sidebar.classList.contains('collapsed');

        if (isCollapsed) {
            sidebar.classList.remove('collapsed');
            if (mainContent) mainContent.style.marginLeft = '280px';
            if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
            localStorage.setItem('sidebarCollapsed', 'false');
        } else {
            sidebar.classList.add('collapsed');
            if (mainContent) mainContent.style.marginLeft = '80px';
            if (toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
            localStorage.setItem('sidebarCollapsed', 'true');
        }
    }

    /**
     * Restaura estado da sidebar ao carregar
     */
    restoreSidebarState() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const toggleIcon = document.querySelector('.desktop-sidebar-toggle .sidebar-toggle-icon');

        if (!sidebar) return;

        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            if (mainContent) {
                mainContent.style.marginLeft = '80px';
                mainContent.style.transition = 'margin-left 0.3s ease';
            }
            if (toggleIcon) {
                toggleIcon.style.transform = 'rotate(180deg)';
            }
        }
    }

    /**
     * Inicializa toggle mobile sidebar
     */
    initMobileSidebar() {
        const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
        const overlay = document.getElementById('sidebar-overlay');

        if (mobileToggle) {
            const handler = () => {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('open');
                    if (overlay) overlay.classList.toggle('active');
                }
            };

            mobileToggle.addEventListener('click', handler);
            this.listeners.set('mobile-sidebar', { element: mobileToggle, handler });
        }

        if (overlay) {
            const handler = () => {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            };

            overlay.addEventListener('click', handler);
            this.listeners.set('sidebar-overlay', { element: overlay, handler });
        }
    }

    /**
     * Garante que links da sidebar funcionem imediatamente
     */
    initSidebarLinks() {
        const handler = (e) => {
            const link = e.target.closest('.sidebar-link-fast, .sidebar-nav-link');
            if (link) {
                link.dataset.processing = 'false';
                // Permitir navegação normal
            }
        };

        document.addEventListener('click', handler, { capture: true, passive: true });
        this.listeners.set('sidebar-links', { element: document, handler });
    }

    /**
     * Inicializa user menu (Alpine.js já cuida, mas garantimos)
     */
    initUserMenu() {
        // Alpine.js já gerencia, apenas garantimos que não há conflitos
        // Não precisamos fazer nada aqui
    }

    /**
     * Garante clicabilidade de botões de ícone
     */
    initIconButtons() {
        // Aplicar estilos apenas uma vez no DOMContentLoaded
        // Os estilos CSS já cuidam disso, mas garantimos aqui também
        const applyStyles = () => {
            document.querySelectorAll('.icon-only-btn:not(.password-toggle-btn), .action-btn-view, .action-btn-edit, .action-btn-delete').forEach(btn => {
                // CSS já cuida disso, mas garantimos
                if (!btn.style.pointerEvents || btn.style.pointerEvents === 'none') {
                    btn.style.pointerEvents = 'auto';
                }
                if (!btn.style.cursor || btn.style.cursor === 'default') {
                    btn.style.cursor = 'pointer';
                }

                // Garantir que ícones dentro não bloqueiem
                const icons = btn.querySelectorAll('i[data-lucide], svg');
                icons.forEach(icon => {
                    icon.style.pointerEvents = 'none';
                });
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', applyStyles);
        } else {
            applyStyles();
        }
    }

    /**
     * Limpa todos os listeners (útil para testes)
     */
    cleanup() {
        this.listeners.forEach(({ element, handler }, key) => {
            element.removeEventListener('click', handler);
        });
        this.listeners.clear();
        this.initialized = false;
    }
}

// Instância global
window.EventHandlers = new EventHandlers();

// Auto-inicializa
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.EventHandlers.init();
        window.EventHandlers.restoreSidebarState();
    });
} else {
    window.EventHandlers.init();
    window.EventHandlers.restoreSidebarState();
}

export default window.EventHandlers;

