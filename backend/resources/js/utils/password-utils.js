/**
 * Password Utilities
 * Utilitários para validação de força de senha, visualização e confirmação
 */

class PasswordUtils {
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

        const hasLength = password.length >= 8;
        const hasMinLength = password.length >= 12;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        const hasRepeatingChars = /(.)\1{2,}/.test(password);
        const hasSequentialChars = /(abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|012|123|234|345|456|567|678|789)/i.test(password);

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

        if (hasRepeatingChars) {
            score -= 10;
            feedback.push('Evite caracteres repetidos');
        }

        if (hasSequentialChars) {
            score -= 10;
            feedback.push('Evite sequências (abc, 123...)');
        }

        score = Math.max(0, Math.min(100, score));

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

    static validatePasswordMatch(password, confirmation) {
        if (!password && !confirmation) {
            return { valid: true, message: '' };
        }

        if (password !== confirmation) {
            return { valid: false, message: 'As senhas não coincidem' };
        }

        return { valid: true, message: '' };
    }

    static init() {
        function initializePasswordFields() {
            document.querySelectorAll('input[type="password"], input[name*="password"][type="text"]').forEach(passwordInput => {
                if (passwordInput.dataset.passwordInitialized === 'true') return;
                passwordInput.dataset.passwordInitialized = 'true';

                if (passwordInput.type === 'text' && passwordInput.name && passwordInput.name.includes('password')) {
                    passwordInput.type = 'password';
                }

                let wrapper = passwordInput.parentElement;
                if (!wrapper || window.getComputedStyle(wrapper).position !== 'relative') {
                    const newWrapper = document.createElement('div');
                    newWrapper.style.cssText = 'position: relative; width: 100%;';
                    passwordInput.parentNode.insertBefore(newWrapper, passwordInput);
                    newWrapper.appendChild(passwordInput);
                    wrapper = newWrapper;
                }

                const toggleButton = document.createElement('button');
                toggleButton.type = 'button';
                toggleButton.className = 'password-toggle-btn';
                toggleButton.setAttribute('aria-label', 'Mostrar senha');
                toggleButton.style.cssText = `
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    background: transparent;
                    border: none;
                    cursor: pointer;
                    padding: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #6b7280;
                    z-index: 10000;
                    pointer-events: auto;
                    min-width: 32px;
                    min-height: 32px;
                `;

                const iconSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                iconSvg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                iconSvg.setAttribute('width', '18');
                iconSvg.setAttribute('height', '18');
                iconSvg.setAttribute('viewBox', '0 0 24 24');
                iconSvg.setAttribute('fill', 'none');
                iconSvg.setAttribute('stroke', 'currentColor');
                iconSvg.setAttribute('stroke-width', '2');
                iconSvg.setAttribute('stroke-linecap', 'round');
                iconSvg.setAttribute('stroke-linejoin', 'round');
                iconSvg.setAttribute('data-password-toggle', 'true');
                iconSvg.style.cssText = 'width: 18px; height: 18px; pointer-events: none; display: block;';

                toggleButton.appendChild(iconSvg);
                wrapper.appendChild(toggleButton);

                function createEyeContent() {
                    const path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path1.setAttribute('d', 'M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z');
                    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                    circle.setAttribute('cx', '12');
                    circle.setAttribute('cy', '12');
                    circle.setAttribute('r', '3');
                    return [path1, circle];
                }

                function createEyeClosedContent() {
                    const path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path1.setAttribute('d', 'M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5z');
                    const path2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path2.setAttribute('d', 'M9 12a3 3 0 1 0 6 0 3 3 0 1 0-6 0z');
                    return [path1, path2];
                }

                function updateIcon(forceType = null) {
                    const inputType = forceType !== null ? forceType : passwordInput.type;

                    while (iconSvg.firstChild) {
                        iconSvg.removeChild(iconSvg.firstChild);
                    }

                    if (inputType === 'password') {
                        const elements = createEyeContent();
                        elements.forEach(el => iconSvg.appendChild(el));
                        toggleButton.setAttribute('aria-label', 'Mostrar senha');
                        toggleButton.classList.remove('password-visible');
                        toggleButton.classList.add('password-hidden');
                    } else {
                        const elements = createEyeClosedContent();
                        elements.forEach(el => iconSvg.appendChild(el));
                        toggleButton.setAttribute('aria-label', 'Ocultar senha');
                        toggleButton.classList.remove('password-hidden');
                        toggleButton.classList.add('password-visible');
                    }
                }

                updateIcon();
                if (toggleButton.dataset.listenerAdded === 'true') {
                    return;
                }
                toggleButton.dataset.listenerAdded = 'true';

                function togglePassword(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const currentType = passwordInput.type;
                    const newType = currentType === 'password' ? 'text' : 'password';

                    passwordInput.type = newType;
                    updateIcon(newType);

                    return false;
                }

                toggleButton.addEventListener('click', togglePassword, false);

                const currentPadding = parseInt(window.getComputedStyle(passwordInput).paddingRight) || 12;
                passwordInput.style.paddingRight = `${currentPadding + 40}px`;

                const form = passwordInput.closest('form');
                const isLoginField = form && (
                    form.action.includes('/login') ||
                    window.location.pathname.includes('/login')
                );

                if (!passwordInput.id.includes('confirmation') && !passwordInput.id.includes('confirm') && !isLoginField) {
                    const strengthIndicator = document.createElement('div');
                    strengthIndicator.id = `${passwordInput.id || 'password'}_strength`;
                    strengthIndicator.style.cssText = 'margin-top: 8px; display: none;';
                    wrapper.parentNode.insertBefore(strengthIndicator, wrapper.nextSibling);

                    const progressBar = document.createElement('div');
                    progressBar.style.cssText = 'width: 100%; height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden; margin-bottom: 8px;';
                    const progressFill = document.createElement('div');
                    progressFill.style.cssText = 'height: 100%; width: 0%; transition: all 0.3s; border-radius: 2px;';
                    progressBar.appendChild(progressFill);
                    strengthIndicator.appendChild(progressBar);

                    const feedbackText = document.createElement('div');
                    feedbackText.style.cssText = 'font-size: 12px; color: #6b7280; margin-top: 4px;';
                    strengthIndicator.appendChild(feedbackText);

                    function updateStrength() {
                        const password = passwordInput.value;
                        if (password.length > 0) {
                            strengthIndicator.style.display = 'block';
                            const strength = PasswordUtils.checkStrength(password);

                            progressFill.style.width = `${strength.score}%`;

                            let color = '#ef4444';
                            let text = 'Senha fraca';

                            if (strength.level === 'very-strong') {
                                color = '#10b981';
                                text = 'Senha muito forte';
                            } else if (strength.level === 'strong') {
                                color = '#3b82f6';
                                text = 'Senha forte';
                            } else if (strength.level === 'medium') {
                                color = '#f59e0b';
                                text = 'Senha média';
                            }

                            progressFill.style.background = color;
                            feedbackText.innerHTML = `<strong style="color: ${color};">${text}</strong>${strength.feedback.length > 0 ? '<br><span style="font-size: 11px; color: #6b7280;">' + strength.feedback.join(', ') + '</span>' : ''}`;
                        } else {
                            strengthIndicator.style.display = 'none';
                        }
                    }

                    passwordInput.addEventListener('input', updateStrength);
                    if (passwordInput.value) updateStrength();
                }

                if (passwordInput.id.includes('confirmation') || passwordInput.id.includes('confirm')) {
                    let mainPasswordId = passwordInput.id.replace('_confirmation', '').replace('_confirm', '');
                    if (passwordInput.id === 'password_confirmation') {
                        mainPasswordId = 'password';
                    }
                    let mainPasswordInput = document.getElementById(mainPasswordId);

                    if (!mainPasswordInput) {
                        const form = passwordInput.closest('form');
                        if (form) {
                            mainPasswordInput = form.querySelector('input[type="password"][name="password"]');
                        }
                    }

                    if (mainPasswordInput) {
                        const matchIndicator = document.createElement('div');
                        matchIndicator.style.cssText = 'margin-top: 8px; font-size: 12px; display: none;';
                        wrapper.parentNode.insertBefore(matchIndicator, wrapper.nextSibling);

                        function validateMatch() {
                            const password = mainPasswordInput.value;
                            const confirmation = passwordInput.value;

                            if (confirmation.length > 0 || password.length > 0) {
                                matchIndicator.style.display = 'block';
                                const validation = PasswordUtils.validatePasswordMatch(password, confirmation);

                                if (validation.valid && password.length > 0 && confirmation.length > 0) {
                                    matchIndicator.innerHTML = '<span style="color: #10b981; font-weight: 600;">✓ Senhas coincidem</span>';
                                    passwordInput.style.borderColor = '#10b981';
                                } else if (confirmation.length > 0) {
                                    matchIndicator.innerHTML = `<span style="color: #ef4444; font-weight: 600;">✗ ${validation.message}</span>`;
                                    passwordInput.style.borderColor = '#ef4444';
                                } else {
                                    matchIndicator.style.display = 'none';
                                    passwordInput.style.borderColor = '';
                                }
                            } else {
                                matchIndicator.style.display = 'none';
                                passwordInput.style.borderColor = '';
                            }
                        }

                        passwordInput.addEventListener('input', validateMatch);
                        mainPasswordInput.addEventListener('input', validateMatch);
                    }
                }
            });

            setTimeout(() => {
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }
            }, 100);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializePasswordFields);
        } else {
            initializePasswordFields();
        }

        let passwordObserver;
        function setupPasswordObserver() {
            if (document.body && !passwordObserver) {
                passwordObserver = new MutationObserver((mutations) => {
                    let hasNewPasswordInputs = false;

                    for (const mutation of mutations) {
                        for (const node of mutation.addedNodes) {
                            if (node.nodeType === 1) {
                                if (node.tagName === 'INPUT' &&
                                    (node.type === 'password' || (node.name && node.name.includes('password'))) &&
                                    node.dataset.passwordInitialized !== 'true') {
                                    hasNewPasswordInputs = true;
                                    break;
                                }
                                if (node.querySelectorAll) {
                                    const passwordInputs = node.querySelectorAll('input[type="password"], input[name*="password"]');
                                    for (const input of passwordInputs) {
                                        if (input.dataset.passwordInitialized !== 'true') {
                                            hasNewPasswordInputs = true;
                                            break;
                                        }
                                    }
                                }
                                if (hasNewPasswordInputs) break;
                            }
                        }
                        if (hasNewPasswordInputs) break;
                    }

                    if (hasNewPasswordInputs) {
                        setTimeout(initializePasswordFields, 100);
                    }
                });

                passwordObserver.observe(document.body, {
                    childList: true,
                    subtree: true,
                    attributes: false,
                });
            }
        }

        if (document.body) {
            setupPasswordObserver();
        } else {
            document.addEventListener('DOMContentLoaded', setupPasswordObserver);
        }
    }
}

window.PasswordUtils = PasswordUtils;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => PasswordUtils.init());
} else {
    PasswordUtils.init();
}

export default PasswordUtils;
