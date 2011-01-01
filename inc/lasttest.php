<?php
$fptestone = @fsockopen("post.audioscrobbler.com", 80, $errnoone, $errstr, 5);
#$fptesttwo = @fsockopen("62.216.251.205", 80, $errnotwo, $errstrtwo, 5);
$errnototal = $errnoone + $errnotwo;

if ($errnototal == 0) {
	$status = "Submissions seem to be OK.";
	} else {
	$status = "<b>WARNING:</b>Last.FM submissions look like they may be down or inconsistent.  If so, your profile will not update.  This is a Last.FM issue.";
	echo "$status ";
}
@fclose($fptestone);
@fclose($fptesttwo);
?> 
