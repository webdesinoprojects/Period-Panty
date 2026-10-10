<?php defined("BASEPATH") OR exit("No direct script access allowed"); ?>
<?php if ($hero_slides) { ?>
<section class="dx-hero dx-hero-lifestyle" aria-label="Discover DEXTE period comfort">
    <div class="dx-hero-track slick-slider" data-slick-options='{"slidesToShow":1,"infinite":true,"autoplay":true,"autoplaySpeed":6500,"dots":true,"arrows":false,"fade":true,"cssEase":"ease-in-out","speed":800,"pauseOnHover":true,"pauseOnFocus":true,"adaptiveHeight":false}'>
        <?php foreach ($hero_slides as $hero_index => $hero_slide) {
            $hero_heading = $hero_index === 0 ? "h1" : "h2";
            $hero_title = str_replace("|", "\n", $hero_slide->title);
            $hero_button = !empty($hero_slide->button_title) ? $hero_slide->button_title : "Shop Now";
            $hero_href = !empty($hero_slide->button_link) ? base_url($hero_slide->button_link) : base_url("shop");
        ?>
        <div class="dx-hero-slide">
            <img class="dx-lifestyle-photo"
                 src="<?php echo html_escape(base_url("uploads/slider/" . $hero_slide->image)); ?>"
                 alt="" width="1860" height="845"
                 <?php if ($hero_index === 0) { ?>fetchpriority="high"<?php } else { ?>loading="lazy"<?php } ?>>
            <div class="dx-lifestyle-content">
                <div class="dx-lifestyle-copy">
                    <?php if ($hero_logo) { ?>
                    <img class="dx-lifestyle-brand" src="<?php echo html_escape(base_url("uploads/" . $hero_logo)); ?>" alt="DEXTE — Make your rules" width="140" height="110">
                    <?php } ?>
                    <<?php echo $hero_heading; ?> class="dx-lifestyle-title"><?php echo nl2br(html_escape($hero_title)); ?></<?php echo $hero_heading; ?>>
                    <?php if (!empty($hero_slide->description)) { ?>
                    <p class="dx-lifestyle-description"><?php echo nl2br(html_escape($hero_slide->description)); ?></p>
                    <?php } ?>
                    <a class="dx-lifestyle-button" href="<?php echo html_escape($hero_href); ?>"><?php echo html_escape($hero_button); ?><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 12h15m-5-5 5 5-5 5"/></svg></a>
                </div>
                <p class="dx-lifestyle-note">Your period.<br>Your comfort.<br>Your choice.</p>
            </div>
        </div>
        <?php } ?>
    </div>
    <button class="dx-lifestyle-pause" type="button" aria-label="Pause slideshow" aria-pressed="false"><span aria-hidden="true">Ⅱ</span></button>
</section>
<script>
(function () {
    function initializeHeroControls() {
        var hero = document.querySelector(".dx-hero-lifestyle");
        if (!hero || !window.jQuery) { return; }
        var track = window.jQuery(hero.querySelector(".dx-hero-track"));
        var toggle = hero.querySelector(".dx-lifestyle-pause");
        var reduced = window.matchMedia("(prefers-reduced-motion: reduce)");
        function setPaused(paused) {
            if (track.hasClass("slick-initialized")) {
                track.slick(paused ? "slickPause" : "slickPlay");
            }
            toggle.setAttribute("aria-pressed", paused ? "true" : "false");
            toggle.setAttribute("aria-label", paused ? "Play slideshow" : "Pause slideshow");
            toggle.firstElementChild.textContent = paused ? "▶" : "Ⅱ";
        }
        toggle.addEventListener("click", function () {
            setPaused(toggle.getAttribute("aria-pressed") !== "true");
        });
        track.on("init", function () { if (reduced.matches) { setPaused(true); } });
        if (reduced.matches) { setPaused(true); }
        if (reduced.addEventListener) {
            reduced.addEventListener("change", function (event) { setPaused(event.matches); });
        }
        if (track.children(".dx-hero-slide").length < 2) { toggle.hidden = true; }
    }
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeHeroControls);
    } else { initializeHeroControls(); }
})();
</script>
<?php } ?>
