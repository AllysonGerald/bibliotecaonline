/**
 * Máscara de CNPJ
 * Formato: 00.000.000/0000-00
 */

export class CnpjMask {
    /**
     * Aplica máscara de CNPJ
     */
    static apply(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2}).*/, '$1.$2.$3/$4-$5');
        input.value = value;
    }

    /**
     * Remove máscara de CNPJ
     */
    static remove(value) {
        return value ? value.replace(/\D/g, '') : '';
    }
}

