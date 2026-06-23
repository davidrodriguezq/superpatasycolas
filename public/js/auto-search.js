(function () {
    'use strict';

    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function showLoadingState(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status"></span> Buscando...';
        }
    }

    function initAutoSearch() {
        const forms = document.querySelectorAll('[data-auto-search]');

        forms.forEach(function (form) {
            // Inputs de texto: debounce de 500ms antes de enviar
            const textInputs = form.querySelectorAll('input[type="text"], input[type="search"]');
            textInputs.forEach(function (input) {
                input.addEventListener(
                    'input',
                    debounce(function () {
                        showLoadingState(form);
                        form.submit();
                    }, 500)
                );
            });

            // Selects: envío inmediato al cambiar
            const selects = form.querySelectorAll('select');
            selects.forEach(function (select) {
                select.addEventListener('change', function () {
                    showLoadingState(form);
                    form.submit();
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoSearch);
    } else {
        initAutoSearch();
    }
})();
