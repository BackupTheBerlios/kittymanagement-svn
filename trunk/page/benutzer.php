<?php

require_once('../src/config/Init.php');

$memberList = $MA->getMitglied(true);
$SM->assign("member_list",$memberList);

$SM->display("benutzer_verwalten.tpl.php");
?>