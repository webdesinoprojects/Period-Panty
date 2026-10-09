<?php if (!empty($TESTIMONIALS)) { ?>
<section class="py-8 dx-has-art dx-art-drops dx-reviews">
  <div class="container container-xl">
    <div class="row">
      <div class="col-12 mb-7">
        <span class="dx-eyebrow">Real women, real talk</span>
        <h2 class="fs-34">No script, just <strong>honest reviews</strong></h2>
      </div>
    </div>
  </div>
  <div class="dx-rail" tabindex="0" role="group" aria-label="Customer reviews">
    <div class="dx-rail-track">
      <?php $quote_index = 0; foreach ($TESTIMONIALS as $review) {
          $kind = $this->home_content_model->card_type($review);
          $media = $this->home_content_model->media_url($review->image);
          $poster = $this->home_content_model->media_url($review->poster);
          $url = $this->home_content_model->video_url($review->youtube_link);
          $iframe = $this->home_content_model->iframe_url($url);
          $description = trim(strip_tags($review->description));
      ?>
      <?php if ($kind === "quote") { ?>
      <article class="dx-rev dx-rev-quote<?php echo $quote_index++ % 2 ? " dx-rev-quote-alt" : ""; ?>" data-review-id="<?php echo (int) $review->id; ?>">
        <?php $rating = max(0, min(5, (int) $review->rating)); if ($rating) { ?>
        <div class="dx-rev-stars" aria-label="<?php echo $rating; ?> out of 5"><?php echo str_repeat("&#9733;", $rating); ?></div>
        <?php } ?>
        <?php if ($review->country) { ?><p class="dx-rev-flow"><?php echo html_escape($review->country); ?></p><?php } ?>
        <p class="dx-rev-text"><?php echo nl2br(html_escape($description)); ?></p>
        <p class="dx-rev-name"><?php echo html_escape($review->name); ?></p>
      </article>
      <?php } elseif ($kind === "photo" && $media) { ?>
      <article class="dx-rev dx-rev-photo" data-review-id="<?php echo (int) $review->id; ?>">
        <img src="<?php echo html_escape($media); ?>" alt="<?php echo html_escape($description ?: $review->name); ?>" loading="lazy">
      </article>
      <?php } elseif ($kind === "video" && ($media || $url)) {
          // Older Image/Video records may store a video thumbnail in image.
          if (!$poster && preg_match("~\\.(jpg|jpeg|png|webp)$~i", $review->image)) { $poster = $media; }
      ?>
      <article class="dx-rev dx-rev-video" data-review-id="<?php echo (int) $review->id; ?>">
        <?php if ($iframe) { ?>
        <a href="<?php echo html_escape($iframe); ?>" class="dx-rev-video-link" data-gtf-mfp="true" data-mfp-options='{"type":"iframe","preloader":false}' aria-label="<?php echo html_escape("Play " . $review->name); ?>">
          <?php if ($poster) { ?><img src="<?php echo html_escape($poster); ?>" alt="" loading="lazy"><?php } ?>
          <span class="dx-rev-play" aria-hidden="true"><i class="fas fa-play"></i></span>
          <span class="dx-rev-video-caption"><?php echo html_escape($review->name); ?></span>
        </a>
        <?php } else {
            $video = $url ?: $media;
            $extension = strtolower(pathinfo((string) parse_url($video, PHP_URL_PATH), PATHINFO_EXTENSION));
            $mime = $extension === "webm" ? "video/webm" : ($extension === "ogg" ? "video/ogg" : "video/mp4");
        ?>
        <video preload="none" playsinline controls<?php if ($poster) { ?> poster="<?php echo html_escape($poster); ?>"<?php } ?> aria-label="<?php echo html_escape($review->name); ?>">
          <source src="<?php echo html_escape($video); ?>" type="<?php echo $mime; ?>">
          <a href="<?php echo html_escape($video); ?>">Watch the customer review</a>
        </video>
        <?php } ?>
      </article>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>
