<?php
#20060531 GEK PandoraFM Last.FM API submission functions

# step 1) handshake(username,password)  it returns the submission url[2] and challenge hash[1].

# step 2) function submittrack($challengeurl,$username,$passhash,$artist,$track,$length,$timestamp) using the url from step 1 and passhash.  All fields must be filled.

function handshake($username, $password) {
	$init = curl_init();
	curl_setopt($init, CURLOPT_URL, 'post.audioscrobbler.com');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($init, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($init, CURLOPT_TIMEOUT, 10);
	curl_setopt($init, CURLOPT_POSTFIELDS, "hs=true&p=1.1&c=pdg&v=3.0&u=$username");
	$challenge = curl_exec($init);
	
#echo curl_errno($init);
	if (curl_errno($init)) {
		$errno = curl_errno($init);
		$error = "HANDSHAKE ERROR $errno";
		return $error;
	}

	$intloc = strpos($challenge,'INTERVAL');
	$status = strpos($challenge,0,$intloc);
	
	if (strpos($challenge,'protocol_1.1')) {
		$challengemd5 = substr($challenge, 9,32);
		$challengeurl = substr($challenge, 42,37);
		$hash = md5($password.$challengemd5);
		$passhash[0] = 'OK';
		$passhash[1] = $hash;
		$passhash[2] = $challengeurl;
		return $passhash;
	}
	if (substr($challenge, 0, 7)=='BADUSER') {
		$passhash[0] = 'BADUSER';
	}
	
}

function submittrack($challengeurl,$username,$passhash,$artist,$track,$length,$timestamp) {
	$artist = urlencode($artist);
	$track = urlencode($track);
	$submitfields = "u=$username&s=$passhash&a[0]=$artist&t[0]=$track&b[0]=&m[0]=&l[0]=$length&i[0]=$timestamp";
	$submitinit = curl_init();
	curl_setopt($submitinit, CURLOPT_URL, $challengeurl);
	curl_setopt($submitinit, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($submitinit, CURLOPT_TIMEOUT, 10);
	curl_setopt($submitinit, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($submitinit, CURLOPT_POSTFIELDS, $submitfields);
	$submission = curl_exec($submitinit);
	#lfmlog($submission);
	if (curl_errno($submitinit)) {
		$errno = curl_errno($submitinit);
		$error = "SUBMISSION ERROR $errno";
		return $error;
	}
	$intloc = strpos($submission,'INTERVAL');
	$status = substr($submission,0,$intloc);
	return $status;
}
?>
