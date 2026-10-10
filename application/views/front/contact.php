<?php
$link = $this->setting_model->get_all_setting();
$contact_settings = $link[0];
$contact_email = !empty($contact_settings->email) ? $contact_settings->email : "info@dexteshop.com";
$contact_phone = !empty($contact_settings->phone) ? $contact_settings->phone : "+91-9311268555";
$contact_tel = preg_replace("/[^0-9+]/", "", $contact_phone);
$contact_address = !empty($contact_settings->address_content) ? $contact_settings->address_content : "Nanda Enclave Gali No. 2, Sector 19, Nanda Enclave, Dwarka, Delhi, 110075.";
$contact_whatsapp = preg_replace("/[^0-9]/", "", !empty($contact_settings->whatapp) ? $contact_settings->whatapp : $contact_phone);
if (strlen($contact_whatsapp) === 10) { $contact_whatsapp = "91" . $contact_whatsapp; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo html_escape($RESULT[0]->meta_title); ?></title>
    <meta name="description" content="<?php echo html_escape($RESULT[0]->meta_description); ?>">
    <meta name="keywords" content="<?php echo html_escape($RESULT[0]->meta_keyword); ?>">
    <link rel="canonical" href="<?php echo html_escape($RESULT[0]->canonical); ?>">
    <?php $this->load->view("front/layout/head"); ?>
</head>
<body class="dx-contact-page">
<?php $this->load->view("front/layout/header"); ?>
<main class="dx-contact">
    <section class="dx-contact-hero" aria-labelledby="dx-contact-title">
        <div class="dx-contact-wrap dx-contact-hero-grid">
            <div class="dx-contact-intro">
                <span class="dx-eyebrow"><?php echo html_escape($RESULT[0]->title); ?></span>
                <h1 id="dx-contact-title">A little conversation.<br><em>A lot of care.</em></h1>
                <p>Questions about your fit, your flow or your order? We’re here to help you feel comfortable with every choice.</p>
                <a class="dx-contact-text-link" href="#contact-form">Let’s talk <span aria-hidden="true">&rarr;</span></a>
            </div>
            <div class="dx-contact-garden" aria-hidden="true">
                <span class="dx-contact-garden-orbit"></span>
                <img class="dx-contact-art dx-contact-art-cosmos" src="<?php echo base_url("assets/front/media/dx-contact-cosmos.jpg"); ?>" alt="" width="598" height="900">
                <img class="dx-contact-art dx-contact-art-corner" src="<?php echo base_url("assets/front/media/dx-contact-botanical-corner.jpg"); ?>" alt="" width="900" height="900">
                <span class="dx-contact-garden-label">Care comes naturally.</span>
            </div>
        </div>
    </section>

    <section class="dx-contact-body" aria-labelledby="dx-contact-form-title">
        <div class="dx-contact-wrap dx-contact-grid">
            <article class="dx-contact-form-card" id="contact-form">
                <header>
                    <span class="dx-contact-kicker">A note, just for us</span>
                    <h2 id="dx-contact-form-title">How can we <em>help?</em></h2>
                    <p>Tell us what’s on your mind. Fields marked * are required.</p>
                </header>
                <?php if ($contact_notice) { ?>
                <div class="dx-contact-feedback dx-contact-success" role="status" tabindex="-1">
                    <strong>Thank you &mdash; we have your message.</strong>
                    <p>Reference #<?php echo (int) $contact_notice["id"]; ?>. Our team will get back to you soon. If it is urgent, call us on <a href="tel:<?php echo html_escape($contact_tel); ?>"><?php echo html_escape($contact_phone); ?></a>.</p>
                </div>
                <?php } ?>
                <?php if ($contact_errors) { ?>
                <div class="dx-contact-feedback dx-contact-error" role="alert" tabindex="-1">
                    <strong>Please check your message.</strong>
                    <ul><?php foreach ($contact_errors as $error) { ?><li><?php echo html_escape(strip_tags($error)); ?></li><?php } ?></ul>
                </div>
                <?php } ?>
                <form id="contact_form" method="post" action="<?php echo base_url("contact-us#contact-form"); ?>">
                    <input type="hidden" name="contact_token" value="<?php echo html_escape($contact_token); ?>">
                    <?php if ($this->config->item("csrf_protection")) { ?>
                    <input type="hidden" name="<?php echo html_escape($this->security->get_csrf_token_name()); ?>" value="<?php echo html_escape($this->security->get_csrf_hash()); ?>">
                    <?php } ?>
                    <div class="dx-contact-honeypot" aria-hidden="true">
                        <label for="contact-website">Leave this field empty</label>
                        <input id="contact-website" type="text" name="website" value="" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="dx-contact-fields">
                        <?php foreach (array(
                            "name" => array("Your name *", "text", "How should we call you?", "name", 200),
                            "email" => array("Email address *", "email", "you@example.com", "email", 254),
                            "mobile" => array("Phone number (optional)", "tel", "+91", "tel", 30),
                            "subject" => array("What’s it about? *", "text", "Sizing, an order, or something else", "off", 200)
                        ) as $field => $spec) { ?>
                        <div class="dx-contact-field">
                            <label for="contact-<?php echo $field; ?>"><?php echo html_escape($spec[0]); ?></label>
                            <input id="contact-<?php echo $field; ?>" name="<?php echo $field; ?>" type="<?php echo $spec[1]; ?>" placeholder="<?php echo html_escape($spec[2]); ?>" autocomplete="<?php echo $spec[3]; ?>" maxlength="<?php echo $spec[4]; ?>" value="<?php echo set_value($field); ?>" <?php echo $field !== "mobile" ? "required" : ""; ?> <?php if (isset($contact_errors[$field])) { ?>aria-invalid="true" aria-describedby="contact-<?php echo $field; ?>-error"<?php } ?>>
                            <?php if (isset($contact_errors[$field])) { ?><small class="dx-contact-field-error" id="contact-<?php echo $field; ?>-error"><?php echo html_escape(strip_tags($contact_errors[$field])); ?></small><?php } ?>
                        </div>
                        <?php } ?>
                        <div class="dx-contact-field dx-contact-field-wide">
                            <label for="contact-message">Your message *</label>
                            <textarea id="contact-message" name="message" rows="5" minlength="10" maxlength="5000" required placeholder="A little detail helps us help you." aria-describedby="contact-message-help<?php echo isset($contact_errors["message"]) ? " contact-message-error" : ""; ?>" <?php echo isset($contact_errors["message"]) ? 'aria-invalid="true"' : ""; ?>><?php echo set_value("message"); ?></textarea>
                            <small id="contact-message-help">10–5,000 characters. Please don’t include payment details or passwords.</small>
                            <?php if (isset($contact_errors["message"])) { ?><small class="dx-contact-field-error" id="contact-message-error"><?php echo html_escape(strip_tags($contact_errors["message"])); ?></small><?php } ?>
                        </div>
                    </div>
                    <div class="dx-contact-form-bottom">
                        <p>A thoughtful answer starts with a simple hello.</p>
                        <button class="dx-contact-send" type="submit"><span>Send message</span><span aria-hidden="true">&rarr;</span></button>
                    </div>
                </form>
                <svg class="dx-contact-form-flower" viewBox="0 0 140 140" fill="none" aria-hidden="true"><g stroke="currentColor" stroke-width="1.3"><path d="M70 58C43 40 51 7 70 13C89 7 97 40 70 58ZM82 70C100 43 133 51 127 70C133 89 100 97 82 70ZM70 82C97 100 89 133 70 127C51 133 43 100 70 82ZM58 70C40 97 7 89 13 70C7 51 40 43 58 70Z"/><circle cx="70" cy="70" r="12"/></g></svg>
            </article>

            <aside class="dx-contact-info" aria-label="Other ways to reach DEXTE">
                <article class="dx-contact-info-card dx-contact-location">
                    <span class="dx-contact-kicker">Come say hello</span>
                    <span class="dx-contact-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
                    <h3>Rooted in <em>Delhi.</em></h3>
                    <p><?php echo html_escape($contact_address); ?></p>
                    <a class="dx-contact-text-link" href="#contact-map">Find us on the map <span aria-hidden="true">&rarr;</span></a>
                    <img class="dx-contact-location-art" src="<?php echo base_url("assets/front/media/dx-contact-pink-bud.jpg"); ?>" alt="" width="424" height="900" loading="lazy">
                </article>
                <a class="dx-contact-info-card dx-contact-call" href="tel:<?php echo html_escape($contact_tel); ?>">
                    <span class="dx-contact-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m7 3 3 5-2 2c1 3 3 5 6 6l2-2 5 3-1 4C10 23 1 14 3 4Z"/></svg></span>
                    <span class="dx-contact-kicker">Prefer a conversation?</span>
                    <h3>Give us a call.</h3><p><?php echo html_escape($contact_phone); ?></p>
                    <span class="dx-contact-card-arrow" aria-hidden="true">&nearr;</span>
                </a>
                <a class="dx-contact-info-card dx-contact-email" href="mailto:<?php echo html_escape($contact_email); ?>">
                    <span class="dx-contact-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3 6 9 7 9-7"/></svg></span>
                    <span class="dx-contact-kicker">A note works too</span>
                    <h3>Write to us.</h3><p><?php echo html_escape($contact_email); ?></p>
                    <span class="dx-contact-card-arrow" aria-hidden="true">&nearr;</span>
                </a>
                <article class="dx-contact-info-card dx-contact-help">
                    <svg class="dx-contact-help-leaf" viewBox="0 0 110 170" fill="none" aria-hidden="true"><path d="M36 161C48 118 54 74 76 14M57 90C27 85 13 67 11 42C40 46 54 63 57 90ZM65 66C90 62 104 42 103 22C79 27 66 42 65 66ZM47 125C19 119 9 103 8 83C33 89 45 103 47 125Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M57 90C27 85 13 67 11 42C40 46 54 63 57 90ZM65 66C90 62 104 42 103 22C79 27 66 42 65 66Z" fill="currentColor" fill-opacity=".12"/></svg>
                    <span class="dx-contact-kicker">Little questions, answered</span>
                    <h3>Your comfort, <em>made clearer.</em></h3>
                    <p>Explore our FAQs for fit, care and absorbency, or chat with us on WhatsApp.</p>
                    <div class="dx-contact-help-links"><a href="<?php echo base_url("FAQs"); ?>">Read FAQs &rarr;</a><a href="https://wa.me/<?php echo html_escape($contact_whatsapp); ?>" target="_blank" rel="noopener noreferrer">WhatsApp &nearr;</a></div>
                </article>
            </aside>
        </div>
    </section>

    <section class="dx-contact-map-section" id="contact-map" aria-labelledby="dx-contact-map-title">
        <div class="dx-contact-wrap">
            <header><div><span class="dx-contact-kicker">Find your way to us</span><h2 id="dx-contact-map-title">A little closer to <em>comfort.</em></h2></div><p><?php echo html_escape($contact_address); ?></p></header>
            <div class="dx-contact-map-frame">
                <iframe title="Map showing the DEXTE contact address" src="https://maps.google.com/maps?q=<?php echo rawurlencode($contact_address); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <img class="dx-contact-map-art" src="<?php echo base_url("assets/front/media/dx-contact-botanical-corner.jpg"); ?>" alt="" width="900" height="900" loading="lazy">
            </div>
        </div>
    </section>
</main>
<?php $this->load->view("front/layout/footer"); ?>
<?php $this->load->view("front/layout/footer-js"); ?>
<script src="<?php echo base_url("assets/front/js/contact-form.js"); ?>" defer></script>
</body>
</html>
