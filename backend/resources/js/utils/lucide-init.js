/**
 * Utilitário para inicialização e gerenciamento de ícones Lucide
 * Otimizado para evitar re-execuções desnecessárias
 */

let isInitializing = false;
let lastInitTime = 0;
const INIT_DEBOUNCE_MS = 200; // Debounce de 200ms entre inicializações

export function initLucideIcons() {
    const lucideInstance = window.lucide || (typeof lucide !== 'undefined' ? lucide : null);
    if (lucideInstance && typeof lucideInstance.createIcons === 'function') {
        lucideInstance.createIcons();
    }
}

export function reinitLucideIcons() {
    const now = Date.now();
    
    // Debounce: só re-inicializa se passou tempo suficiente desde a última vez
    if (now - lastInitTime < INIT_DEBOUNCE_MS) {
        return;
    }
    
    if (isInitializing) {
        return;
    }
    
    isInitializing = true;
    lastInitTime = now;
    
    setTimeout(() => {
        const lucideInstance = window.lucide || (typeof lucide !== 'undefined' ? lucide : null);
        if (lucideInstance && typeof lucideInstance.createIcons === 'function') {
            // Não re-inicializar ícones de password-toggle
            const allLucideElements = document.querySelectorAll('[data-lucide]:not([data-password-toggle="true"])');
            const passwordToggleElements = document.querySelectorAll('[data-password-toggle="true"]');
            
            // Criar ícones apenas para elementos que não são password-toggle
            if (allLucideElements.length > 0) {
                lucideInstance.createIcons(Array.from(allLucideElements));
            }
        }
        isInitializing = false;
    }, 100);
}

// Função para aguardar o Lucide carregar
function waitForLucide(callback, maxAttempts = 100) {
    let attempts = 0;
    const checkLucide = () => {
        attempts++;
        const lucideInstance = window.lucide || (typeof lucide !== 'undefined' ? lucide : null);
        if (lucideInstance && typeof lucideInstance.createIcons === 'function') {
            callback();
        } else if (attempts < maxAttempts) {
            setTimeout(checkLucide, 50);
        } else {
            console.warn('Lucide não foi carregado após várias tentativas');
        }
    };
    checkLucide();
}

// Inicializar quando o DOM e Lucide estiverem prontos
function initialize() {
    waitForLucide(() => {
        initLucideIcons();
    });
}

// Aguardar DOM estar pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialize);
} else {
    // DOM já está pronto, inicializar imediatamente
    initialize();
}

// Re-inicializar após mudanças dinâmicas (Alpine.js)
document.addEventListener('alpine:init', () => {
    waitForLucide(() => {
        reinitLucideIcons();
    });
});

// MutationObserver otimizado - só observa mudanças relevantes
let observer;
let observerTimeout;

// Expor observer globalmente para poder desabilitar durante toggle
window.lucideObserver = null;

function setupObserver() {
    if (document.body && !observer) {
        observer = new MutationObserver((mutations) => {
            // Verificar se há novos elementos com data-lucide
            let hasLucideIcons = false;
            let hasPasswordToggle = false;
            
            for (const mutation of mutations) {
                // Verificar mudanças em atributos (data-lucide)
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-lucide') {
                    const target = mutation.target;
                    // Ignorar completamente ícones de password-toggle que estão sendo atualizados
                    if (target.dataset && target.dataset.passwordToggle === 'true') {
                        continue;
                    }
                    if (target.closest && target.closest('.password-toggle-btn')) {
                        continue;
                    }
                    hasLucideIcons = true;
                    break;
                }
                
                // Verificar nós adicionados
                for (const node of mutation.addedNodes) {
                    if (node.nodeType === 1) { // Element node
                        // Ignorar mudanças em password-toggle-btn (já tem seu próprio handler)
                        if (node.classList && node.classList.contains('password-toggle-btn')) {
                            hasPasswordToggle = true;
                            continue;
                        }
                        if (node.closest && node.closest('.password-toggle-btn')) {
                            hasPasswordToggle = true;
                            continue;
                        }
                        
                        // Verificar se o próprio nó ou seus filhos têm data-lucide
                        if (node.hasAttribute && node.hasAttribute('data-lucide')) {
                            // Ignorar se for dentro de password-toggle-btn ou está sendo atualizado
                            if (node.dataset && node.dataset.passwordToggle === 'true') {
                                continue;
                            }
                            if (!node.closest || !node.closest('.password-toggle-btn')) {
                                hasLucideIcons = true;
                            }
                            break;
                        }
                        if (node.querySelectorAll && node.querySelectorAll('[data-lucide]').length > 0) {
                            // Verificar se algum dos ícones encontrados está dentro de password-toggle-btn
                            const icons = node.querySelectorAll('[data-lucide]');
                            let hasNonPasswordIcon = false;
                            for (const icon of icons) {
                                if (icon.dataset && icon.dataset.passwordToggle === 'true') {
                                    continue;
                                }
                                // Verificar se o SVG dentro do ícone também tem o atributo
                                const svg = icon.querySelector('svg[data-password-toggle="true"]');
                                if (svg) {
                                    continue;
                                }
                                if (!icon.closest || !icon.closest('.password-toggle-btn')) {
                                    hasNonPasswordIcon = true;
                                    break;
                                }
                            }
                            if (hasNonPasswordIcon) {
                                hasLucideIcons = true;
                                break;
                            }
                        }
                    }
                }
                if (hasLucideIcons) break;
            }
            
            // Só re-inicializar se houver novos ícones (não password-toggle)
            if (hasLucideIcons && !hasPasswordToggle) {
                clearTimeout(observerTimeout);
                observerTimeout = setTimeout(() => {
                    reinitLucideIcons();
                }, INIT_DEBOUNCE_MS);
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['data-lucide'],
        });
        
        window.lucideObserver = observer;
    }
}

if (document.body) {
    setupObserver();
} else {
    document.addEventListener('DOMContentLoaded', setupObserver);
}

