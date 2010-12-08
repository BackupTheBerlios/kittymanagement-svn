<?php

require_once('../src/config/Init.php');

$SM->assign("nav_id_lager", 'id="current"');

$SM->assign("artListe", $LA->getArtikelListe());
$SM->assign("lagerBestand", $LA->getBookableStockPostings());

print_r($SM->get_template_vars("lagerBestand"));

if($_POST) {
	if($_POST['artikelEintragen']) {
		$art_sorte = $_POST['sorte'];
		$art_uom = $_POST['uom'];
		$art_uom_short = $_POST['uom_short'];
		$art_size = $_POST['size'];
		
		$SM->assign("art_add_return", $LA->addArtikel($art_sorte, $art_uom, $art_uom_short, $art_size));
	}
	
	if($_POST['lagerEinbuchen']) {
		$dtmp = explode("-", $_POST['ek_datum']); // dd mm yyyy
		$date = $dtmp[2].'-'.$dtmp[1].'-'.$dtmp[0]; // yyyy mm dd
		$art_id = $_POST['art_id'];
		$size = $_POST['ek_size'];
		$singlePrice = 0;
		if($_POST['ek_p_einzel']) {
			$singlePrice = $_POST['ek_p_einzel'];
		} else {
			$singlePrice = $_POST['ek_p_summ'] / $size;
		}
		$SM->assign("ek_add_return", $LA->checkInStockPosting($art_id, $size, $singlePrice, $date));
	}
	
	if($_POST['lagerAusbuchen']) {
		$dtmp = explode("-", $_POST['vb_datum']); // dd mm yyyy
		$datum = $dtmp[2].'-'.$dtmp[1].'-'.$dtmp[0]; // yyyy mm dd
		$ekId = $_POST['la_buchung'];
		$size = $_POST['vb_size'];
		$cupCount = $_POST['cup_count'];
		$SM->assign("vb_add_return", $LA->checkOutStockPosting($datum, $ekId, $size, $cupCount));
	}
	
}

$SM->display("lager.tpl.php");

?>