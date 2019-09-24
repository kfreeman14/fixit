<?php
function local_datetime($mysql_datetime){
	$php_datetime=date_create($mysql_datetime);
	date_timezone_set($php_datetime, timezone_open('America/New_York'));
	$local_datetime= date_format($php_datetime, 'm/d/Y, g:i a');
	return $local_datetime;
}
?>