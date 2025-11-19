/**
 * Password Utilities
 * Utilitários para validação de força de senha, visualização e confirmação
 */

class PasswordUtils {
    /**
     * Calcula a força da senha e retorna um objeto com nível e feedback
     * @param {string} password - A senha a ser avaliada
     * @returns {Object} { level: 'weak'|'medium'|'strong'|'very-strong', score: 0-100, feedback: string[] }
     */
    static checkStrength(password) {
        if (!password) {
            return {
                level: 'weak',
                score: 0,
                feedback: [],
            };
        }

        let score = 0;
        const feedback = [];

        // Critérios de validação
        const hasLength = password.length >= 8;
        const hasMinLength = password.length >= 12;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        const hasRepeatingChars = /(.)\1{2,}/.test(password);
        const hasSequentialChars = /(abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|012|123|234|345|456|567|678|789)/i.test(password);

        // Pontuação baseada em critérios
        if (hasLength) {
            score += 10;
            if (hasMinLength) {
                score += 10;
            }
        } else {
            feedback.push('Use pelo menos 8 caracteres');
        }

        if (hasUpperCase) {
            score += 15;
        } else {
            feedback.push('Adicione letras maiúsculas');
        }

        if (hasLowerCase) {
            score += 15;
        } else {
            feedback.push('Adicione letras minúsculas');
        }

        if (hasNumbers) {
            score += 15;
        } else {
            feedback.push('Adicione números');
        }

        if (hasSpecialChars) {
            score += 20;
        } else {
            feedback.push('Adicione caracteres especiais (!@#$%...)');
        }

        // Penalidades
        if (hasRepeatingChars) {
            score -= 10;
            feedback.push('Evite caracteres repetidos');
        }

        if (hasSequentialChars) {
            score -= 10;
            feedback.push('Evite sequências (abc, 123...)');
        }

        // Limitar score entre 0 e 100
        score = Math.max(0, Math.min(100, score));

        // Determinar nível
        let level = 'weak';
        if (score >= 80) {
            level = 'very-strong';
        } else if (score >= 60) {
            level = 'strong';
        } else if (score >= 40) {
            level = 'medium';
        }

        return {
            level,
            score,
            feedback: feedback.length > 0 ? feedback : [],
        };
    }

    /**
     * Alterna a visibilidade da senha
     * @param {HTMLElement} input - O input de senha
     * @param {HTMLElement} toggleButton - O botão de toggle
     */
    static togglePasswordVisibility(input, toggleButton) {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const icon = toggleButton.querySelector('i');
        if (icon) {
            icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
    }

    /**
     * Valida se as senhas são iguais
     * @param {string} password - A senha principal
     * @param {string} confirmation - A confirmação da senha
     * @returns {Object} { valid: boolean, message: string }
     */
    static validatePasswordMatch(password, confirmation) {
        if (!password && !confirmation) {
            return { valid: true, message: '' };
        }

        if (password !== confirmation) {
            return { valid: false, message: 'As senhas não coincidem' };
        }

        return { valid: true, message: '' };
    }

    /**
     * Inicializa todos os campos de senha na página
     */
    static init() {
        function initializePasswordFields() {
            // Encontrar todos os campos de senha
            document.querySelectorAll('input[type="password"]').forEach(passwordInput => {
                const inputId = passwordInput.id;
                if (!inputId) return;

                // Verificar se já foi inicializado
                if (passwordInput.dataset.passwordInitialized === 'true') return;
                passwordInput.dataset.passwordInitialized = 'true';

                // Criar wrapper se não existir
                let wrapper = passwordInput.parentElement;
                if (!wrapper.style.position || wrapper.style.position !== 'relative') {
                    const newWrapper = document.createElement('div');
                    newWrapper.style.cssText = 'position: relative; width: 100%;';
                    passwordInput.parentNode.insertBefore(newWrapper, passwordInput);
                    newWrapper.appendChild(passwordInput);
                    wrapper = newWrapper;
                } else {
                    wrapper.style.width = '100%';
                }

                // Adicionar botão de visualizar senha
                const toggleButton = document.createElement('button');
                toggleButton.type = 'button';
                toggleButton.setAttribute('aria-label', 'Mostrar senha');
                toggleButton.style.cssText = `
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    background: none;
                    border: none;
                    cursor: pointer;
                    padding: 4px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #6b7280;
                    transition: color 0.3s;
                    z-index: 10;
                `;
                toggleButton.innerHTML = '<i data-lucide="eye" style="width: 18px; height: 18px;"></i>';
                toggleButton.onmouseover = function() { this.style.color = '#374151'; };
                toggleButton.onmouseout = function() { this.style.color = '#6b7280'; };
                toggleButton.onclick = () => PasswordUtils.togglePasswordVisibility(passwordInput, toggleButton);
                wrapper.appendChild(toggleButton);

                // Ajustar padding do input para o botão
                const currentPadding = window.getComputedStyle(passwordInput).paddingRight;
                const paddingValue = parseInt(currentPadding) || 12;
                passwordInput.style.paddingRight = `${paddingValue + 32}px`;

                // Adicionar indicador de força de senha (apenas para campo principal de senha, não confirmação)
                if (!inputId.includes('confirmation') && !inputId.includes('confirm')) {
                    const strengthIndicator = document.createElement('div');
                    strengthIndicator.id = `${inputId}_strength`;
                    strengthIndicator.style.cssText = `
                        margin-top: 8px;
                        display: none;
                    `;
                    wrapper.parentNode.insertBefore(strengthIndicator, wrapper.nextSibling);

                    // Barra de progresso
                    const progressBar = document.createElement('div');
                    progressBar.id = `${inputId}_progress`;
                    progressBar.style.cssText = `
                        width: 100%;
                        height: 4px;
                        background: #e5e7eb;
                        border-radius: 2px;
                        overflow: hidden;
                        margin-bottom: 8px;
                    `;
                    const progressFill = document.createElement('div');
                    progressFill.id = `${inputId}_progress_fill`;
                    progressFill.style.cssText = `
                        height: 100%;
                        width: 0%;
                        transition: all 0.3s;
                        border-radius: 2px;
                    `;
                    progressBar.appendChild(progressFill);
                    strengthIndicator.appendChild(progressBar);

                    // Texto de feedback
                    const feedbackText = document.createElement('div');
                    feedbackText.id = `${inputId}_feedback`;
                    feedbackText.style.cssText = `
                        font-size: 12px;
                        color: #6b7280;
                        margin-top: 4px;
                    `;
                    strengthIndicator.appendChild(feedbackText);

                    // Adicionar listener para verificar força da senha
                    passwordInput.addEventListener('input', function() {
                        const password = this.value;
                        if (password.length > 0) {
                            strengthIndicator.style.display = 'block';
                            const strength = PasswordUtils.checkStrength(password);

                            // Atualizar barra de progresso
                            progressFill.style.width = `${strength.score}%`;

                            // Atualizar cor baseada no nível
                            let color = '#ef4444'; // vermelho - fraco
                            let text = 'Senha fraca';

                            if (strength.level === 'very-strong') {
                                color = '#10b981'; // verde - muito forte
                                text = 'Senha muito forte';
                            } else if (strength.level === 'strong') {
                                color = '#3b82f6'; // azul - forte
                                text = 'Senha forte';
                            } else if (strength.level === 'medium') {
                                color = '#f59e0b'; // laranja - média
                                text = 'Senha média';
                            }

                            progressFill.style.background = color;
                            feedbackText.innerHTML = `<strong style="color: ${color};">${text}</strong>${strength.feedback.length > 0 ? '<br>' + strength.feedback.join(', ') : ''}`;
                        } else {
                            strengthIndicator.style.display = 'none';
                        }
                    });
                }

                // Validar confirmação de senha em tempo real
                if (inputId.includes('confirmation') || inputId.includes('confirm')) {
                    const mainPasswordId = inputId.replace('_confirmation', '').replace('_confirm', '');
                    const mainPasswordInput = document.getElementById(mainPasswordId);

                    if (mainPasswordInput) {
                        const matchIndicator = document.createElement('div');
                        matchIndicator.id = `${inputId}_match`;
                        matchIndicator.style.cssText = `
                            margin-top: 8px;
                            font-size: 12px;
                            display: none;
                        `;
                        wrapper.parentNode.insertBefore(matchIndicator, wrapper.nextSibling);

                        const validateMatch = () => {
                            const password = mainPasswordInput.value;
                            const confirmation = passwordInput.value;

                            if (confirmation.length > 0) {
                                matchIndicator.style.display = 'block';
                                const validation = PasswordUtils.validatePasswordMatch(password, confirmation);

                                if (validation.valid) {
                                    matchIndicator.innerHTML = '<span style="color: #10b981; font-weight: 600;">✓ Senhas coincidem</span>';
                                    passwordInput.style.borderColor = '#10b981';
                                } else {
                                    matchIndicator.innerHTML = `<span style="color: #ef4444; font-weight: 600;">✗ ${validation.message}</span>`;
                                    passwordInput.style.borderColor = '#ef4444';
                                }
                            } else {
                                matchIndicator.style.display = 'none';
                                passwordInput.style.borderColor = '';
                            }
                        };

                        passwordInput.addEventListener('input', validateMatch);
                        mainPasswordInput.addEventListener('input', validateMatch);
                    }
                }
            });

            // Reinicializar ícones Lucide
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        // Auto-inicializa quando o DOM estiver pronto
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializePasswordFields);
        } else {
            initializePasswordFields();
        }

        // Re-inicializar após mudanças dinâmicas (Alpine.js)
        document.addEventListener('alpine:init', () => {
            setTimeout(initializePasswordFields, 100);
        });
    }
}

// Auto-inicializa quando o script é carregado
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', PasswordUtils.init);
} else {
    PasswordUtils.init();
}
