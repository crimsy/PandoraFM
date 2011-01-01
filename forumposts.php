<?php
require('inc/simplepie.inc');
$feed = new SimplePie();
$feed->feed_url('http://ws.audioscrobbler.com/1.0/forum/33812/posts.rss');
$feed->cache_location('inc/cache');
$feed->init();

if ($feed->data) {
	 $max = $feed->get_item_quantity(5);
	for ($x = 0; $x < $max; $x++) {
		$item = $feed->get_item($x);
		echo "<a class=underline target=_blank href=".$item->get_permalink($x).">".$item->get_title($x)."</a><br>";
	}
}
?>
