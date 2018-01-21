<?php
	include(__DIR__.'/../include/init.php');

	$ret = db_fetch("SELECT COUNT(*) FROM tweets WHERE link LIKE 'http://t.co/%' OR link LIKE 'https://t.co/%'");
	$num = array_pop($ret['rows'][0]);

	echo number_format($num)."\n";
