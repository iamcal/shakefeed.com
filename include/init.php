<?php
	$cfg = array();

	$cfg['db_host']	= 'localhost';
	$cfg['db_name']	= 'shakefeed';
	$cfg['db_user']	= 'shakefeed';
	$cfg['db_pass']	= trim(file_get_contents(__DIR__.'/../secrets/mysql_password'));

	include('lib_db.php');

        $keys = array(
		'oauth_key'	=> 'HB8VvCOFWLU4MSwXyvEsaA',
		'oauth_secret'	=> trim(file_get_contents(__DIR__.'/../secrets/oauth_secret')),
		'user_key'	=> '6104-c992EHVDJlWebeMjVTiqDKiwzFiS7mQTehiHCDciUk',
		'user_secret'	=> trim(file_get_contents(__DIR__.'/../secrets/oauth_user_secret')),
	);

	function dumper($foo){
		echo "<pre style=\"text-align: left;\">";
		echo HtmlSpecialChars(var_export($foo, 1));
		echo "</pre>\n";
	}

	function idx($a, $idx, $def=null){
		return isset($a[$idx]) ? $a[$idx] : $def;
	}
