<?php
$mode = $_GET[mode];

?>

<style type="text/css">
</style>
<table width="100%" height="78" border="0" cellpadding="0" cellspacing="0">
<?php if ($mode != "pandora") { ?>
	<tr bgcolor="#003399">
    <td width="8%" height="23"><a href="#" class="artisttextstyle" onclick="popup_artist_close()">[close]</a></td>
    <td width="27%">&nbsp;</td>
    <td width="65%"><span class="style2"><?php echo $_GET['artist']; ?></span></td> 
  </tr>
<?php } ?>
  <tr class="newfont">
    <td colspan="3"><?php 
$artist = $_GET['artist'];
	$artist = urlencode($artist);
	$artistinfo = "http://wsdev.audioscrobbler.com/ass/artistmetadata.php?artist=$artist";
	$init = curl_init($artistinfo);
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_CURLOPT_CRLF, TRUE);
	$output = curl_exec($init);
	$artistdata = split(chr(9),$output);
	#print_r($artistdata);

	$artistdata = str_replace('[','<',$artistdata);
	$artistdata = str_replace(']','>',$artistdata);

	
	$artist = $artistdata[0];
	$bio = $artistdata[2];
	$img = $artistdata[3];
	$bio = rtrim($bio,'"');
	$bio = ltrim($bio,'"');
	$bio = str_replace('""','"',$bio);
	#echo "<p>$artist</p>";
	
	if ($bio != "") {
		echo "<p class=newfont>$bio";
		if (substr($bio,-3) == "...") {
			$artistlink = urlencode($_GET[artist]);
			echo "<a class=artistlink target=_blank href=http://www.last.fm/music/$artistlink/+wiki>Click to read more</a>";
		}
	}
	echo "</p>";
	
	if ($mode == "pandora") {
	        include("genome.php");
		if ($bio == '') {
			echo "<p><img src=images/pandorafmlogo.jpg></p>";
			die();
		}
	}

	if ($img) {
		echo "<img src=$img>";
	}
?>
</span>
<br>
    <?php if ($mode != "pandora") { ?> <p align="center"><a href="#" class="style2" onclick="popup_artist_close()">[close]</a></p><?php } ?></td>
  </tr>
</table>
