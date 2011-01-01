<?php
$artist = urlencode($_GET['artist']);
include("inc/errors.inc");
include("inc/checklogin.inc");
?><head>
<meta http-equiv="refresh" content="180">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 

<link href="charts.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
  <?php
$lastxmlurl = "http://ws.audioscrobbler.com/1.0/artist/$artist/similar.xml";

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
if (count($entries) == 0) {die("Sorry, no similar artists can be found.");}
$c = 0;
foreach ($entries->artist as $artistname) {
	if ($i == 20) {break;}
	$num = $i + 1;;
	echo '<tr><td width="8" class="leftendline1">'.$num.'</td>';
	#if ($c == 4) { echo "</tr><tr>\n"; $c = 0; }

	$artistname = $artistname->name;
	$artistlink = urlencode($artistname);
	$artistname = utf8_decode($artistname);
	
	echo '<td width=146 class=line1><img TITLE="header=[Pandora] body=[<br>Create a new Pandora radio station based on this artist.] delay=[1500] fade=[on] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/pandoralogo.gif></td>';
	echo "<td width=97% class=line1>".'<a href=# TITLE="header=[Actions] body=[<br>Tag, Love, Ban or Reccomend this track] delay=[1500] fade=[on] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]">'."$artistname</a></td>";
	echo '<td width=146 class=line1><img TITLE="header=[Last.FM] body=[<br>Create a new Last.FM radio station based on this artist.] delay=[1500] fade=[on] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" src=images/last_fm_logo.gif /></td>';
	echo '<td width="2%" class="rightendline1">&nbsp;</td></tr>';
	$c++;
	$i++;
}
curl_close($init);
?></table></body>
