<?php
	#header( "Content-type: application/xml" );
	##echo '<?xml version="1.0" encoding="UTF-8"?';
	$url = $_GET['url'];
	$init = curl_init($url);
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_CURLOPT_CRLF, TRUE);
	$ini = curl_exec($init);
#	echo $ini;



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
echo $ini;

if (strpos($ini,"FAILED")) {
	if ($error == 2) {$errmsg = 'Were you trying to access a station that only subscribers can access?  Like personal, loved or usertag radio?';}
	if ($error == 1) {$errmsg = 'Were you tring to access a tag radio station with not enough music to listen to?  Or maybe you haven\'t started the radio yet?';}
	if ($error != 2 && $error != 1) {$errormsg = 'Last.FM radio says there is a problem.  But I don\'t know what it is.  Try it again.  Or try something else.';}
	echo "<script>showerror(\"$errmsg\")</script>";
}

?>
