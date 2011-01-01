<?php
#20060704 GEK Parse and display Last.FMs streaming radio status

	include("inc/checklogin.inc");
	include("lastradio.php");
	#include('parseini.php');

$init = curl_init("http://ws.audioscrobbler.com/radio/np.php?session=$sessionname");
curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($init, CURLOPT_CURLOPT_CRLF, TRUE);
$ini = curl_exec($init);
$configlines = split(chr(10),$ini);
echo '<script type="text/javascript">';
foreach ($configlines as $configline) {
	$line = split('=',$configline,2);
	$$line[0] = $line[1];
	
	$slashedvar = addslashes($line[1]);
	if ($line[0] != '') { echo "$line[0] = \"$slashedvar\";\n"; }
	if ($streaming=='false') {echo "</script>"; die();}
}
echo '</script>';
if ($error) {  die('No Radio Currently Playing');}
?>
