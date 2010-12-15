<?php

require_once('../src/config/Init.php');

$SM->assign("lagerArtikel", $LA->getArtikelListe());
$SM->assign("lagerBestand", $LA->getBookableStockPostings());
$SM->assign("letzteEingaenge", $LA->getLastStockPostings(_STORAGE_ENTRY_DISPLAY_COUNT));

$subPage = $_GET['p'];

$SM->display("lager_".$subPage.".tpl.php");

?>