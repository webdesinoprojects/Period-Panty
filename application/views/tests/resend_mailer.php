<?php
/**
 * Checks what MY_Email hands to Resend, without a key and without network.
 * Run: php application/views/tests/resend_mailer.php
 */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);

function log_message($level, $msg) { $GLOBALS['logs'][] = $level . ': ' . $msg; }

/** Only the parts of CI_Email that MY_Email actually touches. */
class CI_Email {
	public $mailtype = 'text';
	protected $_recipients = array();
	protected $_cc_array = array();
	protected $_bcc_array = array();
	protected $_subject = '';
	protected $_body = '';
	protected $_attachments = array();
	protected $_debug_msg = array();
	public $errors = array();

	public function clean_email($e) { return is_array($e) ? $e[0] : trim($e); }
	public function from($f, $n = '', $r = NULL) { return $this; }
	public function reply_to($r, $n = '') { return $this; }
	public function subject($s) { $this->_subject = $s; return $this; }
	public function to($t) { $this->_recipients = is_array($t) ? $t : array_map('trim', explode(',', $t)); return $this; }
	public function message($b) { $this->_body = $b; return $this; }
	public function clear($a = FALSE) { $this->_recipients = array(); $this->_body = ''; return $this; }
	public function send($auto_clear = TRUE) { $GLOBALS['fellback'] = TRUE; return 'FELL-BACK-TO-PARENT'; }
	protected function _set_error_message($m, $v = '') { $this->errors[] = $m; }
}

require dirname(__DIR__, 2) . '/libraries/MY_Email.php';

/** Captures the payload instead of posting it. */
class TestEmail extends MY_Email {
	public $captured = NULL;
	protected function dx_post(array $payload, $key) { $this->captured = $payload; return TRUE; }
}

$fail = 0;
function check($label, $got, $want) {
	global $fail;
	$ok = ($got === $want);
	if (!$ok) { $fail++; }
	printf("%-56s %s\n", $label, $ok ? 'ok' : "FAIL got=" . var_export($got, TRUE) . " want=" . var_export($want, TRUE));
}

// ---------------------------------------------------------------- fallback
putenv('DEXTE_RESEND_API_KEY');
$GLOBALS['fellback'] = FALSE;
$m = new TestEmail();
$m->from('info@dexte.com', 'DEXTE')->to('x@y.com')->subject('s')->message('b');
$r = $m->send();
check('no key -> falls back to the old transport', $r, 'FELL-BACK-TO-PARENT');

// ------------------------------------------------------------ with the key
putenv('DEXTE_RESEND_API_KEY=re_test123');
putenv('DEXTE_MAIL_FROM=noreply@dextewellness.com');
putenv('DEXTE_MAIL_FROM_NAME=DEXTE');

$m = new TestEmail();
$m->from('info@dexte.com', 'DEXTE')->to('buyer@example.com')
  ->subject('Order Confirm')->message('Thanks for your order');
$m->send(FALSE);
$p = $m->captured;
check('From is overridden to the verified domain',
      $p['from'], '"DEXTE" <noreply@dextewellness.com>');
check('Reply-To falls back to the displaced sender',
      $p['reply_to'], '"DEXTE" <info@dexte.com>');
check('recipient list', $p['to'], array('buyer@example.com'));
check('subject is the raw one, not Q-encoded', $p['subject'], 'Order Confirm');
check('text body for mailtype text', $p['text'], 'Thanks for your order');
check('no html field when sending text', isset($p['html']), FALSE);

// ----------------------------------------------------- html + explicit reply
$m = new TestEmail();
$m->mailtype = 'html';
$m->from('info@dexte.com', 'DEXTE')->to('admin@dexte.com')
  ->reply_to('shopper@gmail.com', 'A Shopper')
  ->subject('DEXTE contact enquiry #9')->message('<p>hello</p>');
$m->send(FALSE);
$p = $m->captured;
check('html body for mailtype html', $p['html'], '<p>hello</p>');
check('no text field when sending html', isset($p['text']), FALSE);
check('caller Reply-To wins over the fallback',
      $p['reply_to'], '"A Shopper" <shopper@gmail.com>');

// --------------------------------------------------------- multi-recipient
$m = new TestEmail();
$m->from('info@dexte.com', 'DEXTE')->to('a@x.com, b@x.com')->subject('s')->message('b');
$m->send(FALSE);
check('comma separated recipients split', $m->captured['to'], array('a@x.com', 'b@x.com'));

// ------------------------------------------------------------- header safety
$m = new TestEmail();
$m->from('info@dexte.com', "Evil\r\nBcc: sneak@bad.com")->to('a@x.com')->subject('s')->message('b');
$m->send(FALSE);
putenv('DEXTE_MAIL_FROM_NAME');   // so the injected name is the one used
$m2 = new TestEmail();
$m2->from('info@dexte.com', "Evil\r\nBcc: sneak@bad.com")->to('a@x.com')->subject('s')->message('b');
$m2->send(FALSE);
check('CRLF stripped from display name',
      strpos($m2->captured['from'], "\r") === FALSE && strpos($m2->captured['from'], "\n") === FALSE, TRUE);
putenv('DEXTE_MAIL_FROM_NAME=DEXTE');

// --------------------------------------------------------- no recipients
$m = new TestEmail();
$m->from('info@dexte.com', 'DEXTE')->subject('s')->message('b');
check('empty recipient list refuses to send', $m->send(FALSE), FALSE);

// ------------------------------------------------- missing DEXTE_MAIL_FROM
putenv('DEXTE_MAIL_FROM');
$m = new TestEmail();
$m->from('info@dexte.com', 'DEXTE')->to('a@x.com')->subject('s')->message('b');
$m->send(FALSE);
check('falls back to the code From when MAIL_FROM unset',
      $m->captured['from'], '"DEXTE" <info@dexte.com>');

echo "\n", ($fail ? $fail . " FAILED" : "all passed"), "\n";
exit($fail ? 1 : 0);
