<?php

require_once('../src/config/Init.php');

$SM->assign("lagerArtikel", $LA->getArtikelListe());
$SM->assign("lagerBestand", $LA->getBookableStockPostings());
$SM->assign("letzteEingaenge", $LA->getLastStockPostings(_STORAGE_ENTRY_DISPLAY_COUNT));

$subPage = $_GET['p'];


if($_POST) {
	if($_POST['lagerAusbuchen']) {
		$dtmp = explode("-", $_POST['vb_datum']); // dd mm yyyy
		$datum = $dtmp[2].'-'.$dtmp[1].'-'.$dtmp[0]; // yyyy mm dd
		$ekId = $_POST['la_buchung'];
		$size = $_POST['vb_size'];
		$cupCount = $_POST['cup_count'];
		$SM->assign("vb_add_return", $LA->checkOutStockPosting($datum, $ekId, $size, $cupCount));
	}
	
}

$SM->display("lager_".$subPage.".tpl.php");

?>