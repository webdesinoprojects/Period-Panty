<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sends through Resend's HTTP API instead of SMTP when a key is configured.
 *
 * Why this is a subclass rather than a change at each call site: nine places
 * across Contact, User, Checkout, Payment and Welcome already send with
 * $this->email->from()/to()/subject()/message()/send(). Overriding the
 * transport underneath them means none of those have to change, and the
 * moment DEXTE_RESEND_API_KEY is unset everything falls straight back to the
 * old SMTP/mail path.
 *
 * Resend will only accept a From address on a domain you have verified with
 * them. The address in tbl_setting is info@dexte.com, which is not that
 * domain, so DEXTE_MAIL_FROM replaces it and the original becomes Reply-To -
 * otherwise replies to an order confirmation would go nowhere.
 *
 * Environment:
 *   DEXTE_RESEND_API_KEY   re_... ; absent means "carry on as before"
 *   DEXTE_MAIL_FROM        a mailbox on the verified domain
 *   DEXTE_MAIL_FROM_NAME   display name, defaults to DEXTE
 */
class MY_Email extends CI_Email {

	const ENDPOINT = 'https://api.resend.com/emails';

	/** Raw values, kept because the parent Q-encodes them into headers. */
	protected $dx_from_email = '';
	protected $dx_from_name  = '';
	protected $dx_subject    = '';
	protected $dx_reply      = '';
	protected $dx_reply_name = '';

	public function from($from, $name = '', $return_path = NULL)
	{
		$this->dx_from_email = $this->clean_email($from);
		$this->dx_from_name  = $name;
		return parent::from($from, $name, $return_path);
	}

	public function reply_to($replyto, $name = '')
	{
		$this->dx_reply      = $this->clean_email($replyto);
		$this->dx_reply_name = $name;
		return parent::reply_to($replyto, $name);
	}

	public function subject($subject)
	{
		$this->dx_subject = $subject;
		return parent::subject($subject);
	}

	public function clear($clear_attachments = FALSE)
	{
		$this->dx_from_email = $this->dx_from_name = '';
		$this->dx_subject    = $this->dx_reply = $this->dx_reply_name = '';
		return parent::clear($clear_attachments);
	}

	public function send($auto_clear = TRUE)
	{
		$key = getenv('DEXTE_RESEND_API_KEY');
		if ( ! $key)
		{
			return parent::send($auto_clear);
		}

		// Attachments would need multipart encoding against a different Resend
		// field; nothing here sends any, so hand those back to the parent
		// rather than silently dropping the file.
		if ( ! empty($this->_attachments))
		{
			return parent::send($auto_clear);
		}

		$to = array_values(array_filter(array_map('trim', (array) $this->_recipients)));
		if (empty($to))
		{
			$this->_set_error_message('lang:email_no_recipients');
			return FALSE;
		}

		$from_email = getenv('DEXTE_MAIL_FROM') ?: $this->dx_from_email;
		$from_name  = getenv('DEXTE_MAIL_FROM_NAME') ?: ($this->dx_from_name ?: 'DEXTE');
		if ( ! filter_var($from_email, FILTER_VALIDATE_EMAIL))
		{
			log_message('error', 'Resend: no usable From address; set DEXTE_MAIL_FROM.');
			return FALSE;
		}

		// A caller's own Reply-To wins; otherwise point replies at whoever the
		// code meant to send as, since DEXTE_MAIL_FROM has just displaced them.
		$reply      = $this->dx_reply ?: $this->dx_from_email;
		$reply_name = $this->dx_reply ? $this->dx_reply_name : $this->dx_from_name;

		$payload = array(
			'from'    => $this->dx_address($from_email, $from_name),
			'to'      => $to,
			'subject' => (string) $this->dx_subject,
		);
		if (strtolower($this->mailtype) === 'html')
		{
			$payload['html'] = $this->_body;
		}
		else
		{
			$payload['text'] = $this->_body;
		}
		if (filter_var($reply, FILTER_VALIDATE_EMAIL))
		{
			$payload['reply_to'] = $this->dx_address($reply, $reply_name);
		}
		foreach (array('cc' => '_cc_array', 'bcc' => '_bcc_array') as $field => $prop)
		{
			if ( ! empty($this->$prop))
			{
				$payload[$field] = array_values((array) $this->$prop);
			}
		}

		$ok = $this->dx_post($payload, $key);
		if ($auto_clear)
		{
			$this->clear();
		}
		return $ok;
	}

	/** "Name <addr@example.com>", or the bare address when there is no name. */
	protected function dx_address($email, $name)
	{
		$name = trim(preg_replace('/[\r\n"]+/', ' ', (string) $name));
		return ($name === '') ? $email : '"' . $name . '" <' . $email . '>';
	}

	protected function dx_post(array $payload, $key)
	{
		$ch = curl_init(self::ENDPOINT);
		curl_setopt_array($ch, array(
			CURLOPT_POST           => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT        => 15,
			CURLOPT_HTTPHEADER     => array(
				'Authorization: Bearer ' . $key,
				'Content-Type: application/json',
			),
			CURLOPT_POSTFIELDS     => json_encode($payload),
		));
		$body   = curl_exec($ch);
		$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err    = curl_error($ch);
		curl_close($ch);

		if ($status >= 200 && $status < 300)
		{
			$this->_debug_msg[] = 'Resend accepted the message.' . "\n";
			return TRUE;
		}

		// The key must never reach a log; the response body does not contain it.
		log_message('error', 'Resend send failed (HTTP ' . $status . '): '
			. ($err !== '' ? $err : substr((string) $body, 0, 500)));
		$this->_set_error_message('lang:email_send_failure_smtp');
		return FALSE;
	}
}
