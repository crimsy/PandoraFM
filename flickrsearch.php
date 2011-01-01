<?php
#20060809 GEK Uses flickr API to search for images
#$search = $_GET[search];

$url = "http://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=c655bf61707402660fad502a0705959b&privacy_filter=1&per_page=20&tags=$search,concert&tag_mode=all";
$init = curl_init($url);
curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($init, CURLOPT_CURLOPT_CRLF, TRUE);
$exec = curl_exec($init);

$entries = new SimpleXMLElement($exec);
$photos = $entries->photos->photo;

#if (count($photos) == 0) {die("Sorry, no photos."); }
?>
<table width="100%" border="0">
<tr>
<?php
$c = 0;
$i = 0;
foreach ($photos as $photo) {
        if ($i == 10) {break;}
        if ($c == 4) { echo "</tr><tr>\n"; $c = 0; }
	$server = $photo['server'];
	$name = $photo['title'];
	$origname = $name;
	$name = str_ireplace(".jpg","",$name);
	if (substr($name,0,3) == "DSC" || substr($name,0,3) == "IMG") { $name = ''; }
	$id = $photo['id'];
	$secret = $photo['secret'];
	$smallimgurl = "http://static.flickr.com/$server/$id"."_$secret"."_s.jpg";
	$imgurl = "http://static.flickr.com/$server/$id"."_$secret".".jpg";
	echo "<td><a TITLE='header=[Now Playing] body=[$origname] delay=[0] fade=[off] fadespeed=[0.04] cssheader=[popupheader] cssbody=[popupbody]' class=titletext target=_blank href=$imgurl><img border=0 height=50 width=50 src=$smallimgurl></a></td>";
	$c++; $i++;
}

if ($i == 0) {echo "Sorry, no photos :(";}
?></tr></table>
