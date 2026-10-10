<?php defined("BASEPATH") OR exit("No direct script access allowed"); ?>
<figure class="dx-explode" data-state="auto" data-paused="false" aria-label="Four-layer underwear illustration">
    <p class="dx-explode-kicker"><span aria-hidden="true"></span>A little look inside</p>
    <div class="dx-explode-stage">
        <svg class="dx-explode-art" viewBox="0 0 500 730" role="img" aria-labelledby="dx-explode-title dx-explode-description">
            <title id="dx-explode-title">Four layers, working together</title>
            <desc id="dx-explode-description">An illustrative underwear cutaway separates into soft inner fabric, an absorbent core, a protective barrier, and outer fabric, then reassembles. This is a simplified illustration, not a manufacturing cross-section.</desc>
            <defs>
                <path id="dx-panty-silhouette" d="M20 30Q210 69 400 30L388 85C323 107 288 160 258 250Q210 268 162 250C132 160 97 107 32 85Z"/>
                <path id="dx-panty-gusset" d="M145 96Q210 122 275 96C249 155 245 205 241 249Q210 260 179 249C175 205 171 155 145 96Z"/>
                <clipPath id="dx-panty-clip"><use href="#dx-panty-silhouette"/></clipPath>
                <linearGradient id="dx-outer-fabric" x1="0" y1="0" x2=".8" y2="1">
                    <stop stop-color="#c28394"/><stop offset=".5" stop-color="#ad6179"/><stop offset="1" stop-color="#82465c"/>
                </linearGradient>
                <linearGradient id="dx-inner-fabric" x1="0" y1="0" x2=".7" y2="1">
                    <stop stop-color="#fffdf8"/><stop offset="1" stop-color="#e4d8c4"/>
                </linearGradient>
                <linearGradient id="dx-core-fabric" x1="0" y1="0" x2=".8" y2="1">
                    <stop stop-color="#f7e5e7"/><stop offset="1" stop-color="#dbaab5"/>
                </linearGradient>
                <linearGradient id="dx-barrier-fabric" x1="0" y1="0" x2=".9" y2="1">
                    <stop stop-color="#e8ece0"/><stop offset="1" stop-color="#a3af93"/>
                </linearGradient>
                <pattern id="dx-fabric-knit" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M2 0L4 4 2 8M6 0L8 4 6 8" fill="none" stroke="#fff" stroke-width=".6" opacity=".25"/>
                </pattern>
                <pattern id="dx-core-dots" width="9" height="9" patternUnits="userSpaceOnUse">
                    <circle cx="4.5" cy="4.5" r="1.3" fill="#b16c80" opacity=".3"/>
                </pattern>
                <g id="dx-fabric-seams" fill="none" stroke-linecap="round">
                    <path d="M25 42Q210 81 395 42M31 77C106 105 139 166 166 245M389 77C314 105 281 166 254 245" stroke="#fff" stroke-opacity=".75" stroke-width="2"/>
                    <path d="M30 50Q210 88 390 50M38 83C112 118 145 180 171 248M382 83C308 118 275 180 249 248" stroke="#fff" stroke-opacity=".4" stroke-width="1.3" stroke-dasharray="3 4"/>
                </g>
            </defs>
            <g class="dx-explode-orbit" fill="none" stroke="#d8cfbf" stroke-width="1" opacity=".65" aria-hidden="true">
                <ellipse cx="231" cy="412" rx="207" ry="253" stroke-dasharray="3 10"/>
                <path d="M60 180C-20 330 35 577 170 650"/>
                <circle cx="395" cy="250" r="4" fill="#b59a72" stroke="none"/>
                <circle cx="76" cy="555" r="3" fill="#b04a63" stroke="none"/>
            </g>
            <ellipse class="dx-explode-shadow" cx="224" cy="660" rx="164" ry="18" fill="#988974" opacity=".12"/>
            <g transform="translate(48 430)">
                <!-- Draw bottom-first so the closed state forms one garment. -->
                <g class="dx-explode-layer dx-explode-layer-4" style="--dx-lift:0px">
                    <g transform="matrix(1 .07 -.24 .62 38 8)">
                        <use href="#dx-panty-silhouette" transform="translate(0 8)" fill="#754154"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-outer-fabric)" stroke="#8c5066" stroke-width="1.5"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-fabric-knit)"/>
                        <use href="#dx-panty-gusset" fill="#8d4d62" opacity=".33"/>
                        <use href="#dx-fabric-seams"/>
                        <path d="M181 251Q210 260 239 251" fill="none" stroke="#e3bac6" stroke-width="2"/>
                    </g>
                    <path class="dx-explode-guide" d="M366 88H421" fill="none" stroke="#b38495" stroke-width="1.3" stroke-dasharray="3 4"/>
                </g>
                <g class="dx-explode-layer dx-explode-layer-3" style="--dx-lift:-110px">
                    <g transform="matrix(1 .07 -.24 .62 38 8)">
                        <use href="#dx-panty-silhouette" transform="translate(0 5)" fill="#99a58a"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-barrier-fabric)" stroke="#9da78d" stroke-width="1.3"/>
                        <use href="#dx-panty-gusset" fill="#7f906d" opacity=".28"/>
                        <path d="M145 96Q210 122 275 96M179 248Q210 260 241 248" fill="none" stroke="#f9faf4" stroke-width="2"/>
                        <use href="#dx-fabric-seams"/>
                    </g>
                    <path class="dx-explode-guide" d="M366 88H421" fill="none" stroke="#8c987c" stroke-width="1.3" stroke-dasharray="3 4"/>
                </g>
                <g class="dx-explode-layer dx-explode-layer-2" style="--dx-lift:-220px">
                    <g transform="matrix(1 .07 -.24 .62 38 8)">
                        <use href="#dx-panty-silhouette" transform="translate(0 7)" fill="#c18b9b"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-core-fabric)" stroke="#cba5af" stroke-width="1.3"/>
                        <use href="#dx-panty-gusset" fill="#efd0d8" stroke="#c897a6" stroke-width="1.4"/>
                        <use href="#dx-panty-gusset" fill="url(#dx-core-dots)"/>
                        <use href="#dx-fabric-seams"/>
                    </g>
                    <path class="dx-explode-guide" d="M366 88H421" fill="none" stroke="#b57f90" stroke-width="1.3" stroke-dasharray="3 4"/>
                </g>
                <g class="dx-explode-layer dx-explode-layer-1" style="--dx-lift:-330px">
                    <g transform="matrix(1 .07 -.24 .62 38 8)">
                        <use href="#dx-panty-silhouette" transform="translate(0 4)" fill="#cfc0a5"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-inner-fabric)" stroke="#c5b89d" stroke-width="1.5"/>
                        <use href="#dx-panty-silhouette" fill="url(#dx-fabric-knit)"/>
                        <use href="#dx-panty-gusset" fill="#e7d6b9" opacity=".68"/>
                        <use href="#dx-fabric-seams"/>
                        <path d="M145 96Q210 122 275 96" fill="none" stroke="#c4b496" stroke-width="1.2" stroke-dasharray="3 4"/>
                    </g>
                    <path class="dx-explode-guide" d="M366 88H421" fill="none" stroke="#b5a482" stroke-width="1.3" stroke-dasharray="3 4"/>
                </g>
            </g>
        </svg>
        <ol class="dx-explode-labels">
            <li style="--dx-label-top:25%"><span class="dx-explode-number">01</span><div><strong>Soft inner fabric</strong><span>Comfort against your skin</span></div></li>
            <li style="--dx-label-top:40%"><span class="dx-explode-number">02</span><div><strong>Absorbent core</strong><span>Helps hold moisture</span></div></li>
            <li style="--dx-label-top:55%"><span class="dx-explode-number">03</span><div><strong>Protective barrier</strong><span>Helps prevent leaks</span></div></li>
            <li style="--dx-label-top:70%"><span class="dx-explode-number">04</span><div><strong>Outer fabric</strong><span>Comfort, with everyday shape</span></div></li>
        </ol>
    </div>
    <figcaption>
        <div class="dx-explode-controls">
            <button class="dx-explode-explore" type="button" aria-pressed="false">Explore the layers <span aria-hidden="true">↗</span></button>
            <button class="dx-explode-toggle" type="button" aria-label="Pause layer animation" aria-pressed="false"><svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor" aria-hidden="true"><path class="dx-explode-pause-icon" d="M5 4h3v12H5zm7 0h3v12h-3z"/><path class="dx-explode-play-icon" d="m6 3 10 7-10 7z"/></svg></button>
        </div>
        <p class="dx-explode-caption">Four layers. One considered design.<small>Illustrative layer view.</small></p>
    </figcaption>
</figure>
<script src="<?php echo base_url("assets/front/js/exploded-underwear.js"); ?>" defer></script>
