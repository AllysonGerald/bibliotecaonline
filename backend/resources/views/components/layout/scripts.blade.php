{{-- Componente para scripts compartilhados --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    (function() {
        function ensureLucide() {
            if (typeof lucide !== 'undefined') {
                window.lucide = lucide;
                if (document.readyState === 'complete' || document.readyState === 'interactive') {
                    lucide.createIcons();
                } else {
                    document.addEventListener('DOMContentLoaded', function() {
                        lucide.createIcons();
                    });
                }
            } else {
                setTimeout(ensureLucide, 50);
            }
        }
        ensureLucide();
    })();
</script>
@vite(['resources/js/app.js'])

<style>
    [x-cloak] { display: none !important; }

    /* Remove outline padrão e aplica focus ring do Tailwind */
    input:focus,
    textarea:focus,
    select:focus {
        outline: none !important;
    }

    /* Custom select styling - Remove native arrow and add custom one */
    select {
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 16px !important;
        padding-right: 40px !important;
    }

    select:focus {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    }

    /* Custom datetime-local input styling */
    input[type="datetime-local"] {
        position: relative;
        padding-right: 10px !important;
    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: 16px !important;
        cursor: pointer !important;
        opacity: 1 !important;
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    input[type="datetime-local"]:focus::-webkit-calendar-picker-indicator {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
    }

    input[type="datetime-local"]::-webkit-inner-spin-button,
    input[type="datetime-local"]::-webkit-clear-button {
        display: none !important;
    }

    /* Custom date input styling */
    input[type="date"] {
        position: relative;
        padding-right: 10px !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: 16px !important;
        cursor: pointer !important;
        opacity: 1 !important;
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    input[type="date"]:focus::-webkit-calendar-picker-indicator {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b5cf6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
    }

    /* Ensure inputs have proper text color */
    input, select {
        color: #374151 !important;
    }

    /* Improve date picker appearance */
    input[type="datetime-local"]::-webkit-datetime-edit,
    input[type="datetime-local"]::-webkit-datetime-edit-fields-wrapper,
    input[type="datetime-local"]::-webkit-datetime-edit-month-field,
    input[type="datetime-local"]::-webkit-datetime-edit-day-field,
    input[type="datetime-local"]::-webkit-datetime-edit-year-field,
    input[type="datetime-local"]::-webkit-datetime-edit-hour-field,
    input[type="datetime-local"]::-webkit-datetime-edit-minute-field,
    input[type="datetime-local"]::-webkit-datetime-edit-ampm-field {
        color: #374151 !important;
    }

    input[type="datetime-local"]::-webkit-datetime-edit-text {
        color: #9ca3af !important;
        padding: 0 2px;
    }

    input[type="datetime-local"]:invalid::-webkit-datetime-edit-text,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-text,
    input[type="datetime-local"]:invalid::-webkit-datetime-edit-month-field,
    input[type="datetime-local"]:invalid::-webkit-datetime-edit-day-field,
    input[type="datetime-local"]:invalid::-webkit-datetime-edit-year-field,
    input[type="datetime-local"]:invalid::-webkit-datetime-edit-hour-field,
    input[type="datetime-local"]:invalid::-webkit-datetime-edit-minute-field,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-month-field,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-day-field,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-year-field,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-hour-field,
    input[type="datetime-local"]:not([value])::-webkit-datetime-edit-minute-field {
        color: #9ca3af !important;
    }
</style>
