/**
 * Máscara de CPF
 * Formato: 000.000.000-00
 */

export class CpfMask {
    /**
     * Aplica máscara de CPF
     */
    static apply(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2}).*/, '$1.$2.$3-$4');
        input.value = value;
    }

    /**
     * Remove máscara de CPF
     */
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

