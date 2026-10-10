(function () {
    "use strict";
    var input = document.getElementById("logo");
    var preview = document.getElementById("logo_preview");
    if (!input || !preview) { return; }
    var currentUrl = null;
    input.addEventListener("change", function () {
        var file = input.files[0];
        if (!file) { return; }
        if (!/\.(jpe?g|png)$/i.test(file.name)) {
            window.alert("Please choose a JPG or PNG image.");
            input.value = "";
            return;
        }
        if (currentUrl) { URL.revokeObjectURL(currentUrl); }
        currentUrl = URL.createObjectURL(file);
        var image = document.createElement("img");
        image.alt = "New slider image preview";
        image.style.maxWidth = "100%";
        image.style.width = "500px";
        image.style.height = "auto";
        image.src = currentUrl;
        preview.replaceChildren(image);
    });
})();
