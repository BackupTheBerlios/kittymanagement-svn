<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty ger_number_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     ger_number_format<br>
 * Purpose:  Rewrites a number from US to German decimal notation  
 * @link http://www.php.net/number_format
 * @param float
 * @param integer (default 2)
 * @return string 
 */
function smarty_modifier_ger_number_format($number, $decimalCount = 2) {
	return number_format($number, $decimalCount, ",", ".");
}

?>