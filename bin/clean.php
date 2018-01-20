<?php
	include(__DIR__.'/../include/init.php');
	include(__DIR__.'/../include/lib_oauth.php');


	echo "Fixing: ";

	$ret = db_fetch("SELECT * FROM tweets WHERE link LIKE 'http://t.co/%' OR link LIKE 'https://t.co/%' ORDER BY date_create DESC");
	foreach ($ret['rows'] as $row){

		if (!preg_match('!^http!', $row['text'])) continue;

		list($link) = explode(' ', $row['text']);
                list($junk, $quote) = explode('"', $row['text'], 2);

		if (substr($quote, -1) == '"'){
	                $quote = substr($quote, 0, -1);
		}else{
			$quote = '"'.$quote;
		}

		if (!$link || !$quote) continue;

		$out = shell_exec("curl -sSI $link | grep -i Location");
		if (preg_match('!Location: (.*)!i', $out, $m)){
			$link = $m[1];
		}

		db_update('tweets', array(
			'is_processed'	=> 1,
			'quote'		=> trim($quote),
			'link'		=> trim($link),
		), "id=:id", array(
			'id' => $row['id']
		));

		echo '.';
	}

	echo "\n";
	echo "DONE\n";
