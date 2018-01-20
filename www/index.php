<?php
	include('../include/init.php');

	$days = array();

	$limit = intval(idx($_GET, 'limit', 0));
	$limit = min(10000, max(100, $limit));

	$ret = db_fetch("SELECT * FROM tweets WHERE is_processed=1 ORDER BY date_create DESC LIMIT $limit");
	foreach ($ret['rows'] as $row){

		$d = date('F jS, Y', $row['date_create']);
		$days[$d][] = $row;
	}

	header("Content-type: text/html; charset=utf-8");
?>
<html>
<head>
<title>ShakeFeed: Best of MLTSHP</title>
<link rel="alternate" type="application/rss+xml" title="ShakeFeed" href="/rss/">
</head>
<body>

<h1>ShakeFeed: Best of <s style="color: #666">MLKSHK</s> MLTSHP</h1>

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
