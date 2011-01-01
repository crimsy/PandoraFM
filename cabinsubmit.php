<?php
$logincookie = $_COOKIE['logincookie'];
$username = $logincookie[username];
$password = $logincookie[password];
$origpasshash = $password;
$servername = $_SERVER['SERVER_NAME'];
$nosubmit = $_GET[nosubmit];
$song = $_GET[song];
$artist = $_GET[artist];
$artist = rtrim($artist, " ");
$song = rtrim($song, " ");
date_default_timezone_set('UTC');
$counter = 1; #comment out if you want to disable.
$ver = '0.5';
$pluginid = 'pdg';
$length = rand(180, 340);
$attempt = 0;

if (!$_COOKIE['logincookie']) {
	die("If you log onto PandoraFM this song would be submitted to Last.FM.  You don't have a logon cookie from PandoraFM.");
}
include("inc/checklogin.inc");
include("inc/errors.inc");
include("inc/log.inc");
include("inc/lastfm.inc");
include("inc/db.inc");
require("inc/cache.inc");

#Setup db connection for counter stuff.
#$sqlinit = mysql_connect($dbserver,$dbuser,$dbpass);
#mysql_select_db('pandorafm',$sqlinit);

if ($username && $password && !stristr($username,"@")) {
	# Keep refreshing the cookie as long as songs keep being submitted.
	setcookie("logincookie[username]",$username,time()+60*60*24);
	setcookie("logincookie[password]",$password,time()+60*60*24);
} else {
	lfmlog("$timestamp,$username,$artist,$song,No login known,$attempt");
}

#include("inc/audiotrack.inc");

# Set this to 1 if you want failed submissions to be added to the database to be tried again.
# If set to 0 it will try it again right away and if that fails it won't try again.
#$cachesubmit = 1;
checkfortracks();

# For logging purposes even log of the track is played by PandoraFM Player via LastFM stations.  Add &nosubmit.
if (!$nosubmit) {
	submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt);
} else {
	$timestamp = date('Y-m-d H:i:s');
	lfmlog("$timestamp,$username,$artist,$song,Last.FM");
	$sqlinit = mysql_connect($dbserver,$dbuser,$dbpass);
	mysql_select_db('pandorafm',$sqlinit);
	mysql_query("UPDATE counter SET counter = counter+1",$sqlinit);
	mysql_close($sqlinit);
}

function submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt) {
	$attempt++;
	
	if ($attempt == 1) {
		global $dbserver,$dbuser,$dbpass,$dbname;
		$sqlinit = mysql_connect($dbserver,$dbuser,$dbpass);
		mysql_query("UPDATE counter SET counter = counter+1",$sqlinit);
		mysql_close($sqlinit);
	}
	
	if ($attempt !=1) { sleep(1); }
	$timestamp = date('Y-m-d H:i:s');
	$urltimestamp = urlencode($timestamp);
		if ($attempt >=3) {
		#echo "Retry limit exceeded trying to submit to last";
		echo'<script>parent.document.status.statustext.value="That song did not get added to your profile right away because last.fm was not answering.  Sorry.  I will try again.";</script>';
		cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);
		die();
	}
	
	$handshake = handshake($username,$password);
	if ($handshake[0]=='OK') {
		$passhash = $handshake[1];
		$submiturl = $handshake[2];
		$exec = submittrack($submiturl,$username,$passhash,$artist,$song,$length,$urltimestamp);
		$exec = ltrim($exec);
		$exec = rtrim($exec);
	
		if ($exec == 'OK') {
			echo "This song has been submitted to your Last.FM profile.";
			lfmlog("$timestamp,$username,$artist,$song,OK,$attempt");
		} else {
			#Errors trying to submit the track go here
		
			if ($exec == "BADAUTH") {
				#Bad username and/or password.  Time to kick you out of pandorafm!
				lfmlog("$timestamp,$username,$artist,$song,Invalid Login,$attempt");
			}
			
			if (strpos($exec,'invalid username')) {
				lfmlog("$timestamp,$username,$artist,$song,Invalid Login,$attempt");
			}

			if (strpos($exec,"ERROR")) {
				#echo 'That song did not get added to your profile right away because last.fm was not answering.  Sorry.  I will try again.';
				lfmlog("$timestamp,$username,$artist,$song,$exec: Cannot connect to submission url,$attempt");
				#if ($cachesubmit == 1){cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);}
				submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt);
			}

			if (strpos($exec,"Plugin bug")) {
				#echo 'That song did not get added to your profile right away because last.fm said there was an error.  Sorry.  I will try again.';
				lfmlog("$timestamp,$username,$artist,$song,Plugin bug message,$attempt");
				#if ($cachesubmit == 1){cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);}
				submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt);
			}
		
			if (strpos($exec,"Database too busy")) {
				echo 'That song did not get added to your profile right away because Last is having database problems.  Sorry.  I will try again.';
				lfmlog("$timestamp,$username,$artist,$song,Database Busy,$attempt");
				#if ($cachesubmit == 1){cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);}
				submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt);
			}
		
		}
		
	} else {
		#Errors trying initial handshake go here.
	
		if (strpos($handshake,"ERROR")) {
			#Could not connect to last.fm submission
			if (!$displayerror) {
				#echo 'That song did not get added to your profile right away because last.fm was not answering.  Sorry.  I will try again.';
				echo "<script>document.getElementById('output').innerHTML = 'That song did not get added to your profile right away because Last.FM was not answering.  Sorry.  I will try again.';</script>";
				$displayerror = "1";
				global $displayerror;
			}
			lfmlog("$timestamp,$username,$artist,$song,$handshake: Cannot connect. Try again.,$attempt");
			submitlast($username,$password,$artist,$song,$length,$timestamp,$attempt);
			#if ($cachesubmit == 1){cachesubmit($username,$origpasshash,$artist,$song,$length,$timestamp,$attempt);}
		}

	}
	#lfmlog("$timestamp,$username,$artist,$song,Handshake: $exec,$attempt");
}
?>
