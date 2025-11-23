import './bootstrap';
import './utils/lucide-init';
import './utils/form-utils';
import './utils/masks/index';
import './utils/password-utils';
import './utils/event-handlers';

// Configurar token CSRF para requisições AJAX
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    // Configurar para fetch
    window.csrfToken = token.content;
    
    // Configurar para Axios se estiver disponível
    if (window.axios) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }
}

// Função global para abrir modais de exclusão
window.openDeleteModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error('Modal not found:', modalId);
        return;
    }
    
    // Mostrar o modal
    modal.style.display = 'block';
    
    // Atualizar ícones Lucide (usando função otimizada)
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        setTimeout(() => {
            window.lucide.createIcons();
        }, 100);
    }
};
