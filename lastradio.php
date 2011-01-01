<?php
#20060626 GEK Functions to enable Last.FM track tagging in PandoraFM.
#20060704 GEK Edited function to allow streaming radio functionality from last.

include("inc/checklogin.inc");
include("inc/errors.inc");
include("inc/log.inc");

$tag = $_GET['tag'];
$artist = $_GET['artist'];
$track = $_GET['track'];


$session = getsession($username,$password);
$sessionname = $session['name'];
$streamurl = $session['stream'];
#echo "<script>";
#echo "sessionname = \"$sessionname\";";
#echo "streamurl = \"$streamurl\";";
#echo "</script>";

#tagtrack($artist, $track, $session, $tag);

function getsession ($username, $password) {
	$init = curl_init();
	curl_setopt($init, CURLOPT_URL, "http://ws.audioscrobbler.com/radio/handshake.php?version=1.1.4&platform=win32&username=$username&passwordmd5=$password&debug=0&partner=");
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	$sessionstring = curl_exec($init);
	$sessionname = substr($sessionstring,8,32);
	$stream = substr($sessionstring,52,77);
	$session['name'] = $sessionname;
	$session['stream'] = $stream;
	return $session;
}

function tagtrack ($artist, $track, $session, $tag) {
	$artist = urlencode($artist);
	$track = urlencode($track);
	$tag = urlencode($tag);
	$init = curl_init();
	curl_setopt($init, CURLOPT_URL, 'http://ws.audioscrobbler.com/player/tag.php');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_POSTFIELDS, "s=$session&tag=$tag&track=$track&artist=$artist");
	$tagexec = curl_exec($init);
	echo '<script>parent.status.statustext.value="You tagged this track."</script>';
	lfmlog("Artist: $artist  Track: $track  Session: $session  Tag: $tag");
}
?>
