<?php

function getvask($inn) {
	if (!isset($_GET[$inn])) {
		$_GET[$inn] = "";
	}
	return  htmlentities(strip_tags(mysql_real_escape_string($_GET[$inn])), ENT_QUOTES, "UTF-8");

}

function postvask($inn) {
	if (!isset($_POST[$inn])) {
		$_POST[$inn] = "";
	}
	return  htmlentities(strip_tags(mysql_real_escape_string($_POST[$inn])), ENT_QUOTES, "UTF-8");

}

?>
