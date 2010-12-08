<?php

// wandelt PHP eigene Fehlermeldungen in Exceptions der Klasse ErrorException um
//set_error_handler(create_function('$a, $b, $c, $d', 'throw new ErrorException($b, 0, $a, $c, $d);'), E_ALL);

// Benutzerdefinierte Exceptions
class DBMySqlException extends Exception { }

?>