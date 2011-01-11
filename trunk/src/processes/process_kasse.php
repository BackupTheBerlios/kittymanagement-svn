<?php

require_once('../config/Init.php');

if($_POST['bareinzahlung']) {
	$zahlung_ma_id = $_POST['ma_id'];
	$zahlung_betrag = $_POST['betrag'];
	$zahlung_bemerkung = $_POST['bemerkung'];

	echo $ACC->postIncomingPayment($zahlung_ma_id, date("Y-m-d"), $zahlung_betrag, $zahlung_bemerkung);
}

if($_POST['ausgabe']) {

	$aus_betrag = $_POST['betrag'];
	$aus_bemerkung = $_POST['bemerkung'];

	echo $ACC->postSpendings(date("Y-m-d"), $aus_betrag, $aus_bemerkung);
}

if($_POST['bucheBeitrag']) {
	$ma_id = $_POST['ma_id'];
	$faktor = $_POST['faktor']; 
	$betrag = $_POST['betrag'];
	$sendMail = $_POST['mail'];
	$monthOfPosting = strftime("%B")." ".strftime("%Y");

	$success = $ACC->postContributions($ma_id, date("Y-m-d"), $betrag, "Monatsbeitrag - ".$monthOfPosting);
	
	$successComment = "";
	
	if($success == -2) {
		$successComment = "Buchung vorhanden";
	}
	if($success == -1) {
		$successComment = "Fehler!";
	}
	
	$mailSuccess = -1;
	if(($success == 1) && ($sendMail == 1)) {
		$usrObject = $MA->getMitglied(false, $ma_id);
		if($MAILER->sendContributionInformationMail($usrObject, $betrag, $monthOfPosting)) {
			$mailSuccess = 1;
		} else {
			$mailSuccess = -666;
		}
		
	}
	
	$returnValues = array('month' => $monthOfPosting, 'success' => $success, 'successComment' => $successComment, 'mailSend' => $mailSuccess);
	
	echo json_encode($returnValues);
	
}

if($_GET['zeigeAusgaben'] == 1) {
	$spendingList = $KAS->getCashBoxPostings(_SPENDING_DISPLAY_COUNT);
	
	if(is_array($spendingList)) {
		$tbl = '<table>
				<tr>
					<th>Datum</th>
					<th>Bemerkung</th>
					<th>Einzahlung</th>
					<th>Auszahlung</th>
				</tr>';
		foreach($spendingList as $spending) {
			$tbl .= "<tr>";
			foreach($spending as $key => $value) {				
				if($key == "datum") {
					$tbl .= "<td>".$value."</td>";
				}
				if($key == "bemerkung") {
					$tbl .= "<td>".htmlentities($value)."</td>";
				}
				if($key == "betrag") {
					if($value < 0) {
						$tbl .= '<td class="betrag">'.number_format($value*-1, 2, ",", ".").' &euro;</td>';
						$tbl .= '<td>&#160;</td>';
					} elseif($value >= 0) {
						$tbl .= '<td>&#160;</td>';
						$tbl .= '<td class="betrag">'.number_format($value, 2, ",", ".").' &euro;</td>';
					}
				}				
			}
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $spendingList;
	}
}

if($_GET['zeigeEinzahlungen'] == 1) {
	$paymentList = $KAS->getPayments(_PAYMENT_DISPLAY_COUNT);
	
	if(is_array($paymentList)) {
		$tbl = '<table>
				<tr>
					<th>Datum</th>
					<th>Teilnehmer</th>
					<th>Bemerkung</th>
					<th>Betrag</th>
				</tr>';
		foreach($paymentList as $payment) {
			$tbl .= "<tr>";
			foreach($payment as $key => $value) {				
				if($key == "datum") {
					$tbl .= "<td>".$value."</td>";
				}
				if($key == "name") {
					$tbl .= "<td>".htmlentities($value)."</td>";
				}
				if($key == "bemerkung") {
					$tbl .= "<td>".$value."</td>";
				}
				if($key == "betrag") {
					$tbl .= '<td class="betrag">'.number_format($value, 2, ",", ".").' &euro;</td>';
				}				
			}
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $paymentList;
	}
}
?>