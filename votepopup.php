<?php
include("inc/errors.inc");
include("inc/checklogin.inc");
include("inc/utils.inc");

$mode = $_GET[mode];
?>

<script src="playerfunctions.php"></script>

<style type="text/css">
<!--
.style23 {font-size: 10px}
.style24 {font-size: 10px}
.headertext {
	font-size: 12px;
	vertical-align: top;
}

-->
</style>
<script>
	window.mode = '<?php echo $mode; ?>';
	tagoption = readSetting('tagoption') + ": ";
	<?php
		if ($_COOKIE['tagoption'] == "artist") {
			$caption = $_COOKIE['tagoption'].'artist';
		} else {
			$caption = $_COOKIE['tagoption'].'artist + " - " + track';
		}
	?>
	
	document.getElementById('voteheader').innerHTML = "What would you like to do with " + artist + " - " + track + "?<br>";
</script>
<form style="display: inline;" id="voteform" name="voteform" method="post" action="">
  <table border="0" align="center" bgcolor="#336799" <?php if ($mode == "pandora") { echo 'width=85%"'; } else { echo 'width=200"';}?> <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>>
    <tr>
      <td width="33%" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><a <?php if ($mode == 'pandora') { echo 'TITLE="header=[Love] body=[Love this track on Last.FM Radio.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"';} ?> href=# onClick=loveban("loveTrack")><img src="/images/love.gif" width="30" height="30" border="0" /></a><br />
      <span class="style24">Love</span></td>
      <td width="33%" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><a <?php if ($mode == 'pandora') { echo 'TITLE="header=[Ban] body=[Ban this track on Last.FM Radio.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"';} ?> href=# onClick=loveban("banTrack")><img src="/images/ban.gif" width="30" height="30" border="0" /></a><br />
      <span class="style24">Ban</span></td>
      <td width="50%" align="center" valign="top" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><div class="style23" id="popupfield"><a <?php if ($mode == 'pandora') { echo 'TITLE="header=[Recommend] body=[Recommend this track to a Last.FM user or email address.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"'; } ?>href=# onClick=show_popup_field()><img src="images/recommend.gif" border=0/></a><br />
      <span class="style24">Recommend</span></div> </td>
    </tr><tr valign="top">
      <td colspan="3" align="center" valign="bottom" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><?php if ($mode == 'pandora') {echo "<img src='images/tag.gif'>";}?>
        <select <?php if ($mode == 'pandora') { echo 'TITLE="header=[Tag] body=[Tag this with one of your tags.<br>Choose Other if you want to type in a new tag of your own and hit Create New Tag.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[-50] cssheader=[popupheader] cssbody=[popupbody]"'; } ?> name="tag" class="style23" id="tag">
        <option value="">Tag this...</option>
        
        <?php taglist(); ?>
		
		<option value="-OTHER-">Other...</option>
      </select><?php if ($mode != "pandora") {echo "</td></tr><tr><td colspan=3 align=center>";}?>
	  <input <?php if ($mode == 'pandora') { echo 'TITLE="header=[Tag] body=[Type in a new tag for this track.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[-50] cssheader=[popupheader] cssbody=[popupbody]"'; } ?> onClick="voteform.newtag.value=''" class="style23" name="newtag" type="text" id="newtag" value="create new tag" size="20" />
	  <input onclick="settag('dropdown','artist') "name="artist" type="button" id="artist" value="Tag Artist" />
	  <input onclick="settag('dropdown','track')" name="track" type="button" id="track" value="Tag Track" />
	  <?php #if ($mode != "pandora") { echo "</tr></td>"}?>
    <tr valign="top">
      <td colspan="3" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>>
    <tr valign="top" class="style24">
      <td colspan="3" align="center" <?php if ($mode == "pandora") { echo 'align="center"'; } else { echo 'align="left"';}?>><div align="center" class="headertext" id="voteheader"></div>
  </table>
</form>
</body>
