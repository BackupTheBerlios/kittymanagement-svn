<?php

require(_PHPMAILER_DIR.'class.phpmailer.php');

class MyPHPMailer extends PHPMailer {
	
	private $myMailer = null;
	
	/**
	 * Klassenkonstruktor<br />
	 * Setzt die Konfiguration aus dem Konfig File
	 *
	 */
	public function __construct() {
		if($this->myMailer === null) {
			$this->myMailer = new PHPMailer();
			
			// telling the class to use SMTP
			if(_MAILER_IS_SMTP == 1) $this->myMailer->IsSMTP();
			
			$this->myMailer->Host       = _MAILER_HOST; // SMTP server
			
			switch (_MAILER_SMTP_DEBUG) {
				case 1:
					$this->myMailer->SMTPDebug  = 1;
				break;
				
				case 2:
					$this->myMailer->SMTPDebug  = 2;
				break;
				
				case 0:
				break;
			}
			
			$this->myMailer->SMTPAuth   = _MAILER_SMTP_AUTH;
			$this->myMailer->Port       = _MAILER_HOST_PORT;
			$this->myMailer->Username   = _MAILER_USER_EMAIL;
			$this->myMailer->Password   = _MAILER_USER_PASSWD;

			if(_MAILER_MAIL_IS_HTML == 1) {
				$this->myMailer->IsHTML(true);
				$this->myMailer->AltBody = "Dies ist eine HTML eMail\n\nBitte benutzen Sie ein HTML faehiges eMail Programm!";
			}
						
			$this->myMailer->SetFrom(_MAILER_USER_EMAIL, _MAILER_USER_FULL_NAME);

			$this->myMailer->AddReplyTo(_MAILER_USER_EMAIL, _MAILER_USER_FULL_NAME);
			
		}
		
	}

	public function setSubject($iSubject) {
		$this->myMailer->Subject = $iSubject;
	}
	
	public function setMessageText($iMessageText) {
		$this->myMailer->MsgHTML($iMessageText);
	}
		
	public function bla() {
		
		$address = "svn_geoinfo@igg.uni-bonn.de";
		$this->myMailer->AddAddress($address, "SVN");

		if(!$this->myMailer->Send()) {
			echo "Mailer Error: " . $this->myMailer->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}

}

?>