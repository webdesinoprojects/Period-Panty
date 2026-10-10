(function () {
    "use strict";
    document.querySelectorAll(".dx-explode").forEach(function (figure) {
        var explore = figure.querySelector(".dx-explode-explore");
        var toggle = figure.querySelector(".dx-explode-toggle");
        var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
        function update(state, paused) {
            figure.dataset.state = state;
            figure.dataset.paused = paused ? "true" : "false";
            explore.setAttribute("aria-pressed", state === "exploded" ? "true" : "false");
            explore.firstChild.textContent = state === "exploded" ? "Reassemble " : "Explore the layers ";
            var stopped = state !== "auto" || paused;
            toggle.setAttribute("aria-pressed", stopped ? "true" : "false");
            toggle.setAttribute("aria-label", stopped ? "Play layer animation" : "Pause layer animation");
            toggle.hidden = reducedMotion.matches;
        }
        explore.addEventListener("click", function () {
            update(figure.dataset.state === "exploded" ? "assembled" : "exploded", false);
        });
        toggle.addEventListener("click", function () {
            if (figure.dataset.state !== "auto") {
                update("auto", false);
            } else {
                update("auto", figure.dataset.paused !== "true");
            }
        });
        function applyMotionPreference() {
            update(reducedMotion.matches ? "exploded" : "auto", false);
        }
        if (reducedMotion.addEventListener) {
            reducedMotion.addEventListener("change", applyMotionPreference);
        } else if (reducedMotion.addListener) {
            reducedMotion.addListener(applyMotionPreference);
        }
        applyMotionPreference();
    });
})();
