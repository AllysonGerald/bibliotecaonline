/**
 * Utilitário de Máscaras para Inputs
 * Biblioteca Online - Sistema de Máscaras
 *
 * Este arquivo exporta todas as máscaras e mantém compatibilidade
 * com a API antiga (InputMasks)
 */

import { PhoneMask } from './phone.js';
import { CpfMask } from './cpf.js';
import { CnpjMask } from './cnpj.js';
import { CepMask } from './cep.js';
import { DateMask } from './date.js';
import { CurrencyMask } from './currency.js';
import { DateTimeMask } from './datetime.js';

/**
 * Classe principal que mantém compatibilidade com código existente
 */
class InputMasks {
    // Métodos de telefone
    static phone(input) {
        PhoneMask.apply(input);
    }

    static unMaskPhone(value) {
        return PhoneMask.remove(value);
    }

    // Métodos de CPF
    static cpf(input) {
        CpfMask.apply(input);
    }

    static unMaskCpf(value) {
        return CpfMask.remove(value);
    }

    // Métodos de CNPJ
    static cnpj(input) {
        CnpjMask.apply(input);
    }

    static unMaskCnpj(value) {
        return CnpjMask.remove(value);
    }

    // Métodos de CEP
    static cep(input) {
        CepMask.apply(input);
    }

    static unMaskCep(value) {
        return CepMask.remove(value);
    }

    // Métodos de data
    static date(input) {
        DateMask.apply(input);
    }

    static unMaskDate(value) {
        return DateMask.remove(value);
    }

    // Métodos de moeda
    static currency(input) {
        CurrencyMask.apply(input);
    }

    static unMaskCurrency(value) {
        return CurrencyMask.remove(value);
    }

    // Métodos de data/hora
    static dateTime(input) {
        DateTimeMask.apply(input);
    }

    static unMaskDateTime(value) {
        return DateTimeMask.remove(value);
    }

    /**
     * Inicializa máscaras em todos os inputs com data-mask
     */
    static init() {
        document.addEventListener('DOMContentLoaded', function() {
            // Máscara de telefone
            document.querySelectorAll('input[data-mask="phone"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.phone(this);
                });

                // Aplica máscara no valor inicial se existir
                if (input.value) {
                    if (!input.value.includes('(') && !input.value.includes(')')) {
                        InputMasks.phone(input);
                    }
                }
            });

            // Máscara de CPF
            document.querySelectorAll('input[data-mask="cpf"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.cpf(this);
                });

                if (input.value) {
                    InputMasks.cpf(input);
                }
            });

            // Máscara de CNPJ
            document.querySelectorAll('input[data-mask="cnpj"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.cnpj(this);
                });

                if (input.value) {
                    InputMasks.cnpj(input);
                }
            });

            // Máscara de CEP
            document.querySelectorAll('input[data-mask="cep"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.cep(this);
                });

                if (input.value) {
                    InputMasks.cep(input);
                }
            });

            // Máscara de data
            document.querySelectorAll('input[data-mask="date"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.date(this);
                });

                if (input.value) {
                    InputMasks.date(input);
                }
            });

            // Máscara de moeda
            document.querySelectorAll('input[data-mask="currency"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.currency(this);
                });

                // Aplica máscara no valor inicial se existir
                if (input.value) {
                    if (!input.value.toString().startsWith('R$')) {
                        let numericValue = parseFloat(input.value) || 0;
                        input.value = numericValue.toString();
                        InputMasks.currency(input);
                    }
                }
            });

            // Máscara de data/hora
            document.querySelectorAll('input[data-mask="datetime"]').forEach(input => {
                input.addEventListener('input', function() {
                    InputMasks.dateTime(this);
                });

                if (input.value) {
                    if (!input.value.includes('/') && !input.value.includes(':')) {
                        InputMasks.dateTime(input);
                    }
                }
            });
        });
    }

    /**
     * Remove máscaras de um formulário antes de enviar
     */
    static removeMasksFromForm(form) {
        // Telefone
        form.querySelectorAll('input[data-mask="phone"]').forEach(input => {
            input.value = InputMasks.unMaskPhone(input.value);
        });

        // CPF
        form.querySelectorAll('input[data-mask="cpf"]').forEach(input => {
            input.value = InputMasks.unMaskCpf(input.value);
        });

        // CNPJ
        form.querySelectorAll('input[data-mask="cnpj"]').forEach(input => {
            input.value = InputMasks.unMaskCnpj(input.value);
        });

        // CEP
        form.querySelectorAll('input[data-mask="cep"]').forEach(input => {
            input.value = InputMasks.unMaskCep(input.value);
        });

        // Data
        form.querySelectorAll('input[data-mask="date"]').forEach(input => {
            input.value = InputMasks.unMaskDate(input.value);
        });

        // Moeda
        form.querySelectorAll('input[data-mask="currency"]').forEach(input => {
            input.value = InputMasks.unMaskCurrency(input.value);
        });

        // Data/Hora
        form.querySelectorAll('input[data-mask="datetime"]').forEach(input => {
            input.value = InputMasks.unMaskDateTime(input.value);
        });
    }
}

// Auto-inicializa quando o script é carregado
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', InputMasks.init);
} else {
    InputMasks.init();
}

// Exporta para uso global (compatibilidade)
window.InputMasks = InputMasks;

// Exporta classes individuais para uso modular
export { PhoneMask, CpfMask, CnpjMask, CepMask, DateMask, CurrencyMask, DateTimeMask };

// Exporta classe principal como default
export default InputMasks;

