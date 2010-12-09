<?php

if($_POST['artikelEintragen']) {
	$art_sorte = $_POST['sorte'];
	$art_uom = $_POST['uom'];
	$art_uom_short = $_POST['uom_short'];
	$art_size = $_POST['size'];
	
	$SM->assign("art_add_return", $LA->addArtikel($art_sorte, $art_uom, $art_uom_short, $art_size));
}

?>