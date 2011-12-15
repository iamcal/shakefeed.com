<?php
	include('init.php');

	$days = array();

	$result = mysql_query("SELECT * FROM tweets ORDER BY date_create DESC LIMIT 100");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		if (!preg_match('!^http!', $row['text'])) continue;

		$d = date('F jS, Y', $row['date_create']);
		$days[$d][] = $row;
	}
?>
<html>
<head>
<title>ShakeFeed: >Best of MLKSHK</title>
</head>
<body>

<h1>ShakeFeed: Best of MLKSHK</h1>

<? foreach ($days as $d => $rows){ ?>

<h2><?=$d?></h2>

<ul>
<?
	foreach ($rows as $row){
		list($link) = explode(' ', $row['text']);
		list($junk, $quote) = explode('"', $row['text'], 2);
		$quote = substr($quote, 0, -1);
?>
	<li><a href="<?=$link?>"><?=HtmlSpecialChars($quote)?></a></li>
<? } ?>
</ul>

<? } ?>

<p>By <a href="http://www.iamcal.com/">Cal</a>. <a href="https://github.com/iamcal/shakefeed.com">Source</a></p>

</body>
</html>
