<?php

require(_SMARTY_DIR.'Smarty.class.php');

/**
 * Angepasste Smarty-Klasse<br />
 * enthaelt direkte Konfigurationsinitialisierung
 *
 * @author Tobias Beckmerhagen
 * @version 1.0
 */
class MySmarty extends Smarty {
	
	/**
	 * Klassenkonstruktor<br />
	 * Parameter schaltet Smarty Debug-Modus an|aus (default: aus)<br />
	 * Setzt die Konfiguration der benoetigten Verzeichnisse
	 * 
	 * @param boolean $debug
	 */
	public function __construct($iDebug = false) {	
				
			// Smarty instantiieren und konfigurieren
			$this->Smarty();
			$this->template_dir = _SMARTY_TPL_DIR;
			$this->compile_dir = _SMARTY_TPLC_DIR;
			$this->compile_id = $_SERVER['SERVER_NAME'];
			$this->config_dir = _SMARTY_CFG_DIR;
			$this->cache_dir = _SMARTY_CACHE_DIR;
			
			// Smarty Debugging ein- oder ausschalten
			$iDebug ? $this->debugging = true : $this->debugging = false;
			
			// Caching aktivieren
			$this->caching = 0;
			
			// kompilieren der Templates erzwingen
			$this->force_compile = 1;		
		
	}
	
}

?>