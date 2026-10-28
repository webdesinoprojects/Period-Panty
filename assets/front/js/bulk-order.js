(function () {
    'use strict';
    var form = document.getElementById('bulk-order-form');
    if (!form) { return; }
    var sizes = Array.prototype.slice.call(form.querySelectorAll('input[name="sizes[]"]'));
    function validateSizes() {
        if (sizes.length) { sizes[0].setCustomValidity(sizes.some(function (size) { return size.checked; }) ? '' : 'Choose at least one size, or Mixed / advise me.'); }
    }
    sizes.forEach(function (size) { size.addEventListener('change', validateSizes); });
    validateSizes();
    form.addEventListener('submit', function () {
        var button = form.querySelector('button[type="submit"]');
        if (button) { button.disabled = true; button.textContent = 'Saving your enquiry…'; }
    });
}());
