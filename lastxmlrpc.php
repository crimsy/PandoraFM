<?php
#20060721 GEK xmlrpc client interface to actions on Last.FM
#20060930 GEK add tagging functions
##Apply tags to track: user,nonce,auth,artist,track,tag array,mode

include("inc/checklogin.inc");
include("inc/errors.inc");
include("inc/log.inc");
include("inc/xmlrpc.inc");
include("inc/utils.inc");

#$pass = $_GET[pass];
$command = $_GET[command];
$challengestring = md5($password."12345678");
$artist = $_GET[artist];
$track = $_GET[track];
if ($_GET['trackurl']) { $trackurl = $_GET['trackurl']; }
#$username = $_GET[username];
$recipient = $_GET[recipient];
$station = $_GET['station'];

if ($trackurl != '') {$message = "Can be found at $trackurl .  $message";}
if ($station != '' && $trackurl != '') {
	$message = "Song can be found at $trackurl.  This recommendation was sent using PandoraFM when listening to their station, $station.  Visit http://pandorafm.real-ity.com today to create your own custom radio stations with Pandora.com and Last.FM!";
} else {
	$message = 'This recommendation was sent using PandoraFM.  Visit http://pandorafm.real-ity.com today to create your own custom radio stations with Pandora.com and Last.FM!';
}

if ($_GET['command'] == "recommendTrack" && stristr($_GET['recipient'],"@")) {
	emailRecommendation($artist,$track,$recipient,$username,$trackurl,$station);
	lfmlog("Sent email recommendation from $username to $recipient");
	die('Sent email recommendation.');
}



lfmlog("$username $command $recipient $artist $track $challengestring");

$testrpcval = new xmlrpcval();

$xmlrpc_message = new xmlrpcmsg($command,$testrpcval);
$xmlrpc_message->addParam(new xmlrpcval($username));
$xmlrpc_message->addParam(new xmlrpcval("12345678"));
$xmlrpc_message->addParam(new xmlrpcval($challengestring));

# the xmlrpc params have to be in order!
switch($command) {
	case "recommendTrack":
		$xmlrpc_message->addParam(new xmlrpcval($_GET[artist]));
		$xmlrpc_message->addParam(new xmlrpcval($_GET[track]));
		$xmlrpc_message->addParam(new xmlrpcval($_GET[recipient]));
		$xmlrpc_message->addParam(new xmlrpcval($message));
	break;
	
	case "tagTrack":
		$xmlrpc_message->addParam(new xmlrpcval($_GET[artist]));
		$xmlrpc_message->addParam(new xmlrpcval($_GET[track]));
		$tagarray = array($_GET['tag']);
		$xmlrpc_message->addParam(php_xmlrpc_encode($tagarray));
		$xmlrpc_message->addParam(new xmlrpcval("track"));
	break;
	
	case "tagArtist":
		$xmlrpc_message->addParam(new xmlrpcval($_GET[artist]));
		$tagarray = array($_GET['tag']);
		$xmlrpc_message->addParam(php_xmlrpc_encode($tagarray));
		$xmlrpc_message->addParam(new xmlrpcval("track"));
		
	break;
	
	case "loveTrack":
		$xmlrpc_message->addParam(new xmlrpcval($_GET[artist]));
		$xmlrpc_message->addParam(new xmlrpcval($_GET[track]));
	break;
	
	case "banTrack":
		$xmlrpc_message->addParam(new xmlrpcval($_GET[artist]));
		$xmlrpc_message->addParam(new xmlrpcval($_GET[track]));
	break;
}


$client = new xmlrpc_client("http://ws.audioscrobbler.com/1.0/rw/xmlrpc.php");

$response = $client->send($xmlrpc_message);

$reply = $response->serialize();
#lfmlog($xmlrpc_message->serialize());
lfmlog($reply);
#echo $reply;
echo "Done!";
?>
