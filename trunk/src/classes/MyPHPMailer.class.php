<?php

require_once(_PHPMAILER_DIR.'class.phpmailer.php');

class MyPHPMailer extends PHPMailer {
	
	private $DBConn = null;
	private $myMailer = null;
	
	/**
	 * Klassenkonstruktor.<br />
	 * Erwartet eine MySQL Connection Ressource und Setzt die Konfiguration aus dem Konfig File
	 *
	 * @param MySQL_Connection $iDBConn
	 */
	public function __construct($iDBConn) {
		$this->DBConn = $iDBConn;
		if($this->myMailer === null) {
			$this->myMailer = new PHPMailer();
			
			// telling the class to use SMTP
			if(_MAILER_IS_SMTP == 1) $this->myMailer->IsSMTP();
			
			$this->myMailer->Host = _MAILER_HOST; // SMTP server
			
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
			
			$this->myMailer->SMTPAuth 	= _MAILER_SMTP_AUTH;
			$this->myMailer->Port 		= _MAILER_HOST_PORT;
			$this->myMailer->Username 	= _MAILER_USER_EMAIL;
			$this->myMailer->Password 	= _MAILER_USER_PASSWD;

			if(_MAILER_MAIL_IS_HTML == 1) {
				$this->myMailer->IsHTML(true);
				$this->myMailer->AltBody = "Dies ist eine HTML eMail\n\nBitte benutzen Sie ein HTML faehiges eMail Programm!";
			}

			$this->myMailer->SetFrom(_MAILER_USER_EMAIL, _MAILER_USER_FULL_NAME);

			$this->myMailer->AddReplyTo(_MAILER_USER_EMAIL, _MAILER_USER_FULL_NAME);
			
			$this->myMailer->CharSet = _MAILER_CHARSET;
		}
	}

	/**
	 * Sendet eine E-Mail an einen neu angelegten Benutzer
	 * 
	 * @author Tobias Beckmerhagen
	 * 
	 * @param String $mail
	 * @param String $name
	 * @param String $vname
	 * 
	 * @return String result message
	 */
	public function sendWelcomeMail($mail, $name, $vname) {
		$subject = 'Willkommen bei der Kaffeekasse';
		
		$welcomeText = '
			Hallo '.$vname.',<br>
			willkommen in der Kaffeekasse.<br>
			Du wirst nun monatlich per E-Mail eine Abrechnung bekommen.<br>
			Die Abrechnung wird Dich &uuml;ber die H&ouml;he des Beitrages f&uuml;r den Monat informieren und 
			Dir Deinen aktuellen Kontostand mitteilen.<br>
			Ebenfalls wird der jeweils aktuelle Reinigungsplan mit angef&uuml;gt, damit Du immer eine aktuelle &Uuml;bersicht hast, 
			welcher Teilnehmer in welcher Woche Dienst hat.<br>
			<br>
			Bei Fragen und / oder Problemen kannst Du Dich nat&uuml;rlich immer gerne an mich wenden.<br>
			<br>
			<br>
			Beste Gr&uuml;&szlig;e,<br>
			'._NAME_KASSENWART.'
		';
		
		$this->myMailer->AddAddress($mail, $name.', '.$vname);
		$this->myMailer->Subject = $subject;
		$this->myMailer->MsgHTML($welcomeText);
		
		if(!$this->myMailer->Send()) {
			return $this->myMailer->ErrorInfo;
		} else {
			return "Mail erfolgreich verschickt!";
		}
	}
	
	/**
	 * Sendet eine E-Mail mit Informationen zum aktuellen Abrechnungsmonat
	 * 
	 * @author Tobias Beckmerhagen
	 * 
	 * @param Array $usrObject
	 * @param Double $betrag
	 * @param String $monthOfPosting
	 * 
	 * @return String result message
	 */
	public function sendContributionInformationMail($usrObject, $betrag, $monthOfPosting) {
		
		// id, name, vorname, email, eintritt, faktor		
		
		$subject = 'Kaffeekasse: Abrechung f&uuml;r '.$monthOfPosting;
		
		$message = '
			Hallo '.$usrObject[2].',<br />
			f&uuml;r den Monat '.$monthOfPosting.' wird Dir eine Geb&uuml;hr von '.$betrag.' &euro; in Rechnung gestellt.<br />
			Dein aktueller Kontostand lautet: xxx,yy &euro;.<br />
			Bitte begleiche Deine Ausst&auml;nde umgehend.<br /><br />
			Beste Gr&uuml;&szlig;e,<br />
			'._NAME_KASSENWART.'
		';
		
		$this->myMailer->AddAddress($usrObject[3], $usrObject[1].', '.$usrObject[2]);
		$this->myMailer->Subject = $subject;
		$this->myMailer->MsgHTML($message);
		
		if(!$this->myMailer->Send()) {
			return $this->myMailer->ErrorInfo;
		} else {
			return 1;
		}
	}

}

?>