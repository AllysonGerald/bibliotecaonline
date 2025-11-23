/**
 * Máscara de Data
 * Formato: 00/00/0000
 */

export class DateMask {
    /**
     * Aplica máscara de data
     */
    static apply(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d{2})(\d{0,4}).*/, '$1/$2/$3');
        input.value = value;
    }

    /**
     * Remove máscara de data
     */
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

