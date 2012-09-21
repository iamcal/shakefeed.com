<?php
	include('init.php');

	$days = array();

	$result = mysql_query("SELECT * FROM tweets WHERE is_processed=1 ORDER BY date_create DESC LIMIT 100");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		$d = date('F jS, Y', $row['date_create']);
		$days[$d][] = $row;
	}

	header("Content-type: text/html; charset=utf-8");
?>
<html>
<head>
<title>ShakeFeed: Best of MLKSHK</title>
<link rel="alternate" type="application/rss+xml" title="ShakeFeed" href="/rss/">
</head>
<body>

<h1>ShakeFeed: Best of MLKSHK</h1>

<? foreach ($days as $d => $rows){ ?>

<h2><?=$d?></h2>

<ul>
<?
	foreach ($rows as $row){
?>
	<li><a href="<?=$row['link']?>"><?=$row['quote']?></a></li>
<? } ?>
</ul>

<? } ?>

<p>By <a href="http://www.iamcal.com/">Cal</a>. <a href="https://github.com/iamcal/shakefeed.com">Source</a></p>

</body>
</html>
