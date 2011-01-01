<?php
#20060722 GEK Creates m3u playlist for playing last stream in external player

$sessionname = $_GET[sessionname];
$streamurl = $_GET[streamurl];

$file = fopen("playlists/$sessionname.m3u","w+");
fwrite($file,$streamurl);
fclose($file);

header("LOCATION: playlists/$sessionname.m3u");
?>