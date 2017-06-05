<?
	$cfg = array();

	$cfg['db_host']	= 'localhost';
	$cfg['db_name']	= 'shakefeed';
	$cfg['db_user']	= 'shakefeed';
	$cfg['db_pass']	= trim(file_get_contents(__DIR__.'/../secrets/mysql_password'));

	include('lib_db.php');

	$keys = array(
		'oauth_key'	=> '...',
		'oauth_secret'	=> '...',
		'user_key'	=> '...',
		'user_secret'	=> '...',
	);

	function dumper($foo){
		echo "<pre style=\"text-align: left;\">";
		echo HtmlSpecialChars(var_export($foo, 1));
		echo "</pre>\n";
	}
