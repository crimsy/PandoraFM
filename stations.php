<?php
$pandorauser = $_COOKIE['pandorauser'];
$stationurl = "http://feeds.pandora.com/feeds/people/$pandorauser/stations.xml";
$stationsinit = curl_init();
curl_setopt($stationsinit, CURLOPT_URL, $stationurl);
curl_setopt($stationsinit, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($stationsinit, CURLOPT_FRESH_CONNECT, TRUE);
$output = curl_exec($stationsinit);

$stations = simplexml_load_string($output);

#print_r($stations);

foreach ($stations->channel->item as $station) {
	#print_r($station);
	$stationname = $station->title;
	#if (strlen($string) > 20) { $tagname = substr($tagname,0,20) . "..."; }
	#$tagvalue = urlencode($tag->name);
	#$staionname = substr_replace($stationname, ' Radio', '', -5,5);
	echo substr($stationname, -6); 
	if (substr($stationname, -6) == " Radio") { $stationname = substr($stationname,0,-6); }
	echo "$stationname <br>\n";
	#echo "<option value='$stationname'>$stationname</option>";
}
curl_close($stationsinit);
?>
