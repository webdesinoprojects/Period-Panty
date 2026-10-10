<!doctype html>
<?php $link = $this->setting_model->get_all_setting();?>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php  echo $RESULT[0]->meta_title ; ?></title>
    <meta name="description" content="<?php  echo $RESULT[0]->meta_description ; ?>">
    <meta name="keywords" content="<?php  echo $RESULT[0]->meta_keyword; ?>">
    <link rel="canonical" href="<?php  echo $RESULT[0]->canonical; ?>">
    <meta property="og:url" content="https://www.dexteshop.com/" />

    <meta property="og:type" content="website" />
    
    <meta property="og:title" content="Period Panties in India: Comfortable & Reliable | DEXTE" />
    
    <meta property="og:description" content="Are you searching for reliable and comfortable period panties in India? Look no further! DEXTE brings you a comprehensive range of period panties designed to provide unparalleled comfort and protection during your menstrual cycle. Call Now +91-9311268555" />
    <?php $this->load->view('front/layout/head'); ?>
</head>

<body>
     <?php $this->load->view('front/layout/header'); ?>
<?php
// Upper slider rows remain fully managed through CMS > Sliders.
$this->slider_model->initialize_hero_fields();
$slider = $this->slider_model->get_all_active_slider();
$dx_slides = array();
foreach ($slider as $dx_s) {
    if ($dx_s->type === "Upper") { $dx_slides[] = $dx_s; }
}
$this->load->view("front/includes/lifestyle_hero", array(
    "hero_slides" => $dx_slides,
    "hero_logo" => !empty($link[0]->logo) ? $link[0]->logo : ""
));
?>
        <?php
        /* "Made for different needs" row.
           Each card is a Footer-type row in tbl_slider, so CMS > Sliders owns
           them - image, label, the small line under it (Description) and the
           link - with no schema change. Footer was the one unused value in the
           type enum. Status Inactive drops a card from the row. */
        $dx_made = array();
        foreach ($slider as $dx_m) { if ($dx_m->type === 'Footer') { $dx_made[] = $dx_m; } }
        ?>
        <?php if ($dx_made) { ?>
        <section id="dx-next" class="dx-made">
          <div class="container container-xl">
            <h2 class="dx-made-head">Made for different needs.<br><strong>Dexte has all solutions.</strong></h2>
            <div class="dx-made-row">
              <?php foreach ($dx_made as $dx_m) { ?>
              <a class="dx-made-item" href="<?php echo base_url($dx_m->button_link ? $dx_m->button_link : 'shop'); ?>">
                <span class="dx-made-img" style="background-image:url('<?php echo base_url('uploads/slider/' . $dx_m->image); ?>')"></span>
                <span class="dx-made-label"><?php echo $dx_m->title; ?></span>
                <?php if ($dx_m->description) { ?>
                <span class="dx-made-sub"><?php echo $dx_m->description; ?></span>
                <?php } ?>
              </a>
              <?php } ?>
            </div>
          </div>
        </section>
        <?php } ?>
  
<?php
/* Category bento.
   One grid holding the two Middle-slider banners AND the shop categories,
   interleaved - the banners are the two large anchor tiles with categories
   woven around them, rather than appended as their own row.

   Categories come from the ones flagged Home Display, banners from the
   Middle-type sliders, so CMS > Category and CMS > Sliders already control
   the whole grid. No new table, no new admin fields.

   Tile sizes are assigned by position, so the order built here is the layout. */
$dx_cats    = $this->category_model->get_home_category_by_parent(0);
$dx_banners = array();
foreach ($slider as $dx_mb) { if ($dx_mb->type === 'Middle') { $dx_banners[] = $dx_mb; } }

/* Six tiles on a 4-column grid:
     row 1  [ banner 1 (2 wide) ][ cat ][ cat ]
     row 2  [ banner 2 (2 wide) ][ cat ][ cat ]
   The banner artwork is 1080x793 (1.36:1) and the tile is wider than that, so
   it is cropped. The crop is anchored to the top in CSS, because the headings
   sit at the top of the artwork and losing those is what looked broken. */
$dx_pick  = array_slice($dx_cats, 0, 4);
$dx_tiles = array();
if (isset($dx_banners[0])) { $dx_tiles[] = array('kind' => 'banner', 'row' => $dx_banners[0]); }
if (isset($dx_pick[0]))    { $dx_tiles[] = array('kind' => 'cat',    'row' => $dx_pick[0]); }
if (isset($dx_pick[1]))    { $dx_tiles[] = array('kind' => 'cat',    'row' => $dx_pick[1]); }
if (isset($dx_banners[1])) { $dx_tiles[] = array('kind' => 'banner', 'row' => $dx_banners[1]); }
if (isset($dx_pick[2]))    { $dx_tiles[] = array('kind' => 'cat',    'row' => $dx_pick[2]); }
if (isset($dx_pick[3]))    { $dx_tiles[] = array('kind' => 'cat',    'row' => $dx_pick[3]); }
?>
        <?php if ($dx_tiles) { ?>
        <section class="dx-bento">
          <div class="container container-xl">

            <div class="dx-bento-head">
              <!-- Botanicals flanking the heading. Decorative only, so they are
                   empty spans with the artwork as a background and hidden from
                   assistive tech. -->
              <span class="dx-bot dx-bot-left" aria-hidden="true"></span>
              <span class="dx-bot dx-bot-right" aria-hidden="true"></span>
              <span class="dx-bento-eyebrow">Shop by style</span>
              <h2 class="dx-bento-title">Find <strong>your fit</strong></h2>
            </div>

            <div class="dx-bento-grid">
              <?php foreach ($dx_tiles as $dx_t) { $dx_r = $dx_t['row']; ?>

                <?php if ($dx_t['kind'] === 'banner') { ?>
                <a class="dx-bento-card dx-bento-banner"
                   href="<?php echo html_escape(base_url($dx_r->button_link ? $dx_r->button_link : "shop")); ?>">
                  <span class="dx-bento-banner-img"
                        style="background-image:url('<?php echo base_url('uploads/slider/' . $dx_r->image); ?>')"></span>
                  <?php if (!empty($dx_r->title)) { ?>
                  <span class="dx-bento-banner-copy">
                    <span class="dx-bento-banner-title"><?php echo nl2br(html_escape(str_replace("|", "\n", $dx_r->title))); ?></span>
                    <?php if (!empty($dx_r->description)) { ?>
                    <span class="dx-bento-banner-sub"><?php echo html_escape($dx_r->description); ?></span>
                    <?php } ?>
                    <span class="dx-bento-banner-link"><?php echo html_escape(!empty($dx_r->button_title) ? $dx_r->button_title : "Explore"); ?> <span aria-hidden="true">→</span></span>
                  </span>
                  <?php } ?>
                </a>

                <?php } else { ?>
                <a class="dx-bento-card" href="<?php echo base_url($dx_r->url_slug . '.html'); ?>">

                  <?php if ($dx_r->image) { ?>
                  <span class="dx-bento-art" style="background-image:url('<?php echo base_url('uploads/category/' . $dx_r->image); ?>')"></span>
                  <?php } ?>

                  <!-- Brand botanical motif; the stroke draws itself in on hover. -->
                  <svg class="dx-bento-sprig" viewBox="0 0 64 64" fill="none"
                       stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                    <path class="dx-sprig-stem" d="M32 60V16"/>
                    <path class="dx-sprig-leaf" d="M32 32c0-8.5 6.4-15 15-15 0 8.5-6.4 15-15 15Z"/>
                    <path class="dx-sprig-leaf" d="M32 47c0-8.5-6.4-15-15-15 0 8.5 6.4 15 15 15Z"/>
                  </svg>

                  <span class="dx-bento-text">
                    <span class="dx-bento-name"><?php echo $dx_r->title; ?></span>
                    <?php if (trim($dx_r->description)) { ?>
                    <span class="dx-bento-desc"><?php echo $dx_r->description; ?></span>
                    <?php } ?>
                  </span>

                  <span class="dx-bento-go" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                         stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h13M12 5l7 7-7 7"/>
                    </svg>
                  </span>

                </a>
                <?php } ?>

              <?php } ?>
            </div>

          </div>
        </section>
        <?php } ?>
        <section class=" pt-8 dx-has-art dx-art-waves dx-bestsellers">
          <div class="container container-xl">
            <div class="row mb-md-6 mb-8">
              <div class="col-md-6">
                <span class="dx-eyebrow">Our bestsellers</span>
                <h2 class="fs-34" data-animate="fadeInUp">Shop Our <strong>Best Sellers</strong></h2>
              </div>
              <div class="col-md-6 text-md-right">
                <a href="<?php echo base_url('shop') ?>" class="btn btn-link p-0 mt-2">Shop All Products<i class="far fa-arrow-right pl-2 fs-13"></i></a>
              </div>
            </div>
            <div class="slick-slider mx-n2" data-slick-options='{"slidesToShow": 5,"dots":false,"arrows":true,"responsive":[{"breakpoint": 1368,"settings": {"arrows":false,"dots":true}},{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false,"dots":true}},{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false,"dots":true}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"arrows":false,"dots":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true}}]}'>
        
                <?php foreach($PRODUCTS as $key=>$value){ ?>
                <?php $data['product'] = $value; ?>
                    <div  class="box">
                         <?php $this->load->view('front/product/listing-view' , $data); ?>
                    </div> 
                 <?php } ?>
            
            </div>
          </div>
        </section>
        <?php
        /* "Stress Free" editorial block.
           Replaces a flat 1920x725 JPEG (ourimg/newbg1.jpg) whose copy was
           baked into the pixels and so could never be edited, translated or
           read by a screen reader. The model is cut out of that same artwork.

           Newspaper typography - serif masthead, hairline rules, small caps -
           on a bento, because the brand only has short benefit fragments to
           work with and a true column layout with five fragments would read
           as an empty broadsheet. All copy below is from DEXTE's own
           packaging. */
        ?>
        <section class="dx-sf">
          <div class="container container-xl">

            <div class="dx-sf-masthead">
              <span class="dx-sf-rule" aria-hidden="true"></span>
              <span class="dx-sf-kicker">The Stress Free Range</span>
              <span class="dx-sf-rule" aria-hidden="true"></span>
            </div>

            <h2 class="dx-sf-title">Pad&#8209;free,<br><em>stress&#8209;free</em> periods.</h2>

            <span class="dx-sf-lily" aria-hidden="true"></span>
            <span class="dx-sf-leaf" aria-hidden="true"></span>

            <div class="dx-sf-grid">

              <div class="dx-sf-figure">
                <span class="dx-sf-badge">Max Absorb</span>
                <img class="dx-sf-product-photo" src="<?php echo base_url("assets/front/media/dx-facefree-stressfree-v1.jpg"); ?>" alt="Red period briefs on soft cream linen" loading="lazy">
                <span class="dx-sf-bot" aria-hidden="true"></span>
                <span class="dx-sf-frame" aria-hidden="true"></span>
                <a class="dx-sf-shop" href="<?php echo base_url('shop'); ?>">
                  Shop the range
                  <span class="dx-sf-arrow" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12 5l7 7-7 7"/></svg>
                  </span>
                </a>
              </div>

              <a class="dx-sf-card dx-sf-card-wide" href="<?php echo base_url('shop'); ?>">
                <span class="dx-sf-num">01</span>
                <span class="dx-sf-ct">Four&#8209;layer protection</span>
                <span class="dx-sf-cd">A leak&#8209;proof core that holds up through the heaviest day, with nothing to shift or show.</span>
              </a>

              <div class="dx-sf-card">
                <span class="dx-sf-num">02</span>
                <span class="dx-sf-ct">Reusable &amp; long lasting</span>
                <span class="dx-sf-cd">Wear, wash, repeat &mdash; better for you and better for the environment.</span>
              </div>

              <div class="dx-sf-card">
                <span class="dx-sf-num">03</span>
                <span class="dx-sf-ct">Kind to skin</span>
                <span class="dx-sf-cd">No rashes. Maintains pH balance. Soft and breathable, every single day.</span>
              </div>

            </div>
          </div>
        </section>
        <section class="py-8 dx-band dx-style dx-has-art dx-art-drops">
            <div class="container container-xl">
                <div class="row">
                    <div class="col-12 text-center mb-7">
                        <span class="dx-eyebrow">Loved by you</span>
                        <h2 class="fs-34" data-animate="fadeInUp">Most <strong>Loved</strong></h2>
                    </div>
                    <!-- Bamboo frame around the style grid. A col-12 holding its
                         own row, so the Bootstrap row > col structure stays intact. -->
                    <div class="col-12">
                      <div class="dx-style-frame">
                        <div class="row">
                    <div class="col-12 col-lg-6">
                        <?php $first  =  $this->category_model->get_category_by_id(4) ;   ?>
                        <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                        <img src="<?php echo base_url("assets/front/media/dx-facefree-shorts-v1.jpg"); ?>" alt="<?php echo html_escape($first[0]->title); ?>" class="card-img dx-style-product-photo" loading="lazy">
                            <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                <div>
                                  <a href="<?php echo base_url().$first[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $first[0]->title; ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <?php $Second =  $this->category_model->get_category_by_id(1) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(2) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(3) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php $Second =  $this->category_model->get_category_by_id(5) ;   ?>
                            <div class="col-md-6 mt-6 mb-5 mt-lg-0">
                                <div class="card border-0 text-center hover-shine hover-zoom-in" data-animate="fadeInUp">
                                    <img src="<?php echo base_url('uploads/category/').$Second[0]->image; ?>" alt="<?php echo $Second[0]->title; ?>" class="card-img">
                                    <div class="card-img-overlay d-inline-flex flex-column p-5 justify-content-end">
                                        <div>
                                        <a href="<?php echo base_url().$Second[0]->url_slug.'.html' ;?>" class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1"><?php echo $Second[0]->title; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                 
                        </div>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include('flows_marquee.php'); ?>

        <section class="dx-benefits" aria-labelledby="dx-benefits-title">
          <div class="dx-benefits-flora" aria-hidden="true">
            <!-- Artwork supplied in the user's ZIPs. These blue blossoms and
                 cream flower frame are exclusive to this section. -->
            <span class="dx-benefit-art dx-benefit-art-blue"></span>
            <span class="dx-benefit-art dx-benefit-art-frame"></span>
          </div>

          <div class="container container-xl">
            <header class="dx-benefits-head">
              <div>
                <span class="dx-eyebrow">Care in every detail</span>
                <h2 id="dx-benefits-title">Designed around <strong>real life</strong></h2>
              </div>
              <p>Soft on your body, strong on protection and thoughtfully made for a lighter footprint.</p>
            </header>

            <div class="dx-benefits-grid">
              <article class="dx-benefit-card dx-benefit-comfort">
                <span class="dx-benefit-num">01</span>
                <div class="dx-benefit-icon">
                  <img src="<?php echo base_url('assets/front/') ?>images/qu1.avif" alt="" aria-hidden="true">
                </div>
                <div class="dx-benefit-copy">
                  <span class="dx-benefit-kicker">All-day softness</span>
                  <h3>Comfortable</h3>
                  <p>Feel just as beautiful and cozy as you do in your favorite underwear.</p>
                </div>
                <div class="dx-benefit-chips" aria-label="Comfort features">
                  <span>Skin-kind</span><span>Flexible fit</span>
                </div>
              </article>

              <article class="dx-benefit-card dx-benefit-sustainable">
                <span class="dx-benefit-num">02</span>
                <div class="dx-benefit-icon">
                  <img src="<?php echo base_url('assets/front/') ?>images/qu2.avif" alt="" aria-hidden="true">
                </div>
                <div class="dx-benefit-copy">
                  <span class="dx-benefit-kicker">Wear. Wash. Repeat.</span>
                  <h3>Sustainable</h3>
                  <p>Reusable protection that helps you avoid piles of single-use period waste.</p>
                </div>
              </article>

              <article class="dx-benefit-card dx-benefit-leakproof">
                <span class="dx-benefit-num">03</span>
                <div class="dx-benefit-icon">
                  <img src="<?php echo base_url('assets/front/') ?>images/qu3.avif" alt="" aria-hidden="true">
                </div>
                <div class="dx-benefit-copy">
                  <span class="dx-benefit-kicker">Move with confidence</span>
                  <h3>Leak-Proof</h3>
                  <p>Reliable layered protection designed to keep leaks and worries away.</p>
                </div>
              </article>

              <article class="dx-benefit-card dx-benefit-eco">
                <span class="dx-benefit-num">04</span>
                <div class="dx-benefit-icon">
                  <img src="<?php echo base_url('assets/front/') ?>images/ourimg/eco.png" alt="" aria-hidden="true">
                </div>
                <div class="dx-benefit-copy">
                  <span class="dx-benefit-kicker">A gentler choice</span>
                  <h3>Eco Friendly</h3>
                  <p>Made to protect your flow while reducing everyday impact on the earth.</p>
                </div>
              </article>
            </div>
          </div>
        </section>
        <?php
        $dx_absorbency_cards = array(
          array("slug" => "light", "number" => "01", "name" => "Light", "range" => "10&ndash;20", "filled" => 2,
                "use" => "Light period days, backup protection, spotting or everyday discharge."),
          array("slug" => "moderate", "number" => "02", "name" => "Moderate", "range" => "20&ndash;30", "filled" => 3,
                "use" => "Light to moderate period days, or dependable backup on moderate days."),
          array("slug" => "heavy", "number" => "03", "name" => "Heavy", "range" => "30&ndash;40", "filled" => 4,
                "use" => "Moderate period days, longer wear, or reliable backup on heavy days."),
          array("slug" => "super", "number" => "04", "name" => "Super", "range" => "40&ndash;50", "filled" => 5,
                "use" => "Extra-heavy days or whenever you want the highest absorbency protection.")
        );
        ?>
        <section class="dx-absorbency" aria-labelledby="dx-absorbency-title">
          <div class="dx-absorbency-flora" aria-hidden="true">
            <!-- The pink lily arrangement is exclusive to this section so the
                 background artwork never repeats across adjacent blocks. -->
            <span class="dx-absorb-art dx-absorb-art-lily"></span>
          </div>

          <div class="container container-xl">
            <header class="dx-absorbency-head">
              <div>
                <span class="dx-eyebrow">What&rsquo;s your flow?</span>
                <h2 id="dx-absorbency-title">Find your <strong>perfect protection</strong></h2>
              </div>
              <p>From lighter days to maximum coverage, compare each absorbency level at a glance.</p>
            </header>

            <div class="dx-absorbency-grid">
              <?php foreach ($dx_absorbency_cards as $dx_absorbency) { ?>
                <article class="dx-abs-card dx-abs-<?php echo $dx_absorbency["slug"]; ?>">
                  <span class="dx-abs-step"><?php echo $dx_absorbency["number"]; ?></span>
                  <svg class="dx-abs-watermark" viewBox="0 0 120 150" aria-hidden="true">
                    <path d="M60 6C60 6 15 62 15 91C15 119 35 140 60 140C85 140 105 119 105 91C105 62 60 6 60 6Z"></path>
                  </svg>

                  <div class="dx-abs-title">
                    <span>Flow level</span>
                    <h3><?php echo $dx_absorbency["name"]; ?></h3>
                  </div>
                  <div class="dx-abs-capacity">
                    <strong><?php echo $dx_absorbency["range"]; ?></strong>
                    <span>ml<br>regular</span>
                  </div>
                  <div class="dx-abs-use">
                    <span>Best for</span>
                    <p><?php echo $dx_absorbency["use"]; ?></p>
                  </div>

                  <div class="dx-abs-card-foot">
                    <div class="dx-abs-meter" aria-label="<?php echo $dx_absorbency["filled"]; ?> out of 5 absorbency drops">
                      <?php for ($dx_drop = 1; $dx_drop <= 5; $dx_drop++) { ?>
                        <i class="<?php echo $dx_drop <= $dx_absorbency["filled"] ? "is-filled" : ""; ?>"></i>
                      <?php } ?>
                    </div>
                    <a href="<?php echo base_url("shop"); ?>">Shop <?php echo $dx_absorbency["name"]; ?><span aria-hidden="true">&rarr;</span></a>
                  </div>
                </article>
              <?php } ?>
            </div>
          </div>
        </section>

        <?php if (false) { /* Retained temporarily for content reference; not rendered. */ ?>
        <section class="pt-lg-11 pb-lg-10 py-5 dx-has-art dx-art-waves" style="background:#deb08e;">
          <div class="container container-xl">
            <div class="row justify-content-center mb-7">
              <div class="col-12 text-center">
                <span class="dx-eyebrow dx-eyebrow-center">What&rsquo;s your flow?</span>
                <h2 class="fs-34 text-center fadeInUp animated" data-animate="fadeInUp">
                  Find The Right <strong>Absorbency Power</strong>
                </h2>
              </div>
            </div>
            <div class="row">
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Light
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      10 to 20 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on light period days, as backup to other products, or for sneaky leaks & discharge.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Light
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Moderate
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      20 to 30 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on your light or moderate period days, or as backup on your moderate days.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Moderate
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Heavy
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="far fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      30 to 40ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      Alone on your moderate period days, or as backup on your heavy days.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Heavy
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-2 col-md-6 col-xl-3" data-animate="fadeInUp">
                <div class="card border-0 banner banner-02
                        hover-zoom-in hover-shine">
                  <div class="card-img bg-img-cover-center" style="background:#fff;"></div>
                  <div class="card-img-overlay d-inline-flex flex-column px-3 py-6 align-items-left ">
                    <h3 class="card-title fs-30 font-weight-500  text-dark mb-2 lh-116">
                      Super
                    </h3>
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Absorbency Power :
                      </span>
                    </p>
                    <div class="d-flex align-items-center justify-content-start mb-3 flex-wrap">
                      <ul class="list-inline mb-0 lh-1">
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                        <li class="list-inline-item fs-17 spancolor mr-0">
                          <i class="fas fa-tint"></i>
                        </li>
                      </ul>
                    </div>
                    <p class="fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        Equivalent to :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-2 font-weight-500">
                      40 to 50 ml regular
        
                    </p>
        
                    <p class="text-gray-03 fs-18 mb-1 font-weight-600">
                      <span class="spancolor">
                        When to use :
                      </span>
                    </p>
                    <p class="text-dark fs-16 mb-4 font-weight-500">
                      For those extra heavy days—or just whenever you need all the absorbency power you can get.
                    </p>
                    <div class="text-center">
                      <a href="#" class="btn btn-secondary bg-hover-primary border-hover-primary">
                        Shop Super
                      </a>
                    </div>
                  </div>
                </div>
              </div>
        
            </div>
          </div>
        </section>
        <?php } ?>
        <section class="pt-10 pb-6 dx-has-art dx-art-waves dx-membrane-section">
          <div class="container-fluid">
            <div class="row mb-md-6 mb-8">
              <div class="col-12">
                <span class="dx-eyebrow dx-eyebrow-center">How it works</span>
                <h2 class="fs-34 text-center" data-animate="fadeInUp">Period Underwear With <strong>Magic Membrane System</strong></h2>
              </div>
            </div>
            <img src="<?php echo base_url('assets/front/') ?>images/processdigram.webp">
          </div>
        </section>
        <section class="dx-life-section dx-has-art dx-art-waves" data-animated-id="10">
          <div class="container container-xl">
            <svg class="dx-life-nature" viewBox="0 0 260 320" fill="none" aria-hidden="true">
              <path d="M225 304C171 247 139 190 123 127C113 87 113 48 118 13" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
              <path d="M126 144C78 128 47 99 34 61C78 62 111 84 126 144Z" fill="currentColor" fill-opacity=".34" stroke="currentColor" stroke-width="2"/>
              <path d="M145 195C189 176 216 145 226 105C185 110 155 140 145 195Z" fill="currentColor" fill-opacity=".24" stroke="currentColor" stroke-width="2"/>
              <path d="M165 240C121 231 90 209 72 175C113 169 148 192 165 240Z" fill="currentColor" fill-opacity=".28" stroke="currentColor" stroke-width="2"/>
              <path d="M119 91C153 76 174 51 181 20C150 24 127 48 119 91Z" fill="currentColor" fill-opacity=".2" stroke="currentColor" stroke-width="2"/>
              <circle cx="120" cy="126" r="5" fill="currentColor"/>
              <circle cx="145" cy="195" r="4" fill="currentColor"/>
              <circle cx="164" cy="240" r="4" fill="currentColor"/>
            </svg>

            <header class="dx-life-head">
              <span class="dx-eyebrow dx-eyebrow-center">Why it works</span>
              <h2>How Period Panties <strong>Will Change Your Life</strong></h2>
            </header>

            <div class="dx-life-stage">
              <article class="dx-life-card dx-life-card-1">
                <span class="dx-life-number">01</span>
                <p>They're <strong>Reusable</strong></p>
              </article>

              <article class="dx-life-card dx-life-card-2">
                <span class="dx-life-number">02</span>
                <p>360<sup>o</sup> Anti-leak <strong>Protection</strong></p>
              </article>

              <article class="dx-life-card dx-life-card-3">
                <span class="dx-life-number">03</span>
                <p>Made With Ultra-soft &amp; Breathable <strong>Material</strong></p>
              </article>

              <div class="dx-life-video" style="background-image: url('<?php echo base_url('assets/front/') ?>images/ourimg/videoimg.jpg');">
                <a href="https://www.youtube.com/watch?v=F8S3SnAEE_0" data-gtf-mfp="true" data-mfp-options='{"type":"iframe","preloader":false}' class="dx-life-play" aria-label="Play the DEXTE period underwear video">
                  <i class="fas fa-play" aria-hidden="true"></i>
                </a>
                <span class="dx-life-video-label">See how DEXTE works</span>
              </div>

              <article class="dx-life-card dx-life-card-4">
                <span class="dx-life-number">04</span>
                <p>Holds Up To 40ml <strong>Of Blood</strong></p>
              </article>

              <article class="dx-life-card dx-life-card-5">
                <span class="dx-life-number">05</span>
                <p>On Heavy Flow Change <strong>In 4-6 Hours</strong></p>
              </article>

              <article class="dx-life-card dx-life-card-6">
                <span class="dx-life-number">06</span>
                <p>Kind To You <strong>And The Planet</strong></p>
              </article>
            </div>
          </div>
        </section>
        <?php $this->load->view('front/dx_reviews'); ?>
        <div class="rg">
        <marquee width="100%" direction="left">
For every Sustain purchase, 1% of the purchase goes towards the animal and plantation fund, which helps to support the planet. Products like period underwear are designed to minimize waste, reducing the amount of used tampons and pads that end up in landfills.
</marquee>
</div>
        <?php $this->load->view("front/home_faqs", array("FAQS" => $FAQS)); ?>

       
  <?php $this->load->view('front/layout/footer'); ?>
  <?php $this->load->view('front/layout/footer-js'); ?>
        </body>
</html>
