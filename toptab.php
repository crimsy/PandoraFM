<?php
include("inc/errors.inc");
include("inc/checklogin.inc");
?><head>
<meta http-equiv="refresh" content="180">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 </head><body>


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <?php
#$lastxmlurl = "http://ws.audioscrobbler.com/1.0/user/$username/weeklyartistchart.xml";
$lastxmlurl = "http://ws.audioscrobbler.com/1.0/user/$username/topartists.xml";

$init = curl_init();
curl_setopt($init, CURLOPT_URL, $lastxmlurl);
curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
$topartists = curl_exec($init);

if ($topartists == 'No user exists with this name.') {
	echo '<script>top.location.href="http://pandorafm.real-ity.com/index.php?notvalid=1"</script>';
	die();
}
if (!simplexml_load_string($topartists)) { die("Sorry, there's an error getting your tracks from Last.FM");}
$entries = simplexml_load_string($topartists);
if (count($entries) == 0) {die("Sorry, Last says you don't have any top tracks.  There may be a problem somewhere."); }
$c = 0;
foreach ($entries->artist as $artistname) {
	if ($c == 2) { echo "</tr><tr>"; $c = 0;}
	if ($i == 10) {break;}
	$num = $i + 1;;
	#echo '<tr><td width="8" class="leftendline1">&nbsp;</td>';
	#if ($c == 4) { echo "</tr><tr>\n"; $c = 0; }

	$artistname = $artistname->name;
	$artistlink = urlencode($artistname);
	#$artistname = utf8_decode($artistname);
	$track = utf8_decode($track);
	#echo '<td width=1% class=line1>'."<a href=# onClick=\"go('pandora','$artistname')\"".'<img border=0 TITLE="header=[Pandora] body=[<br>Create a new Pandora radio station based on this artist.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/pandoraicon.gif /></a></td>';
	#echo "<td width=48% class=line1>".'<a href=# TITLE="header=[Actions] body=[Tag, Love, Ban or Reccomend this track] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]">'."$artistname</a></td>";
	echo "<td width=48% class=line1>"."$artistname</a></td>";
	#echo "<a href=# onClick=\"go('pandora','$artistname')\"".'<img border=0 TITLE="header=[Pandora] body=[Create a new Pandora radio station based on this artist.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/pandoraicon.gif /></a>';
	echo '<td width=1% class=line1>'."<a href=# onClick=\"go('pandora','$artistname')\"".'<img border=0 TITLE="header=[Pandora] body=[Create a new Pandora radio station based on this artist.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/pandoraicon.gif /></a></td>';
	echo '<td width=1% class=line1>'."<a href=# onClick=\"go('last','$artistname')\"".'<img border=0 TITLE="header=[Last.FM] body=[Create a new Last.FM radio station based on this artist.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/lasticon.gif /></a></td>';
	echo '<td width="1%" class="line1end">&nbsp;</td>';
	$c++;
	$i++;
}
curl_close($init);
?></table>
</body>
