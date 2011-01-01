<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
}
-->
</style><p><strong>Help</strong> - <a class=underline target=_blank href="helptab.php">Click here to view in a full window.</a></p>
<p><blink><?php 
include("inc/errors.inc");
include("inc/lasttest.php");
?>
</blink>
</p>
<p>Contents:</p>
<p>* Your username and password <br>
  * Your information and how settings are saved for you <br>
  * Last.FM submissions, songs not showing up, and Last.FM being down. <br>
  * Songs cached in PandoraFM (updated in real time if logged in here) <br>
* Options<br />
* Shared Stations <br>
* Misc questions </p>
<p>Q: <strong>Do you save my username, password, or listening habits?</strong><br />
A: No. The only slight exception is with track caching when Last.FM's submissions are down. The track you tried to submit, your username, and the time is saved to be sent later.  Your password is never saved. All passwords are always encrypted using Last.FM's hashing requirements for all transmissions. There is no running database of what anyone is listening to. We do count the total number of tracks that run through the system, though. Just for people who are curious. </p>
<p>Q: <strong>When I switch computers I lose all my PandoraFM settings like time until submission and tag options.</strong><br />
A: Yes.  All your settings are stored in local cookies on the computer you set them on to continue with the idea that PandoraFM will not store any of your information except what was listed above in that single circumstance of caching. We have been asked to save your preferences on the server side, but I feel that your information should not be stored. </p>
<p>Q: <strong>Some tracks PandoraFM said were submitted to Last.FM aren't showing up in my profile. What's wrong?</strong><br />
A: More often than not this is caused by Last.FM's submission server(s) to be down. So during this time Last.FM is refusing new songs being added to your profile PandoraFM is saving them in the background and the will get submitted when things get turned back on over on Last's side.</p>
<p>Q: <strong>How do I know for sure this is the issue?</strong><br />
A: Look at the top of this page. If Last is having a problem a message will be printed letting you know. </p>
<p>
<?php if ($_COOKIE['username']) {
	include("inc/db.inc");
	include("inc/checklogin.inc");
	#echo $username;
	$sqlint = mysql_connect($dbserver,$dbuser,$dbpass);
	mysql_select_db($dbname);
	$query = mysql_query("SELECT * from submissions WHERE username = '$username' ORDER BY attempts desc");
	if (@mysql_num_rows($query) != 0) {
		echo "And for convinience the following are the songs that you have cached with PandoraFM:</p>";
		while ($row = mysql_fetch_array($query)) {
			echo $row[artist]. " - ".$row[song] . " has been tried ".$row[attempts]." time(s).<br>";
		}
	} else {
		echo "At the moment, though, you have no tracks cached with PandoraFM.";
	}
}
?>

<p>Q: <strong>PandoraFM has stopped recognizing the songs Pandora is playing.  What can I do?</strong><br />
A: This has been reported, but never replicated in testing on the development side.  Unfortunately all you can do if you run into this issue is to restart PandoraFM.  You will notice the title of the window or active tab stop changing if this were to happen, so it should be quite obvious.  As the flash component that makes the calls to PandoraFM is created by Pandora.com themselves, the developer of PandoraFM is unable to troubleshoot and continue development on it to remedy it.</p>
<p>Q: <strong>How can I get additional functionality with this app and Pandora in general?.  I want more!</strong><br />
A: Make sure you're running <a class=underline href="http://www.getfirefox.com" target="_blank">FireFox</a> and install <a class=underline href="http://www.foxytunes.com/" target="_blank">FoxyTunes</a>.  It adds the currently playing song in your FireFox toolbar, lets you search for lyrics, purchase tracks and albums, additional band information, and more.</p>
<p>Q:<strong> I typed in my username and password fine, and a bunch of songs submitted without a problem.  But then PandoraFM kicks me out saying I logged in incorrectly.</strong><br />
A: Often times when Last.FM is having database issues, or is under heavy load they will report back "invalid logon" when trying to submit a track.  Unfortunately we just have to roll with what they say and have you log back in.</p>
Q: <strong>What do the options under the options tag mean?</strong><br />
A: Timeout until a track submits: The amount of seconds until the song you're listening to in Pandora (not Last.FM radio) is submitted to your profile.  Last.FM radio does not follow this rule, as it submits on it's own.<br>
Timeout until a track is auto-tagged: The amount of seconds until the song you're listened to gets tagged with the name you selected in the options for "Autotag as".<br>
Quicktag: Lets you turn on or off the button in the PandoraFM interface that lets you tag a song with one click.  You select the name of the tag with the "QuickTag" selector in the options.<br>
Tag "Loved" tracks as "Loved": Adds all tracks you clicked "love" on to a tag set in your Last.FM profile called "Loved".  This allows you to go back to see what songs you loved, or any other functions you can do with a tag set.  Otherwise "Loved" songs cannot be viewed with the Last.FM website. <br>
<br />
Q: <strong>How do the shared stations work?  How do I get my station listed for others to hear?</strong><br />
A: Submit your stations to <strong><a class=underline href="http://pandorastations.crispynews.com" target="_blank">Pandora Stations</a></strong> and once it's in the top listings yours too will show up!
<p>Q: <strong>Where can I discuss ideas, bugs, or just have discussion with other PandoraFM users?</strong><br />
  A: Join the <a class=underline href="http://www.last.fm/group/PandoraFM+Users/forum/33812" target="_blank">PandoraFM group</a> on Last.FM.  Here are some of the recent discussions taking place.<br>
  <?php include('forumposts.php'); ?>
</p>
