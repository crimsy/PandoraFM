<?php
#20060626 GEK Functions to enable Last.FM track tagging in PandoraFM.
include("inc/log.inc");
#include("inc/checklogin.inc");
$username = $_GET['username'];
$password = $_GET['password'];

include("inc/errors.inc");
$tag = $_GET['tag'];
$artist = $_GET['artist'];
$track = $_GET['track'];
$auto = $_GET['auto'];

$session = tagsession($username,$password);
tagtrack($artist, $track, $session, $tag);

function tagsession ($username, $password) {
	$init = curl_init();
	curl_setopt($init, CURLOPT_URL, "http://ws.audioscrobbler.com/radio/handshake.php?version=1.1.4&platform=win32&username=$username&passwordmd5=$password&debug=0&partner=");
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	$tagsession = curl_exec($init);
	$tagsession = substr($tagsession,8,32);
	return $tagsession;
}

function tagtrack ($artist, $track, $session, $tag) {
	$artist = urlencode($artist);
	$track = urlencode($track);
	$tag = urlencode($tag);
	$init = curl_init();
	
	if ($_GET['track']) {
		$tagsyntax = "track=$track&artist=$artist";
		$log = "Artist: $artist  Track: $track  Session: $session  Tag: $tag";
	} else {
		$tagsyntax = "artist=$artist";
		$log = "Artist: $artist Session: $session  Tag: $tag Auto: $auto";
	}
	
	curl_setopt($init, CURLOPT_URL, 'http://ws.audioscrobbler.com/player/tag.php');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_POSTFIELDS, "s=$session&tag=$tag&$tagsyntax");
	$tagexec = curl_exec($init);
	lfmlog("$log - $tagexec");
	echo '<script>parent.status.statustext.value="You tagged this track."</script>';
}
?>
