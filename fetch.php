<?php
	include('init.php');

	$json = file_get_contents('https://api.twitter.com/1/statuses/user_timeline.json?screen_name=best_of_mlkshk&count=200');
	$obj = JSON_decode($json, true);

	foreach ($obj as $row){

		db_insert_ignore('tweets', array(
			'id'		=> AddSlashes($row['id_str']),
			'date_create'	=> StrToTime($row['created_at']),
			'text'		=> AddSlashes($row['text']),
		));

		echo '.';
	}

	echo "DONE\n";
