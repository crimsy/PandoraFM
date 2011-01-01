<?php
$stationsoffline = 1;

if ($stationsoffline == 1) {
	die("Sorry, the stations are currently having difficulty.  Please try again later.");
}
?>
<head>
<link href="charts.css" rel="stylesheet" type="text/css" />
</head>
<div align="center">Shared Stations
  <table align="center" width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
</div>
<tr>
<?php
require('inc/simplepie.inc');
$feed = new SimplePie();
$feed->feed_url('http://pandorafm.real-ity.com/pandorafmstations.xml');
$feed->cache_location('inc/cache');
$feed->init();

if ($feed->data) {
	$max = $feed->get_item_quantity(20);
	for ($x = 0; $x < $max; $x++) {
		if ($num == 2) { echo "</tr><tr>"; $num = 0;}
		$item = $feed->get_item($x);
		echo '<td width="1" class="leftendline1"></td>';
		echo '<td width=146 class=line1><a target=mainFrame href='.$item->get_permalink($x)."><strong>".$item->get_title($x)."</strong><br>".substr($item->get_description($x),0,60)."...</a></td>";
		#echo "<a target='mainFrame' href=".$item->get_permalink($x).">".$item->get_title($x)."</a><br>";
		echo '<td width="2%" class="rightendline1">&nbsp;</td>';
		$num++;
	}
}
?>
</tr></table>

<a href="http://pandorastations.crispynews.com" target=_blank><strong>
Top Stations list provided by: Pandora Stations</strong></a>


