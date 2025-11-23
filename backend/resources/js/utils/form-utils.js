/**
 * Utilitários para formulários
 */

/**
 * Remove máscaras de todos os campos de um formulário antes de enviar
 * @param {HTMLFormElement} form - Formulário a ser processado
 */
export function removeMasksFromForm(form) {
    if (typeof InputMasks !== 'undefined') {
        InputMasks.removeMasksFromForm(form);
    }
}

/**
 * Previne múltiplos submits do formulário
 * @param {HTMLFormElement} form - Formulário a ser protegido
 */
function preventMultipleSubmits(form) {
    let isSubmitting = false;
    
    form.addEventListener('submit', function(e) {
        // Se já está submetendo, prevenir
        if (isSubmitting) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
        
        // Verificar se o formulário tem token CSRF
        const csrfToken = form.querySelector('input[name="_token"]');
        if (!csrfToken) {
            // Se não tem token, pode ser um problema - não bloquear, mas avisar
            console.warn('Formulário sem token CSRF detectado');
        }
        
        isSubmitting = true;
        
        // Reabilitar após 5 segundos (caso haja erro de validação ou CSRF)
        setTimeout(() => {
            isSubmitting = false;
            // Reabilitar botões de submit
            const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            submitButtons.forEach(btn => {
                btn.disabled = false;
                if (btn.style) {
                    btn.style.opacity = '';
                    btn.style.cursor = '';
                }
            });
        }, 5000);
        
        // Desabilitar botões de submit apenas visualmente (não bloquear o submit)
        const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
        submitButtons.forEach(btn => {
            if (btn.style) {
                btn.style.opacity = '0.6';
                btn.style.cursor = 'wait';
            }
        });
    });
}

// Removido: preventMultipleClicks - sem restrições de clique

/**
 * Inicializa listeners para remover máscaras antes do submit
 */
export function initFormMaskRemoval() {
    // Usar uma flag para evitar múltiplas inicializações
    if (window.formUtilsInitialized) {
        return;
    }
    window.formUtilsInitialized = true;
    
    function initializeForms() {
        // Proteger formulários
        document.querySelectorAll('form').forEach(form => {
            // Verificar se já foi inicializado
            if (form.dataset.formUtilsInitialized === 'true') {
                return;
            }
            form.dataset.formUtilsInitialized = 'true';
            
            // Adicionar proteção contra múltiplos submits
            preventMultipleSubmits(form);
            
            // Adicionar listener para remover máscaras
            form.addEventListener('submit', function(e) {
                removeMasksFromForm(this);
            });
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeForms);
    } else {
        initializeForms();
    }
}

// Inicializar automaticamente
initFormMaskRemoval();

