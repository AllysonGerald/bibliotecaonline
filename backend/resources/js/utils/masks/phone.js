/**
 * Máscara de Telefone Brasileiro
 * Formato: (00) 00000-0000 ou (00) 0000-0000
 */

export class PhoneMask {
    /**
     * Aplica máscara de telefone brasileiro
     */
    static apply(input) {
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
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

