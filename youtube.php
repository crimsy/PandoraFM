<?php
#$search = $_GET[search];

include("inc/errors.inc");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /></head>

<table width="100%" border="0">
<tr>
  <?php
  $search = urlencode($search);
$apiurl = "http://www.youtube.com/api2_rest?method=youtube.videos.list_by_tag&tag=$search&dev_id=NADJNk-tYVE";
#echo $apiurl;
$init = curl_init();
curl_setopt($init, CURLOPT_URL, $apiurl);
curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
$videos = curl_exec($init);

#echo $videos;

#$entries = simplexml_load_string($videos);
$entries = new SimpleXMLElement($videos);
#if ($entries['status'][0] != "ok") { die($entries['status']['description']); }

$entries = $entries->video_list->video;
#if (count($entries) == 0) {#die("Sorry, no videos."); }
#print_r($entries);

#print_r($entries);

#die();
$c = 0;
foreach ($entries as $videoentry) {
	
		#if (stristr($videoentry->description,$search)) {
		if ($videoentry->length_seconds > 90 && $videoentry->rating_avg > 2 && $videoentry->view_count > 30) {
		if ($i == 10) {break;}
		if ($c == 4) { echo "</tr><tr>\n"; $c = 0; }

	#print_r($videoentry);

		#$artistname = $artistname->name;
		#$artistlink = urlencode($artistname);
		#$artistname = utf8_decode($artistname);
		$url = $videoentry->url;
		$img = $videoentry->thumbnail_url;
		$title = $videoentry->title;
	
		echo "<td><a TITLE='header=[Now Playing] body=[$title] delay=[0] fade=[off] fadespeed=[0.04] cssheader=[popupheader] cssbody=[popupbody]' class=titletext target=_blank href=$url><img border=0 width=50 height=50 src=$img></a></td>";
		$c++;
		$i++;
	}
}
if ($i == 0) { echo "Sorry, no videos :("; }
curl_close($init);
?></tr></table>
