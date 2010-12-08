<?php

/*
 * Pr&uuml;ft eine Mailadresse auf korrekte Syntax und Existenz des MX Records
 */
function checkMail($mail) {

	$email = htmlspecialchars($mail);
	$return = false;

	if(preg_match('/(.*?)\@(.*?)\.(\w){2,6}/i', $email)) {
		$split = explode("@", $email);
		$split2 = explode(".", $split[1]);
		if(preg_match('/([a-z]){3,64}/i', $split2[0])) {
			if(preg_match('/([a-z0-9\!\"\$\&\/\(\)\?\~\#\+\.\:\_\-]+){1,64}[^\@]/i', $split[0])) {
				$MXCheck = getmxrr($split[1], &$mxhosts);
				if(!empty($MXCheck)) {
					$return = true;
				}
			}
		}
	}

	return $return;
}

?>