(function () {
    "use strict";
    var form = document.getElementById("contact_form");
    if (!form) { return; }
    var button = form.querySelector("button[type='submit']");
    function resetButton() {
        button.disabled = false;
        form.removeAttribute("aria-busy");
        button.firstElementChild.textContent = "Send message";
    }
    form.addEventListener("submit", function () {
        if (!form.checkValidity()) { return; }
        button.disabled = true;
        form.setAttribute("aria-busy", "true");
        button.firstElementChild.textContent = "Sending…";
    });
    window.addEventListener("pageshow", resetButton);
    var feedback = document.querySelector(".dx-contact-feedback");
    if (feedback) { feedback.focus(); }
})();
