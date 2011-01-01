<?php
#20050817 Additional PHP functions to make life easier

function taglisturl() {
	global $username;
	$lasttagurl = "http://ws.audioscrobbler.com/1.0/user/$username/tags.xml";
	$taginit = curl_init();
	curl_setopt($taginit, CURLOPT_URL, $lasttagurl);
	curl_setopt($taginit, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($taginit, CURLOPT_FRESH_CONNECT, TRUE);
	$toptags = curl_exec($taginit);

	$tags = simplexml_load_string($toptags);
	foreach ($tags->tag as $tag) {
		$tagname = $tag->name;
		if (strlen($string) > 20) { $tagname = substr($tagname,0,20) . "..."; }
		$tagvalue = urlencode($tag->name);
		#echo "<option value='lastfm://usertags/$username/$tagvalue'>$tagname</option>";
		$list[$x] = $tagname;
		$x++;
		
	}
	curl_close($taginit);
	if ($_COOKIE['sorttags'] == "Yes") {sort($list);}
	
	while ($i <= count($list)) {
		$tagname = $list[$i];
		echo "<option value='lastfm://usertags/$username/$tagvalue'>$tagname</option>";
		$i++;
	}
	
}

function taglist() {
	global $username;
	$lasttagurl = "http://ws.audioscrobbler.com/1.0/user/$username/tags.xml";
	$taginit = curl_init();
	curl_setopt($taginit, CURLOPT_URL, $lasttagurl);
	curl_setopt($taginit, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($taginit, CURLOPT_FRESH_CONNECT, TRUE);
	$toptags = curl_exec($taginit);

	$tags = simplexml_load_string($toptags);
	foreach ($tags->tag as $tag) {
		$tagname = $tag->name;
		if (strlen($string) > 20) { $tagname = substr($tagname,0,20) . "..."; }
		$tagvalue = urlencode($tag->name);
		#echo "<option value='$tagname'>$tagname</option>";
		$list[$x] = $tagname;
		$x++;
	}
	curl_close($taginit);
	if ($_COOKIE['sorttags'] == "Yes") {sort($list);}
	
	while ($i <= count($list)) {
		$tagname = $list[$i];
		echo "<option value='$tagname'>$tagname</option>";
		$i++;
	}
}

function stationlist() {
	$pandorauser = $_COOKIE['pandorauser'];
	$stationurl = "http://feeds.pandora.com/feeds/people/$pandorauser/stations.xml";
	$stationsinit = curl_init();
	curl_setopt($stationsinit, CURLOPT_URL, $stationurl);
	curl_setopt($stationsinit, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($stationsinit, CURLOPT_FRESH_CONNECT, TRUE);
	$output = curl_exec($stationsinit);

	$stations = simplexml_load_string($output);

	#print_r($stations);

	foreach ($stations->channel->item as $station) {
		#print_r($station);
		$stationname = $station->title;
		if (substr($stationname, -6) == " Radio") { $stationname = substr($stationname,0,-6); }
		#if (strlen($string) > 20) { $tagname = substr($tagname,0,20) . "..."; }
		#$tagvalue = urlencode($tag->name);
		#echo $stationname;
		echo "<option value='$stationname'>$stationname</option>";
	}
	curl_close($stationsinit);
}

function emailRecommendation($artist,$track,$recipient,$username,$trackurl,$station) {
	$artistencode = urlencode($artist);
	$trackencode = urlencode($track);
	$url = "http://www.last.fm/music/$artistencode/_/$trackencode";
	$subject = "A song recommendation for you from $username at PandoraFM";
	$usernamelink = "$username http://www.last.fm/user/$username/";
	
	$artistinfo = "http://wsdev.audioscrobbler.com/ass/artistmetadata.php?artist=$artistencode";
	$init = curl_init($artistinfo);
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_CURLOPT_CRLF, TRUE);
	$output = curl_exec($init);
	$artistdata = split(chr(9),$output);

	$artistdata = str_replace('[','<',$artistdata);
	$artistdata = str_replace(']','>',$artistdata);
	$bio = $artistdata[2];
	$bio = rtrim($bio,'"');
	$bio = ltrim($bio,'"');
	$bio = str_replace('""','"',$bio);
	
	#Grab template and replace variables
	$template = file_get_contents("inc/emailtemplate.txt");
	$message = str_replace("%username%",$usernamelink,$template);
	$message = str_replace("%url%",$url,$message);
	$message = str_replace("%artist%",$artist,$message);
	$message = str_replace("%track%",$track,$message);
	$message = str_replace("%station%",$station,$message);
	
	#Add Pandora backstage link if applicable
	if (strstr($trackurl, "http") && $station != '') {
		$message = str_replace("%backstageurl%",$trackurl,$message);
		$message = str_replace("%station%",$station,$message);
	} else {
		$message = str_replace("%backstageurl%",'',$message);
		$message = str_replace("while listening to %station%",'',$message);
	}
	
	#Add Last.FM artist bio
	if ($bio != "") {
		$message = str_replace("%artistinfo%",strip_tags($bio),$message);
	} else {
		$message = str_replace("%artistinfo%",'',$message);
	}
	
	mail($recipient,$subject,$message,'From: PandoraFM Recommendation <pandorafm@real-ity.com>');
}

?>