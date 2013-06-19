<?php
	include('init.php');
	include('lib_oauth.php');

	echo "Fetching new items: ";

	$json = oauth_request($keys, 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=best_of_mlkshk&count=200');
	$obj = JSON_decode($json, true);

	foreach ($obj as $row){

		db_insert_ignore('tweets', array(
			'id'		=> AddSlashes($row['id_str']),
			'date_create'	=> StrToTime($row['created_at']),
			'text'		=> AddSlashes($row['text']),
		));

		echo '.';
	}

	echo "\n";

	echo "Processing: ";

	$result = mysql_query("SELECT * FROM tweets WHERE is_processed=0");
	while ($row = mysql_fetch_array($result)){

		if (!preg_match('!^http!', $row['text'])) continue;

		list($link) = explode(' ', $row['text']);
                list($junk, $quote) = explode('"', $row['text'], 2);
                $quote = substr($quote, 0, -1);

		if (!$link || !$quote) continue;

		$out = shell_exec("curl -sSI $link | grep Location");
		if (preg_match('!Location: (.*)!', $out, $m)){
			$link = $m[1];
		}

		db_update('tweets', array(
			'is_processed'	=> 1,
			'quote'		=> AddSlashes(trim($quote)),
			'link'		=> AddSlashes(trim($link)),
		), "id='$row[id]'");

		echo '.';
	}

	echo "\n";
	echo "DONE\n";
