<main class="dx-about">
  <section class="dx-about-hero dx-about-exploded-hero">
    <div class="container container-xl">
      <div class="dx-about-hero-copy" data-animate="fadeInUp">
        <span class="dx-eyebrow"><?php echo $RESULT[0]->title; ?></span>
        <h1>Comfort made for <em>real life.</em></h1>
        <p>DEXTE brings together thoughtful design, everyday comfort and confident protection for women of every age.</p>
        <a class="dx-about-button" href="<?php echo base_url('shop'); ?>">
          Explore the collection
          <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
      <?php $this->load->view("front/includes/exploded_underwear"); ?>
    </div>
    <span class="dx-about-hero-word" aria-hidden="true">Fearless</span>
  </section>

  <section class="dx-about-story dx-has-art dx-art-petals" aria-labelledby="dx-about-story-title">
    <svg class="dx-about-sprig" viewBox="0 0 260 340" fill="none" aria-hidden="true">
      <path d="M220 329C167 272 137 207 124 139C116 95 118 52 124 13" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
      <path d="M127 151C80 136 47 106 32 66C76 65 112 89 127 151Z" fill="currentColor" fill-opacity=".25" stroke="currentColor" stroke-width="2"/>
      <path d="M146 209C192 188 219 153 226 111C183 119 154 151 146 209Z" fill="currentColor" fill-opacity=".2" stroke="currentColor" stroke-width="2"/>
      <path d="M166 261C121 251 90 226 72 190C116 184 151 210 166 261Z" fill="currentColor" fill-opacity=".22" stroke="currentColor" stroke-width="2"/>
    </svg>

    <div class="container container-xl">
      <header class="dx-about-section-head">
        <div>
          <span class="dx-eyebrow">Everybody. Everyday. Everywhere.</span>
          <h2 id="dx-about-story-title">A lighter way to move through <strong>every day.</strong></h2>
        </div>
        <p>We consider the needs of women of all ages, combining innovation, creative design and a distinctly Indian point of view.</p>
      </header>

      <div class="dx-about-story-grid">
        <article class="dx-about-story-copy">
          <span class="dx-about-index">01 &mdash; Our story</span>
          <h3>Quality, comfort and style belong together.</h3>
          <p>DEXTE is an Indian brand focused on period care that feels light-hearted, feminine and easy to live in. We make comfort and confidence central to every product.</p>
          <p>Our aim is simple: thoughtfully designed protection at an accessible price, made to support women throughout their day.</p>
          <strong>Live it. Live fearless.</strong>
        </article>

        <figure class="dx-about-story-image">
          <img src="<?php echo base_url('assets/front/') ?>images/ourimg/videoimg1.jpg" alt="A woman holding DEXTE period underwear packaging">
          <figcaption>Confidence, made wearable.</figcaption>
        </figure>

        <aside class="dx-about-story-note">
          <span>Our point of view</span>
          <p>Period care should feel considered, comfortable and completely normal.</p>
        </aside>
      </div>
    </div>
  </section>

  <section class="dx-about-values" aria-labelledby="dx-about-values-title">
    <div class="container container-xl">
      <header class="dx-about-values-head">
        <span class="dx-eyebrow dx-eyebrow-center">What matters to us</span>
        <h2 id="dx-about-values-title">Care in <strong>every detail.</strong></h2>
      </header>

      <div class="dx-about-values-grid">
        <article class="dx-about-value dx-about-value-comfort">
          <span class="dx-about-value-number">01</span>
          <span class="dx-about-value-icon"><img src="<?php echo base_url('assets/front/') ?>images/qu1.avif" alt=""></span>
          <div>
            <span class="dx-about-value-kicker">All-day softness</span>
            <h3>Comfortable</h3>
            <p>Feel as beautiful and cosy as you do in your favourite underwear.</p>
          </div>
        </article>

        <article class="dx-about-value dx-about-value-sustainable">
          <span class="dx-about-value-number">02</span>
          <span class="dx-about-value-icon"><img src="<?php echo base_url('assets/front/') ?>images/qu2.avif" alt=""></span>
          <div>
            <span class="dx-about-value-kicker">Wear. Wash. Repeat.</span>
            <h3>Sustainable</h3>
            <p>Reusable protection helps reduce everyday disposable waste.</p>
          </div>
        </article>

        <article class="dx-about-value dx-about-value-leakproof">
          <span class="dx-about-value-number">03</span>
          <span class="dx-about-value-icon"><img src="<?php echo base_url('assets/front/') ?>images/qu3.avif" alt=""></span>
          <div>
            <span class="dx-about-value-kicker">Move with confidence</span>
            <h3>Leak-Proof</h3>
            <p>Reliable protection designed to keep leaks and worries away.</p>
          </div>
        </article>

        <article class="dx-about-value dx-about-value-eco">
          <span class="dx-about-value-number">04</span>
          <span class="dx-about-value-icon"><img src="<?php echo base_url('assets/front/') ?>images/ourimg/eco.png" alt=""></span>
          <div>
            <span class="dx-about-value-kicker">A gentler choice</span>
            <h3>Eco Friendly</h3>
            <p>Protection made to reduce the everyday impact of period care.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="dx-about-manifesto">
    <div class="container container-xl">
      <span class="dx-about-manifesto-label">Our promise</span>
      <blockquote>&ldquo;We are committed to changing the narrative around menstrual health and bladder leaks by creating a solutions-oriented future that moves beyond taboos.&rdquo;</blockquote>
      <p>We are proud of the progress we have made &mdash; and we know this is only the beginning.</p>
    </div>
    <svg class="dx-about-manifesto-flower" viewBox="0 0 220 220" aria-hidden="true">
      <g fill="none" stroke="currentColor" stroke-width="2">
        <ellipse cx="110" cy="52" rx="25" ry="48"/>
        <ellipse cx="168" cy="104" rx="25" ry="48" transform="rotate(72 168 104)"/>
        <ellipse cx="145" cy="169" rx="25" ry="48" transform="rotate(144 145 169)"/>
        <ellipse cx="75" cy="169" rx="25" ry="48" transform="rotate(216 75 169)"/>
        <ellipse cx="52" cy="104" rx="25" ry="48" transform="rotate(288 52 104)"/>
        <circle cx="110" cy="112" r="22"/>
      </g>
    </svg>
  </section>

  <section class="dx-about-voices" aria-labelledby="dx-about-voices-title">
    <div class="container container-xl">
      <header class="dx-about-section-head dx-about-voices-head">
        <div>
          <span class="dx-eyebrow">Loved by you</span>
          <h2 id="dx-about-voices-title">Real words from <strong>real women.</strong></h2>
        </div>
        <p>Everyday experiences from customers who chose comfort and confidence.</p>
      </header>

      <div class="dx-about-voices-grid">
        <article class="dx-about-voice">
          <span class="dx-about-stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p>&ldquo;No need to worry about leaks or odor.&rdquo;</p>
          <footer><strong>Varsha</strong><span class="dx-about-verified" aria-label="Verified customer">&#10003;</span></footer>
        </article>
        <article class="dx-about-voice dx-about-voice-featured">
          <span class="dx-about-stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p>&ldquo;A more comfortable and convenient product during your period days.&rdquo;</p>
          <footer><strong>Ritika</strong><span class="dx-about-verified" aria-label="Verified customer">&#10003;</span></footer>
        </article>
        <article class="dx-about-voice">
          <span class="dx-about-stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <p>&ldquo;These are comfortable, absorbent, and leak-proof.&rdquo;</p>
          <footer><strong>Anjali</strong><span class="dx-about-verified" aria-label="Verified customer">&#10003;</span></footer>
        </article>
      </div>
    </div>
  </section>

  <section class="dx-about-cta">
    <span class="dx-about-cta-art" aria-hidden="true"></span>
    <div class="container container-xl">
      <div>
        <span class="dx-eyebrow">Find your fit</span>
        <h2>Ready to make your <strong>own rules?</strong></h2>
      </div>
      <a class="dx-about-button" href="<?php echo base_url('shop'); ?>">Shop DEXTE <span aria-hidden="true">&rarr;</span></a>
    </div>
  </section>
</main>
