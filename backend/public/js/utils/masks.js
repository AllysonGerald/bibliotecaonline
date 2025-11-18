/**
 * Utilitário de Máscaras para Inputs
 * Biblioteca Online - Sistema de Máscaras
 */

class InputMasks {
    /**
     * Aplica máscara de telefone brasileiro
     * Formato: (00) 00000-0000 ou (00) 0000-0000
     */
    static phone(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length <= 10) {
            // Telefone fixo: (00) 0000-0000
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
        } else {
            // Celular: (00) 00000-0000
            value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
        }
        
        input.value = value;
    }

    /**
     * Remove máscara de telefone
     * Retorna apenas números
     */
    static unMaskPhone(value) {
        return value ? value.replace(/\D/g, '') : '';
    }

    /**
     * Aplica máscara de CPF
     * Formato: 000.000.000-00
     */
    static cpf(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2}).*/, '$1.$2.$3-$4');
        input.value = value;
    }

    /**
     * Remove máscara de CPF
     */
    static unMaskCpf(value) {
        return value ? value.replace(/\D/g, '') : '';
    }

    /**
     * Aplica máscara de CNPJ
     * Formato: 00.000.000/0000-00
     */
    static cnpj(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2}).*/, '$1.$2.$3/$4-$5');
        input.value = value;
    }

    /**
     * Remove máscara de CNPJ
     */
    static unMaskCnpj(value) {
        return value ? value.replace(/\D/g, '') : '';
    }

    /**
     * Aplica máscara de CEP
     * Formato: 00000-000
     */
    static cep(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d{0,3}).*/, '$1-$2');
        input.value = value;
    }

    /**
     * Remove máscara de CEP
     */
    static unMaskCep(value) {
        return value ? value.replace(/\D/g, '') : '';
    }

    /**
     * Aplica máscara de data
     * Formato: 00/00/0000
     */
    static date(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d{2})(\d{0,4}).*/, '$1/$2/$3');
        input.value = value;
    }

    /**
     * Remove máscara de data
     */
    static unMaskDate(value) {
        return value ? value.replace(/\D/g, '') : '';
    }

    /**
     * Aplica máscara de moeda brasileira
     * Formato: R$ 0,00
     */
    static currency(input) {
        let value = input.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2) + '';
        value = value.replace('.', ',');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = 'R$ ' + value;
    }

    /**
     * Remove máscara de moeda e retorna valor numérico
     */
    static unMaskCurrency(value) {
        if (!value) return '';
        let numericValue = value.replace(/[^\d,]/g, '').replace(',', '.');
        return parseFloat(numericValue) || 0;
    }

    /**
     * Aplica máscara de data/hora
     * Formato: 00/00/0000 00:00
     */
    static dateTime(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length <= 8) {
            // Apenas data: 00/00/0000
            value = value.replace(/^(\d{2})(\d{2})(\d{0,4}).*/, '$1/$2/$3');
        } else if (value.length <= 10) {
            // Data completa: 00/00/0000
            value = value.replace(/^(\d{2})(\d{2})(\d{4}).*/, '$1/$2/$3');
        } else if (value.length <= 12) {
            // Data + hora parcial: 00/00/0000 00
            value = value.replace(/^(\d{2})(\d{2})(\d{4})(\d{0,2}).*/, '$1/$2/$3 $4');
        } else {
            // Data + hora completa: 00/00/0000 00:00
            value = value.replace(/^(\d{2})(\d{2})(\d{4})(\d{2})(\d{0,2}).*/, '$1/$2/$3 $4:$5');
        }
        
        input.value = value;
    }

    /**
     * Remove máscara de data/hora
     */
    static unMaskDateTime(value) {
        return value ? value.replace(/\D/g, '') : '';
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
                
                // Aplica máscara no valor inicial se existir (mesmo que venha sem máscara do banco)
                if (input.value) {
                    // Se o valor não tem máscara (só números), aplica a máscara
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
                
                // Aplica máscara no valor inicial se existir (mesmo que venha sem máscara do banco)
                if (input.value) {
                    // Se o valor não tem máscara (não começa com R$), aplica a máscara
                    if (!input.value.toString().startsWith('R$')) {
                        // Converte valor numérico para formato de moeda
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
                    // Se o valor não tem máscara, aplica a máscara
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

// Exporta para uso global
window.InputMasks = InputMasks;

