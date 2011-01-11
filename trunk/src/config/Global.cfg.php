<?php

/**
 * sonstige Definitionen
 */
// Beitragssatz
define("_BEITRAG_FIX", 1); // Beitragssatz fix (1) -> Satz aus Config, berechnet (0) -> Satz aus Datenbank
define("_BEITRAG_SATZ", 4.00); // Basisbeitrag bei Verwendung des fixen Satzes. Wird mit den definierten Faktoren verrechnet

define("_BEITRAG_FAKTOR_MA", 1.0);
define("_BEITRAG_FAKTOR_HIWI", 0.5);

define("_NAME_KASSENWART", "Tobias Beckmerhagen");

/**
 * Datenbankanbindung
 */

// Verbindungsinfos
define("_DB_HOST","localhost");
define("_DB_USER","kaffee");
define("_DB_PASSWD","kaffee");
define("_DB_DATABASE","kaffee");

// Tabellen
define("_TBL_MA_","mitglieder_stamm");
define("_TBL_MA_KTO_","mitglieder_konto");
define("_TBL_MA_STAT_","mitglieder_status");

define("_TBL_KA_KASSE_","kaffee_kasse");
define("_TBL_KA_VERBRAUCH_","kaffee_verbrauch");

define("_TBL_LA_ARTIKEL_","lager_artikel");
define("_TBL_LA_EINGANG","lager_eingang");
define("_TBL_LA_AUSGANG","lager_ausgang");

define("_TBL_GER_ZAEHLER_","maschine_tassen");

/**
 * Verzeichnisse 
 */

// Basisverzeichnis
define("_BASE_DIR","/var/www/projekte/Kaffeekasse/");

// Pfad zu den Libs
define("_LIB_DIR",_BASE_DIR."lib/");

// Pfad zu den Klassen
define("_CLASS_DIR",_BASE_DIR."src/classes/");

// Pfad zu den Functions
define("_FUNC_DIR",_BASE_DIR."src/functions/");

// Pfad zu den Processes
define("_PROCESS_DIR",_BASE_DIR."src/processes/");

// Smarty
define("_SMARTY_DIR",_LIB_DIR."smarty/");
define("_SMARTY_TPL_DIR",_BASE_DIR."page/templates/");
define("_SMARTY_TPLC_DIR",_BASE_DIR."page/templates_c/");
define("_SMARTY_CFG_DIR",_BASE_DIR."src/config/");
define("_SMARTY_CACHE_DIR",_BASE_DIR."page/cache/");

// PHPMailer
define("_PHPMAILER_DIR",_LIB_DIR."PHPMailer_5.1/");
define("_MAILER_IS_SMTP", 1); // 1 = use SMTP (default) | 0 = dont use SMTP
define("_MAILER_HOST", 'mail.uni-bonn.de'); // SMTP server
define("_MAILER_SMTP_DEBUG", 1); // sets SMTP gebug Level (0 = off | 1 = errors & messages | 2 = messages only)
define("_MAILER_SMTP_AUTH", true); // enable SMTP authentication
define("_MAILER_HOST_PORT", 25); // set the SMTP port for the GMAIL server
define("_MAILER_MAIL_IS_HTML", 1); // defines if mail is plain text (0) oder html (1)
define("_MAILER_USER_EMAIL", 'beckmerhagen@igg.uni-bonn.de'); // SMTP account username
define("_MAILER_USER_PASSWD", 'r4gn4ro3k'); // SMTP account password
define("_MAILER_USER_FULL_NAME", 'Tobias Beckmerhagen'); // Full Name or identifier / description of the sender
define("_MAILER_CHARSET", 'UTF-8'); // define the default Charset for emails

/**
 * Version und Name
 */
define("_PROG_VERSION","0.5 Alpha");
define("_PROG_NAME",".:[ IGG Kaffeekasse ]:.");
define("_APP_TITLE_NAME", ":: Kaffeekassenverwaltung ::");
define("_APP_NAME", ":: IGG :: Kaffeekassenverwaltung ::");
define("_APP_VERSION", "0.5 alpha");

define("_PAYMENT_DISPLAY_COUNT", 10);
define("_SPENDING_DISPLAY_COUNT", 10);
define("_STORAGE_ENTRY_DISPLAY_COUNT", 10);
define("_STORAGE_OUTGOINGS_DISPLAY_COUNT", 10);

?>