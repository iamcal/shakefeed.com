<?php
	include(__DIR__.'/../include/init.php');
	include(__DIR__.'/../include/lib_oauth.php');

	echo "Fetching new items: ";

	$json = oauth_request($keys, 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=best_of_mltshp&count=200');
	$obj = JSON_decode($json, true);

	if (!is_array($obj)) die("no tweets found: {$json}");

	foreach ($obj as $row){

		db_insert_ignore('tweets', array(
			'id'		=> $row['id_str'],
			'date_create'	=> StrToTime($row['created_at']),
			'text'		=> $row['text'],
		));

		echo '.';
	}

	echo "\n";

	echo "Processing: ";

	$ret = db_fetch("SELECT * FROM tweets WHERE is_processed=0");
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
