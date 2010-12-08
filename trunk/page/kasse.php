<?php

require_once('../src/config/Init.php');

$subPage = $_GET['p'];

if($subPage == "auszahlung") {
	$spendingList = $KAS->getSpendings(_SPENDING_DISPLAY_COUNT);

	$SM->assign("spendingList", $spendingList);
} 

if($subPage == "einzahlung") {
	$paymentList = $KAS->getPayments(_PAYMENT_DISPLAY_COUNT);
	
	$SM->assign("paymentList", $paymentList);
}

if($subPage == "beitraege") {
	if(_BEITRAG_FIX == 1) {
		$contribMa = number_format((_BEITRAG_SATZ * _BEITRAG_FAKTOR_MA), 2, ",", ".");
		$contribHiWi = number_format((_BEITRAG_SATZ * _BEITRAG_FAKTOR_HIWI), 2, ",", ".");
		$contribComment = "fix";
	} 
	// TODO Bereich fuer Beitrag aus DB einbauen

	
	$SM->assign("contributionCalculationComment", $contribComment);
	$SM->assign("contributionMA", $contribMa);
	$SM->assign("contributionHiWi", $contribHiWi);
	$SM->assign("contributionFactorMA", _BEITRAG_FAKTOR_MA);
	$SM->assign("contributionFactorHiWi", _BEITRAG_FAKTOR_HIWI);
}

$SM->display("kasse_".$subPage.".tpl.php");

?>