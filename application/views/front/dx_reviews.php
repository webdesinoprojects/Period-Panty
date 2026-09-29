<?php
/**
 * Customer review wall - vertical video tiles and stall photographs mixed
 * with quote cards, in the manner of the reference site.
 *
 * Deliberate rule about attribution: the photographs are of real, identifiable
 * customers taken at DEXTE stalls, and nobody supplied a quote to go with
 * them. So no caption is attached to a face. The quote cards instead carry
 * testimonials that are already published on this site (front/flows_marquee),
 * with the names their authors gave. Nothing here is invented.
 *
 * Videos ship as WebM (VP9 + Opus) with an MP4 fallback, poster images, and
 * preload="none" so the page costs nothing until someone presses play. Native
 * controls, so there is no custom player script to break.
 */
$dx_media = base_url('assets/front/media/');

$dx_quotes = array(
    array('name' => 'Nikita Srivastav', 'flow' => 'Heavy flow',
          'text' => 'My first two days are very heavy compared to the last two. I was searching for these panties and got them from Dexte at a very reasonable price. Now I don\'t have to think twice before going anywhere.'),
    array('name' => 'Radhika Sharma', 'flow' => 'Moderate flow',
          'text' => 'Being a working woman it is a heavy task to carry tampons, pads and cups. Dexte period panty is a game changer for me - lightweight, comfortable and the absorbency is up to the mark.'),
    array('name' => 'Swati Verma', 'flow' => 'Moderate heavy flow',
          'text' => 'The material quality is excellent and the fit is exceptional. The waistband is stretchy and doesn\'t dig into my skin, and the leg openings are snug without being too tight.'),
);
?>

<section class="py-8 dx-has-art dx-art-drops dx-reviews">
  <div class="container container-xl">
    <div class="row">
      <div class="col-12 mb-7">
        <span class="dx-eyebrow">Real women, real talk</span>
        <h2 class="fs-34">No script, just <strong>honest reviews</strong></h2>
      </div>
    </div>
  </div>

  <!-- Rail scrolls horizontally; it is a plain overflow container rather than
       a carousel, so there is no slider library to initialise or break. -->
  <div class="dx-rail" tabindex="0" role="group" aria-label="Customer reviews">
    <div class="dx-rail-track">

      <article class="dx-rev dx-rev-video">
        <video preload="none" playsinline controls poster="<?php echo $dx_media; ?>review-1.webp">
          <source src="<?php echo $dx_media; ?>review-1.webm" type="video/webm">
          <source src="<?php echo $dx_media; ?>review-1.mp4" type="video/mp4">
        </video>
      </article>

      <article class="dx-rev dx-rev-quote">
        <div class="dx-rev-stars" aria-label="5 out of 5">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="dx-rev-flow"><?php echo $dx_quotes[0]['flow']; ?></p>
        <p class="dx-rev-text"><?php echo $dx_quotes[0]['text']; ?></p>
        <p class="dx-rev-name"><?php echo $dx_quotes[0]['name']; ?></p>
      </article>

      <article class="dx-rev dx-rev-photo">
        <img src="<?php echo $dx_media; ?>shot-3.webp" alt="A customer at a DEXTE stall holding a pack of period panties" loading="lazy">
      </article>

      <article class="dx-rev dx-rev-video">
        <video preload="none" playsinline controls poster="<?php echo $dx_media; ?>review-2.webp">
          <source src="<?php echo $dx_media; ?>review-2.webm" type="video/webm">
          <source src="<?php echo $dx_media; ?>review-2.mp4" type="video/mp4">
        </video>
      </article>

      <article class="dx-rev dx-rev-quote dx-rev-quote-alt">
        <div class="dx-rev-stars" aria-label="5 out of 5">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="dx-rev-flow"><?php echo $dx_quotes[1]['flow']; ?></p>
        <p class="dx-rev-text"><?php echo $dx_quotes[1]['text']; ?></p>
        <p class="dx-rev-name"><?php echo $dx_quotes[1]['name']; ?></p>
      </article>

      <article class="dx-rev dx-rev-photo">
        <img src="<?php echo $dx_media; ?>shot-4.webp" alt="DEXTE customers at a stall" loading="lazy">
      </article>

      <article class="dx-rev dx-rev-video">
        <video preload="none" playsinline controls poster="<?php echo $dx_media; ?>review-3.webp">
          <source src="<?php echo $dx_media; ?>review-3.webm" type="video/webm">
          <source src="<?php echo $dx_media; ?>review-3.mp4" type="video/mp4">
        </video>
      </article>

      <article class="dx-rev dx-rev-quote">
        <div class="dx-rev-stars" aria-label="5 out of 5">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="dx-rev-flow"><?php echo $dx_quotes[2]['flow']; ?></p>
        <p class="dx-rev-text"><?php echo $dx_quotes[2]['text']; ?></p>
        <p class="dx-rev-name"><?php echo $dx_quotes[2]['name']; ?></p>
      </article>

      <article class="dx-rev dx-rev-photo">
        <img src="<?php echo $dx_media; ?>shot-6.webp" alt="DEXTE customers at a stall" loading="lazy">
      </article>

    </div>
  </div>
</section>
