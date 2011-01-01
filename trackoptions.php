<?php
include("inc/errors.inc");
include("inc/checklogin.inc");
$mode = $_GET[mode];
if ($_GET[artist] && $_GET[track]) {
	$artist = $_GET[artist];
	$track = $_GET[track];
	echo "<script> theartist = '$artist'; thetrack = '$track';</script>";
} else {
	echo "<script> theartist = artist; thetrack = track</script>";
}
?>

<script src="playerfunctions.php"></script>
<style type="text/css">
<!--
.style23 {font-size: 12px}
.style24 {font-size: 10px}

-->
</style>
<script>
	document.getElementById('voteheader').innerHTML = "What would you like to do with " + theartist + " - " + thetrack + "?<br>";
</script>
<div align="center" id="voteheader"></div>
<form id="voteform" name="voteform" method="post" action="">
  <table <?php if ($mode == "pandora") { echo 'width=85%"'; } else { echo 'width=200"';}?> border="0" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>>
    <tr>
      <td width="155" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><a href=# onClick=loveban("loveTrack")><img src="/images/love.gif" width="30" height="30" /></a><br />
      Love</td>
      <td width="147" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><a href=# onClick=loveban("banTrack")><img src="/images/ban2.gif" width="30" height="30" /></a><br />
      Ban</td>
      <td width="97" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><div title="popupfield" id="popupfield">[<a href=# onClick=show_popup_field()>Recommend Track</a>]</div> </td>
    </tr>
    <tr>
      <td colspan="3" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><select name="tag" class="tagdropdown" id="tag" onchange="settag('dropdown')">
        <option value="0">Tag this song</option>
        
        <?php
			#$username = $_GET['username'];
			$lasttagurl = "http://ws.audioscrobbler.com/1.0/user/$username/tags.xml";
			#lfmlog("Getting XML for $lasttagurl \n");
			$taginit = curl_init();
			curl_setopt($taginit, CURLOPT_URL, $lasttagurl);
			curl_setopt($taginit, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($taginit, CURLOPT_FRESH_CONNECT, TRUE);
			$toptags = curl_exec($taginit);
			
			$tags = simplexml_load_string($toptags);
			foreach ($tags->tag as $tag) {
				$tagname = $tag->name;
				$tagvalue = urlencode($tag->name);
				echo "<option value=$tagvalue>$tagname</option>";
			}
			curl_close($taginit);
		?>
      </select><?php if ($mode != "pandora") {echo "</td></tr><tr><td colspan=3 align=center>";}?>
	  <input onClick="voteform.newtag.value=''" class="tagdropdown" name="newtag" type="text" id="newtag" value="create new tag" size="20" />
      <input class="tagdropdown" onClick="settag('newtag')" name="Tag" type="button" id="Tag" value="New Tag" />
	  <?php if ($mode != "pandora") {echo"</td></tr>";}?>
	  <tr>
      <td colspan="3" align="center"><?php if ($mode != 'pandora') { ?> <table <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?> width="67%" border="0" cellpadding="1" cellspacing="1">
        <tr align="center">
          <td class="stationlist"><a href="#" onclick="goPandora('artist')">Hear artists<br />
            like this on<br /><img src="/images/pandoralogo.gif" /></a></td>
          
		  <td class="stationlist"><a href="#" target="_self">Hear  songs<br />
            like
  this on</a><a href="#" onclick="goPandora('track')"><br />
  <img src="/images/pandoralogo.gif" /></a></td>
        </tr>
      </table><?php } else { ?> <table <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?> width="61%" border="0" cellpadding="1" cellspacing="1">
        <tr align="center">
          <td class="stationlist"><a href="#" onclick="goPandora('artist')">Hear music like this on Last.FM
          </a></td>
		  </tr>
      </table>
      <?php } ?></td>
    </tr>
  </table>
</form>
<script>
	//self.work.location.href = "tag.php?artist="+artist+"&track="+track+"&tag=heard+on+pandora&username="+username+"&password="+password;
</script>
