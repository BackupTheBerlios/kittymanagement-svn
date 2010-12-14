<?php

/**
 * sonstige Definitionen
 */
// Beitragssatz
define("_BEITRAG_FIX", 1); // Beitragssatz fix (1) -> Satz aus Config, berechnet (0) -> Satz aus Datenbank
define("_BEITRAG_SATZ", 4.00); // Basisbeitrag bei Verwendung des fixen Satzes. Wird mit den definierten Faktoren verrechnet

define("_BEITRAG_FAKTOR_MA", 1.0);
define("_BEITRAG_FAKTOR_HIWI", 0.5);

/**
 * Datenbankanbindung
 */

// Verbindungsinfos
define("_DB_HOST","localhost");
define("_DB_USER","kaffeekasse");
define("_DB_PASSWD","kaffee");
define("_DB_DATABASE","kaffeekasse");

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
define("_BASE_DIR","/var/www/projects/Kaffeekasse/");

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