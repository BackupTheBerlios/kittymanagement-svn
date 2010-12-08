<?php

require_once('../src/config/Init.php');

if($_POST) {
	if($_POST['eintragen']) {
		$ma_name = $_POST['nname'];
		$ma_vname = $_POST['vname'];
		$ma_email = $_POST['email'];
		$ma_faktor = $_POST['faktor'];
		
		$addReturn = $MA->addMitglied($ma_name, $ma_vname, $ma_email, $ma_faktor);
		if($addReturn != 1) {
			$SM->assign("ma_data", array('nname' => $ma_name, 'vname' => $ma_vname, 'email' => $ma_email, 'faktor' => $ma_faktor));
		}
		$SM->assign("add_return", $addReturn);
	}
}

$memberList = $MA->getMitglied(true);
$SM->assign("member_list",$memberList);

$SM->display("benutzer_verwalten.tpl.php");
?>