<?php

// ########################
// Initialisierung der Anwendung
// ########################

error_reporting(E_ALL);

date_default_timezone_set('Europe/Berlin'); // Fix Compiler Error if date() is called relying to the system timezone
$loc = setlocale(LC_TIME, 'de_DE', 'de_DE@euro', 'de_DE.utf8'); // Sprach bzw. Gebietsschema fuer Zeit / Datum etc. festlegen

//echo "LOCALE: ".$loc."<br>";

// Konfiguration einbinden
require_once('CustomExceptions.php');
require_once('Global.cfg.php');

// Funktionen einbinden
require_once(_FUNC_DIR.'/mailcheck.fkt.php');

// Klassen einbinden
require_once(_CLASS_DIR.'/MySmarty.class.php');
require_once(_CLASS_DIR.'/DBMySql.class.php');
require_once(_CLASS_DIR.'/MyPHPMailer.class.php');
//require_once(_CLASS_DIR.'/DBHelper.class.php');
require_once(_CLASS_DIR.'/Mitglieder.class.php');
require_once(_CLASS_DIR.'/Lager.class.php');
require_once(_CLASS_DIR.'/Accounting.class.php');
require_once(_CLASS_DIR.'/Kasse.class.php');
require_once(_CLASS_DIR.'/Statistik.class.php');

// Anwendungsweite Klassen instantiieren
//$SM = new MySmarty(true); // DEBUG AN
$SM = new MySmarty(false); // DEBUG AUS

try {
	$DB = new DBMySql();
} catch (DBMySqlException $dbe) {
	echo "<pre>";
	print_r($dbe->getTrace());
	echo "</pre>";
}

//$DBH = new DBHelper($DB->connection);
$MA = new Mitglieder($DB->connection);
$LA = new Lager($DB->connection);
$ACC = new Accounting($DB->connection);
$KAS = new Kasse($DB->connection);
$MAILER = new MyPHPMailer($DB->connection);
//$STAT = new CoffeeStatistics($DB->connection);

// Anwendungsweite Variablen fuellen
$SM->assign("applicationTitleName", _APP_TITLE_NAME);
$SM->assign("applicationName", _APP_NAME);
$SM->assign("applicationVersion", _APP_VERSION);
$SM->assign("paymentDisplayCount", _PAYMENT_DISPLAY_COUNT);
$SM->assign("spendingDisplayCount", _SPENDING_DISPLAY_COUNT);
$SM->assign("storageEntryDisplayCount", _STORAGE_ENTRY_DISPLAY_COUNT);
$SM->assign("storageOutgoingsDisplayCount", _STORAGE_OUTGOINGS_DISPLAY_COUNT);

$MEMBER_LIST = $MA->getMitglied(true);
$SM->assign("member_list",$MEMBER_LIST);

?>