import './bootstrap';
import { createIcons } from 'lucide';

// Inicializar ícones Lucide
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucide);
} else {
    initLucide();
}

function initLucide() {
    createIcons();
}

// Re-inicializar após mudanças dinâmicas (Alpine.js, etc.)
document.addEventListener('alpine:init', () => {
    setTimeout(() => {
        createIcons();
    }, 100);
});
