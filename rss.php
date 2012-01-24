<?php
	include('init.php');

	$rows = array();

	$result = mysql_query("SELECT * FROM tweets ORDER BY date_create DESC LIMIT 100");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		if (!preg_match('!^http!', $row['text'])) continue;
		$rows[] = $row;
	}

	function d($ts){
		return gmdate('D, j M Y H:i:s', $ts).' +0000';
	}

	header("Content-type: text/xml; charset=utf-8");

	echo '<'.'?xml version="1.0" encoding="UTF-8"?'.">\n";
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	>
<channel>
	<title>ShakeFeed</title>
	<atom:link href="http://shakefeed.com/rss/" rel="self" type="application/rss+xml" />
	<link>http://shakefeed.com/</link>
	<description>Best of MLKSHK, in a feed</description>
	<lastBuildDate><?=d(time())?></lastBuildDate>
	<language>en</language> 
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>http://shakefeed.com/</generator>
<?
	foreach ($rows as $row){

		$img = null;
		if (preg_match('!mlkshk.com/p/(.+)$!', $row['link'], $m)){
			$img = "http://mlkshk.com/r/$m[1]";
		}
?>
	<item>
		<title><?=HtmlSpecialChars($row['quote'])?></title>
		<link><?=$row['link']?></link>
		<pubDate><?=d($row['date_create'])?></pubDate>
		<guid isPermaLink="false">/feed/<?=$row['id']?>/</guid>
		<description><?=HtmlSpecialChars($row['quote'])?></description>
<? if ($img){ ?>
		<enclosure url="<?=$img?>" type="image/jpeg"/>
<? } ?>
	</item>
<?
	}
?>
</channel>
</rss>
