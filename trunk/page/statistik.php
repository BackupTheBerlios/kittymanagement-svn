<?php

require_once('../src/config/Init.php');

$SM->assign("nav_id_statistik", 'id="current"');

$maCount = $MA->getMitgliederCount();
$SM->assign('maCount', $maCount);

$artListe = $LA->getArtikelListe();
$SM->assign('artListe',$artListe);

$SM->display("statistik.tpl.php");

?>