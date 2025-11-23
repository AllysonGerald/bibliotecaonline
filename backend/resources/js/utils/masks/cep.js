/**
 * Máscara de CEP
 * Formato: 00000-000
 */

export class CepMask {
    /**
     * Aplica máscara de CEP
     */
    static apply(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d{0,3}).*/, '$1-$2');
        input.value = value;
    }

    /**
     * Remove máscara de CEP
     */
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

