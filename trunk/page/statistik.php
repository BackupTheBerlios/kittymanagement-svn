<?php

require_once('../src/config/Init.php');

/*
$maCount = $MA->getMitgliederCount();
$SM->assign('maCount', $maCount);

$artListe = $LA->getArtikelListe();
$SM->assign('artListe',$artListe);
*/

$subPage = $_GET['p'];

if($subPage == "konten") {
	foreach($MEMBER_LIST as $k => $v) {
		$memberAccSum[$v['id']] = $MA->getAccountBalance($v['id']);
	}	
	$SM->assign("memberAccountSum", $memberAccSum);
}


$SM->display("statistik_".$subPage.".tpl.php");

?>