/**
 * Máscara de Data/Hora
 * Formato: 00/00/0000 00:00
 */

export class DateTimeMask {
    /**
     * Aplica máscara de data/hora
     */
    static apply(input) {
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
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

