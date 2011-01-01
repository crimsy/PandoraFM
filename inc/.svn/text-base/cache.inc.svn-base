<?php
#20060604 GEK Track caching and retrieval for when Last.FM submissions are down.
require('inc/errors.inc');
require('inc/db.inc');
$logincookie = $_COOKIE['logincookie'];
$username = $logincookie[username];
$password = $logincookie[password];
global $dbserver,$dbname,$dbuser,$dbpass;


function cachesubmit($username,$password,$artist,$song,$length,$timestamp,$attempts) {
	global $dbserver,$dbname,$dbuser,$dbpass,$username,$password;
	$sqlinit = mysql_connect($dbserver,$dbuser,$dbpass);
	mysql_select_db('pandorafm');
	
	$insert = mysql_query("INSERT INTO submissions (timestamp,username,artist,song,length,attempts) VALUES ('$timestamp','$username','$artist','$song','$length','$attempts')");
	#mysql_query("INSERT INTO submissions (timestamp,username,password,artist,song,length,attempts) VALUES ('test','test','test','test','test','test','1')");
	lfmlog("Track added to cache database");
	#lfmlog(mysql_errno($sqlinit) . ": " . mysql_error($sqlinit). "\n");
	#mysql_close($sqlinit);
}

function checkfortracks() {
		global $dbserver,$dbuser,$dbpass,$dbname,$username,$password;
		$sqlinit = mysql_connect($dbserver,$dbuser,$dbpass);
		mysql_select_db('pandorafm');
		$cacheresult = mysql_query("SELECT * FROM submissions WHERE username = '$username' ORDER BY attempts desc");
	
	if (mysql_num_rows($cacheresult) > 0) {			
		while ($track = mysql_fetch_array($cacheresult)) {
			#lfmlog("Submitting the cache to Last.FM");
			$username = $track[username];
			$timestamp = $track[timestamp];
			$artist = $track[artist];
			$song = $track[song];
			$length = $track[length];
			$attempts = $track[attempts];
			mysql_query("DELETE FROM submissions WHERE username = '$username' AND artist = '$artist' AND song = '$song'");
			submitcachetrack($username,$password,$artist,$song,$length,$timestamp,$attempts);
		}
	}
	#mysql_close($sqlinit);
}


function submitcachetrack($username,$password,$artist,$song,$length,$timestamp,$attempt) {
	$attempt++;
	$urltimestamp = urlencode($timestamp);
	$handshake = handshake($username,$password);

	if ($handshake[0]=='OK') {
		$passhash = $handshake[1];
		$submiturl = $handshake[2];
		
		$exec = submittrack($submiturl,$username,$passhash,$artist,$song,$length,$urltimestamp);
		#echo "Submitting with values: $submiturl,$username,$passhash,$artist,$song,$length,$urltimestamp";
		$exec = ltrim($exec);
		$exec = rtrim($exec);
		lfmlog("$timestamp,$username,$artist,$song,$exec,$attempt");
	
		if ($exec == 'OK') {
			#lfmlog("$timestamp,$username,$artist,$song,Submit: $exec,$attempt");
		} else {
			lfmlog("$timestamp,$username,$artist,$song,Submit: $exec,$attempt");
			cachesubmit($username,'',$artist,$song,$length,$timestamp,$attempt);
		}
		
	} else {
		#Errors trying initial handshake go here.
	
			cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);
		}

}

?>
