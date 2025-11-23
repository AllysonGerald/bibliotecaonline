/**
 * Máscara de Moeda Brasileira
 * Formato: R$ 0,00
 */

export class CurrencyMask {
    /**
     * Aplica máscara de moeda brasileira
     */
    static apply(input) {
        let value = input.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2) + '';
        value = value.replace('.', ',');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = 'R$ ' + value;
    }

    /**
     * Remove máscara de moeda e retorna valor numérico
     */
    static remove(value) {
        if (!value) return '';
        let numericValue = value.replace(/[^\d,]/g, '').replace(',', '.');
        return parseFloat(numericValue) || 0;
    }
}

