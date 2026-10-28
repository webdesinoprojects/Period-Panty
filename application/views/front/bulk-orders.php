<?php
$settings = $this->setting_model->get_all_setting()[0];
$value = function ($field) use ($values) { return html_escape(isset($values[$field]) && is_string($values[$field]) ? $values[$field] : ''); };
$selected_sizes = isset($values['sizes']) ? $values['sizes'] : array();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulk Orders &amp; Wholesale Enquiries | DEXTE</title>
    <meta name="description" content="Request a personalised quote for DEXTE cotton, bamboo and seamless period panties. Share your quantity, sizes, colours and delivery needs.">
    <link rel="canonical" href="<?php echo base_url('bulk-orders'); ?>">
    <?php $this->load->view('front/layout/head'); ?>
</head>
<body class="dx-bulk-page">
<?php $this->load->view('front/layout/header'); ?>
<main class="dx-bulk">
    <section class="dx-bulk-hero container container-xl">
        <div class="dx-bulk-hero-copy">
            <span class="dx-eyebrow">Good things, shared</span>
            <h1>More comfort.<br><em>More possibilities.</em></h1>
            <p>For your store, your team or your community. Tell us what you have in mind, and we will help put together your DEXTE bulk order.</p>
            <a class="dx-bulk-hero-cta" href="#bulk-form">Build your enquiry <span aria-hidden="true">&darr;</span></a>
            <div class="dx-bulk-pills"><span>Retail &amp; distribution</span><span>Organisations &amp; communities</span><span>Events &amp; gifting</span></div>
        </div>
        <figure class="dx-bulk-hero-photo"><img src="<?php echo base_url('assets/front/media/dx-combo-pack-v2.jpg'); ?>" alt="DEXTE pack of two period panties, in maroon and black" width="1254" height="1254"><figcaption>Thoughtfully made. Ready to share.</figcaption></figure>
    </section>

    <section class="dx-bulk-body container container-xl">
        <aside class="dx-bulk-aside">
            <span class="dx-contact-kicker">A little guidance</span>
            <h2>Your order,<br><em>your way.</em></h2>
            <ol class="dx-bulk-steps"><li><span>01</span><div><h3>Make it yours</h3><p>Choose a category, your quantity, sizes and preferred colours.</p></div></li><li><span>02</span><div><h3>Let us work out the details</h3><p>Our team will confirm availability, pricing and delivery with you.</p></div></li><li><span>03</span><div><h3>Decide with confidence</h3><p>This is a quotation request. No payment or order is placed here.</p></div></li></ol>
            <div class="dx-bulk-talk"><h3>Prefer to talk?</h3><a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $settings->phone); ?>"><?php echo html_escape($settings->phone); ?></a><a href="mailto:<?php echo html_escape($settings->email); ?>"><?php echo html_escape($settings->email); ?></a><a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $settings->whatapp); ?>" target="_blank" rel="noopener noreferrer">Chat on WhatsApp &nearr;</a><p><?php echo html_escape($settings->address_content); ?></p></div>
        </aside>
        <article class="dx-bulk-form-card" id="bulk-form">
            <header><span class="dx-contact-kicker">Tell us what you need</span><h2>A thoughtful order<br>starts <em>here.</em></h2><p>Fields marked * are required. Unsure about a detail? Let us help.</p></header>
            <?php if ($notice) { ?><div class="dx-contact-feedback dx-contact-success" role="status"><strong>Your bulk enquiry is saved.</strong><p>Reference #<?php echo (int) $notice['id']; ?>. Our team will contact you to discuss your requirements.</p></div><?php } ?>
            <?php if ($errors) { ?><div class="dx-contact-feedback dx-contact-error" role="alert"><strong>Please check these details:</strong><ul><?php foreach ($errors as $error) { ?><li><?php echo html_escape($error); ?></li><?php } ?></ul></div><?php } ?>
            <form action="<?php echo base_url('bulk-orders#bulk-form'); ?>" method="post" id="bulk-order-form">
                <input type="hidden" name="bulk_token" value="<?php echo html_escape($bulk_token); ?>">
                <?php if ($this->config->item('csrf_protection')) { ?><input type="hidden" name="<?php echo html_escape($this->security->get_csrf_token_name()); ?>" value="<?php echo html_escape($this->security->get_csrf_hash()); ?>"><?php } ?>
                <div class="dx-contact-honeypot" aria-hidden="true"><label for="bulk-website">Leave empty</label><input id="bulk-website" name="website" value="" tabindex="-1" autocomplete="off"></div>
                <div class="dx-bulk-fields">
                    <?php foreach (array('name' => array('Your name *','text','name',200,TRUE), 'company' => array('Company / organisation','text','organization',200,FALSE), 'mobile' => array('Phone / WhatsApp number *','tel','tel',30,TRUE), 'email' => array('Email address (optional)','email','email',254,FALSE)) as $field => $spec) { ?>
                    <div class="dx-contact-field"><label for="bulk-<?php echo $field; ?>"><?php echo $spec[0]; ?></label><input id="bulk-<?php echo $field; ?>" name="<?php echo $field; ?>" type="<?php echo $spec[1]; ?>" autocomplete="<?php echo $spec[2]; ?>" maxlength="<?php echo $spec[3]; ?>" value="<?php echo $value($field); ?>" <?php echo $spec[4] ? 'required' : ''; ?> <?php echo isset($errors[$field]) ? 'aria-invalid="true"' : ''; ?>></div>
                    <?php } ?>
                    <div class="dx-contact-field"><label for="bulk-category">Product category *</label><select id="bulk-category" name="category" required><option value="">Choose a category</option><?php foreach (Bulk_order_model::CATEGORIES as $category) { ?><option value="<?php echo html_escape($category); ?>" <?php echo isset($values['category']) && $values['category'] === $category ? 'selected' : ''; ?>><?php echo html_escape($category); ?></option><?php } ?></select></div>
                    <div class="dx-contact-field"><label for="bulk-quantity">Total quantity (pieces) *</label><input id="bulk-quantity" name="quantity" type="number" min="1" max="1000000" step="1" value="<?php echo $value('quantity'); ?>" required></div>
                    <fieldset class="dx-bulk-sizes dx-bulk-wide"><legend>Sizes needed *</legend><div class="dx-bulk-size-options"><?php foreach (Bulk_order_model::SIZES as $size) { ?><label><input type="checkbox" name="sizes[]" value="<?php echo html_escape($size); ?>" <?php echo in_array($size, $selected_sizes, TRUE) ? 'checked' : ''; ?>><span><?php echo html_escape($size); ?></span></label><?php } ?></div><small>You can select several sizes. Include quantities per size in the notes below.</small></fieldset>
                    <div class="dx-contact-field dx-bulk-wide"><label for="bulk-colours">Preferred colours *</label><input id="bulk-colours" name="colours" maxlength="200" value="<?php echo $value('colours'); ?>" placeholder="For example: black, maroon, or Mixed" required><small>Colours and sizes are subject to availability; our team will confirm.</small></div>
                    <div class="dx-contact-field"><label for="bulk-city">Delivery city *</label><input id="bulk-city" name="city" autocomplete="address-level2" maxlength="120" value="<?php echo $value('city'); ?>" required></div>
                    <div class="dx-contact-field"><label for="bulk-postcode">PIN code (optional)</label><input id="bulk-postcode" name="postcode" autocomplete="postal-code" inputmode="numeric" pattern="[1-9][0-9]{5}" maxlength="6" value="<?php echo $value('postcode'); ?>"></div>
                    <div class="dx-contact-field dx-bulk-wide"><label for="bulk-address">Delivery address (optional)</label><textarea id="bulk-address" name="address" autocomplete="street-address" rows="2" maxlength="1000"><?php echo $value('address'); ?></textarea></div>
                    <div class="dx-contact-field dx-bulk-wide"><label for="bulk-date">Preferred delivery date (optional)</label><input id="bulk-date" name="needed_by" type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $value('needed_by'); ?>"><small>This is a preference, not a delivery commitment.</small></div>
                    <div class="dx-contact-field dx-bulk-wide"><label for="bulk-notes">Size / colour breakdown &amp; anything else</label><textarea id="bulk-notes" name="notes" maxlength="3000" rows="4" placeholder="For example: 50 black in M, 50 maroon in L. Tell us about packaging, an event or other requirements."><?php echo $value('notes'); ?></textarea></div>
                </div>
                <div class="dx-bulk-submit"><p>Our team will contact you about this enquiry. Please do not include card details or passwords.</p><button class="dx-contact-send" type="submit">Request a quote <span aria-hidden="true">&rarr;</span></button></div>
            </form>
        </article>
    </section>
</main>
<?php $this->load->view('front/layout/footer'); ?>
<?php $this->load->view('front/layout/footer-js'); ?>
<script src="<?php echo base_url('assets/front/js/bulk-order.js'); ?>" defer></script>
</body></html>
