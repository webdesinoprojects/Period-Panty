<?php if (!empty($FAQS)) { ?>
<section class="faqs py-8 dx-has-art dx-art-drops">
  <div class="container">
    <span class="dx-eyebrow dx-eyebrow-center">Good to know</span>
    <h2 class="fs-34 pb-8 text-center">Frequently Asked <strong>Questions</strong></h2>
    <div class="row">
      <div class="col-12 mt-7 mt-md-0">
        <div id="accordion-style-01" class="accordion">
          <?php foreach ($FAQS as $index => $faq) { $id = "home-faq-" . (int) $faq->id; ?>
          <div class="card border-1 mb-4 border-bottom-1">
            <div class="card-header border-0" id="<?php echo $id; ?>-heading">
              <h5 class="mb-0 fs-18 w-100">
                <a href="#<?php echo $id; ?>" class="d-flex align-items-center border-bottom pb-2 text-decoration-none<?php echo $index ? " collapsed" : ""; ?>" data-toggle="collapse" data-target="#<?php echo $id; ?>" aria-expanded="<?php echo $index ? "false" : "true"; ?>" aria-controls="<?php echo $id; ?>">
                  <span><?php echo html_escape($faq->title); ?></span>
                  <span class="icon d-inline-block ml-auto"></span>
                </a>
              </h5>
            </div>
            <div id="<?php echo $id; ?>" class="collapse<?php echo $index ? "" : " show"; ?>" aria-labelledby="<?php echo $id; ?>-heading" data-parent="#accordion-style-01">
              <div class="card-body pt-4 pb-2 px-2"><?php
                $answer = $this->security->xss_clean(strip_tags($faq->description, "<p><br><b><strong><em><i><ul><ol><li>"));
                echo preg_match("~<(?:p|br|ul|ol|li)(?:\\s|>)~i", $answer) ? $answer : nl2br($answer);
              ?></div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
