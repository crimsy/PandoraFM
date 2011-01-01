<?php
# Used to diagnose problems with submissions and to verify if any submission problems are really that of last.fm and not pandorafm.

function lfmlog($logmsg) {
	$panel = $_COOKIE['panelmode'];
	global $username;
	if ($username) { $logmsg = $username . " " . $logmsg;}
	$logfile = "/home/gabek8/pandorafm.real-ity.com/log.txt";
	$log = fopen($logfile,"a+");
	$logmsg = $logmsg.",$panel,\n";
	fwrite($log, $logmsg);
	fclose($log);
}
?> 
