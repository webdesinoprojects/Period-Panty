<?php
/**
 * Editorial customer-story wall.
 *
 * The names and review copy below come from the testimonial strip this view
 * replaces. The complete set is rendered twice so CSS can move it in one
 * continuous loop without a blank gap. The second copy is hidden from screen
 * readers because it is decorative duplication, not additional content.
 */
$dx_flow_reviews = array(
    array(
        "name" => "Nikita Srivastav",
        "flow" => "Heavy flow",
        "title" => "Freedom on my heaviest days",
        "text" => "My first two days are very heavy. Dexte is comfortable, the fabric feels so good, and now I do not have to think twice before going anywhere."
    ),
    array(
        "name" => "Radhika Sharma",
        "flow" => "Moderate flow",
        "title" => "A game changer for workdays",
        "text" => "Carrying pads, tampons and cups used to feel like a task. Dexte feels lightweight and comfortable, and the absorbency is up to the mark."
    ),
    array(
        "name" => "Swati Verma",
        "flow" => "Moderate heavy flow",
        "title" => "The fit feels exceptional",
        "text" => "The material quality is excellent. The waistband stretches without digging into my skin and the leg openings feel snug without being too tight."
    ),
    array(
        "name" => "Ranjana Rathore",
        "flow" => "Very light flow",
        "title" => "Better nights, fewer worries",
        "text" => "I prefer period panties because they are sustainable, absorbent and comfortable through a typical day. They also help me avoid stains on my sheets at night."
    ),
    array(
        "name" => "Khushi",
        "flow" => "Light moderate flow",
        "title" => "Comfort from first day to last",
        "text" => "For the light first and last days of my cycle, a period panty feels extremely comfortable. The absorbency and quality genuinely impressed me."
    ),
    array(
        "name" => "Ishita",
        "flow" => "Moderate flow",
        "title" => "Confidence, day and night",
        "text" => "My flow often changes to spotting, but the high-waist period panty keeps me comfortable through the day and night without worrying about leaks."
    ),
    array(
        "name" => "Kanika Taneja",
        "flow" => "Moderate heavy flow",
        "title" => "Absorbency beyond expectations",
        "text" => "Dexte handled my heavy flow without leaks or irritation. It is easy to clean and reusable, which makes it a great alternative to disposable pads."
    ),
    array(
        "name" => "Priyanka Singh",
        "flow" => "Light moderate flow",
        "title" => "A seamless, secure fit",
        "text" => "I love the ease of mid-waist period panties. They need no extra product, feel seamless and give me confidence during the day or overnight."
    )
);

$dx_flow_styles = array("note", "bubble", "feature", "post", "mini", "quote", "recommend", "profile");
?>

<section class="dx-flow-stories" aria-labelledby="dx-flow-heading">
    <span class="dx-flow-lily" aria-hidden="true"></span>

    <svg class="dx-flow-symbols" aria-hidden="true" width="0" height="0">
        <defs>
            <symbol id="dx-flower-mark" viewBox="0 0 64 64">
                <path d="M32 28C20 20 18 8 32 4C46 8 44 20 32 28Z"></path>
                <path d="M36 32C44 20 56 18 60 32C56 46 44 44 36 32Z"></path>
                <path d="M32 36C44 44 46 56 32 60C18 56 20 44 32 36Z"></path>
                <path d="M28 32C20 44 8 46 4 32C8 18 20 20 28 32Z"></path>
                <circle cx="32" cy="32" r="5"></circle>
            </symbol>
            <symbol id="dx-sprig-mark" viewBox="0 0 80 80">
                <path d="M12 70C31 53 43 35 61 10"></path>
                <path d="M31 51C18 49 14 39 15 31C25 32 34 39 31 51Z"></path>
                <path d="M44 34C43 20 51 14 61 12C61 23 56 32 44 34Z"></path>
                <path d="M51 24C39 21 35 13 37 5C47 7 53 14 51 24Z"></path>
            </symbol>
        </defs>
    </svg>

    <div class="container container-xl dx-flow-head">
        <span class="dx-eyebrow dx-eyebrow-center">Real women, real stories</span>
        <h2 id="dx-flow-heading">Every flow has a <strong>story</strong></h2>
        <p>Honest experiences from women who found comfort, confidence and freedom with DEXTE.</p>
    </div>

    <div class="dx-flow-viewport" tabindex="0" role="region" aria-label="Customer reviews. The reviews move automatically; hover or focus to pause.">
        <div class="dx-flow-track">
            <?php for ($dx_copy = 0; $dx_copy < 2; $dx_copy++) { ?>
                <div class="dx-flow-set"<?php echo $dx_copy === 1 ? " aria-hidden=\"true\"" : ""; ?>>
                    <?php foreach ($dx_flow_reviews as $dx_i => $dx_review) { ?>
                        <article class="dx-flow-card dx-flow-<?php echo $dx_flow_styles[$dx_i]; ?>">
                            <svg class="dx-flow-card-flower" viewBox="0 0 64 64" aria-hidden="true">
                                <use href="#dx-flower-mark"></use>
                            </svg>
                            <svg class="dx-flow-card-sprig" viewBox="0 0 80 80" aria-hidden="true">
                                <use href="#dx-sprig-mark"></use>
                            </svg>

                            <div class="dx-flow-card-top">
                                <span class="dx-flow-meta">
                                    <span class="dx-flow-name">
                                        <strong><?php echo $dx_review["name"]; ?></strong>
                                        <svg viewBox="0 0 24 24" role="img" aria-label="Verified customer">
                                            <circle cx="12" cy="12" r="11"></circle>
                                            <path d="M7.5 12.3L10.5 15.2L16.8 8.8"></path>
                                        </svg>
                                    </span>
                                    <span><?php echo $dx_review["flow"]; ?></span>
                                </span>
                                <span class="dx-flow-quote-mark" aria-hidden="true">&ldquo;</span>
                            </div>

                            <div class="dx-flow-stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3><?php echo $dx_review["title"]; ?></h3>
                            <p><?php echo $dx_review["text"]; ?></p>

                        </article>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <p class="dx-flow-pause"><span aria-hidden="true"></span> Hover to pause and read</p>
</section>
