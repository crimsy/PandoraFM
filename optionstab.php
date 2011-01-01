<?php 
	include("inc/checklogin.inc");
	include("inc/utils.inc");
	#include("inc/common.php");
?>

<script src="inc/prototype.js"></script>
<script src="inc/common.php"></script>
<style type="text/css">
<!--
.textsize {font-size: 14px}
.style3 {font-size: 10px}
-->
</style>
<form id="settings" name="settings">
  <table width="100%" border="0">
    <tr>
      <td width="48%" align="right" class="textsize"><span class="textsize">Timeout until a Pandora track submits to Last.FM </span></td>
      <td colspan="2" class="textsize"><select name="timeoutsub" class="textsize" id="timeoutsub">
        <option value="10" <?php if ($_COOKIE['timeoutsub'] == "10") {echo 'selected="selected"';} ?>>10</option>
        <option value="30" <?php if ($_COOKIE['timeoutsub'] == "30") {echo 'selected="selected"';} ?>>30</option>
        <option value="60" <?php if ($_COOKIE['timeoutsub'] == "60") {echo 'selected="selected"';} ?>>60</option>
        <option value="90" <?php if ($_COOKIE['timeoutsub'] == "90" || !$_COOKIE['timeoutsub']) {echo 'selected="selected"';} ?>>90</option>
        <option value="120" <?php if ($_COOKIE['timeoutsub'] == "120") {echo 'selected="selected"'; }?>>120</option>
      </select>      </td>
    </tr>
    <tr>
      <td width="48%" align="right" class="textsize"><span class="textsize">Quick Tag button</span></td>
      <td colspan="2" class="textsize"><span class="textsize">
        <select class="tagdropdown" name="quicktagon" id="quicktagon">
              <option value="Yes" <?php if ($_COOKIE['quicktagon'] == "yes") {echo 'selected="selected"';} ?>>Yes</option>
              <option value="0" <?php if ($_COOKIE['quicktagon'] == "0" || !$_COOKIE['quicktagon']) {echo 'selected="selected"';} ?>>No</option>
        </select>
      </span></td>
    </tr>
    <tr>
      <td align="right" class="textsize"><span class="textsize">Quick Tag</span></td>
      <td colspan="2" class="textsize"><span class="textsize">
        <select class="tagdropdown" name="quicktag" id="quicktag"> 
          <option value="<?php echo $_COOKIE['quicktag']; ?>" selected="selected"><?php echo $_COOKIE['quicktag']; ?></option>
          <?php
		  taglist(); 
		  if ($_COOKIE['pandorauser']) { stationlist(); } 
		  ?>
        </select>
      </span> </td>
    </tr>
    <tr>
      <td align="right" class="textsize">Default tag option</td>
      <td width="9%" class="textsize"><span class="style3">
        <select class="tagdropdown" name="tagoption" id="tagoption">
          <option value="track" <?php if ($_COOKIE['tagoption'] == "track") {echo 'selected="selected"'; } ?>>Track</option>
          <option value="artist" <?php if ($_COOKIE['tagoption'] == "artist") {echo 'selected="selected"'; } ?>>Artist</option>
        </select>
      </span></td>
      <td width="43%" class="textsize"><span class="style3">When using any psudo-auto tagging method (Quick Tag, Loved Tagging, etc) </span></td>
    </tr>
    <tr>
      <td align="right" class="textsize"><span class="textsize">Tag &quot;Loved&quot; tracks as &quot;Loved&quot;</span></td>
      <td class="textsize"><span class="textsize">
        <select class="tagdropdown" name="lovetag" id="lovetag">
          <option value="Yes" <?php if ($_COOKIE['lovetag'] == "Yes") {echo 'selected="selected"';} ?>>Yes</option>
          <option value="0" <?php if ($_COOKIE['lovetag'] == "0" || !$_COOKIE['lovetag']) {echo 'selected="selected"';} ?>>No</option>
        </select>
	  </span></td>
      <td class="style3">Adds  to your &quot;Loved&quot; tag set what you Loved. </td>
    </tr>
    <tr>
      <td align="right" class="textsize">Sort tag lists by name </td>
      <td class="textsize"><select class="tagdropdown" name="sorttags" id="sorttags">
        <option value="Yes" <?php if ($_COOKIE['sorttags'] == "Yes") {echo 'selected="selected"';} ?>>Yes</option>
        <option value="0" <?php if ($_COOKIE['sorttags'] == "0" || !$_COOKIE['sorttags']) {echo 'selected="selected"';} ?>>No</option>
      </select></td>
      <td class="style3">Default sort is by most used. </td>
    </tr>
    <tr>
	<?php if ($_COOKIE['radiopct']) {
		$radiopct = $_COOKIE['radiopct'];
	} else {
		$radiopct = "100";
	} ?>
      <td align="right" class="textsize">Last.FM Recommendation Radio Percentage </td>
      <td colspan="2" class="textsize"><input class="tagdropdown" name="radiopct" type="text" id="radiopct" value="<?php echo $radiopct; ?>" size="4" maxlength="3" /> 
        <span class="style3">(1 - 100. 100% = mainstream) </span></td>
    </tr>
    <tr>
      <td align="right" class="textsize">Enable tooltips </td>
      <td colspan="2" class="textsize"><select class="tagdropdown" name="tooltips" id="tooltips">
        <option value="Yes" <?php if ($_COOKIE['tooltips'] == "Yes") {echo 'selected="selected"';} ?>>Yes</option>
        <option value="0" <?php if ($_COOKIE['tooltips'] == "0") {echo 'selected="selected"';} ?>>No</option>
      </select></td>
    </tr>
    <tr>
      <td align="right" class="textsize">Default bottom panel </td>
      <td colspan="2" class="textsize"><select class="tagdropdown" name="panelmode" id="panelmode">
        <option value="simplepanel" <?php if ($_COOKIE['panelmode'] == "simplepanel") {echo 'selected="selected"';} ?>>Simple Panel</option>
        <option value="advpanel" <?php if ($_COOKIE['panelmode'] == "advpanel") {echo 'selected="selected"';} ?>>More Options</option>
                  </select></td>
    </tr>
    <tr>
      <td align="right" class="textsize">Your Pandora Username </td>
      <td colspan="2" class="textsize"><input class="tagdropdown" name="pandorauser" type="text" id="pandorauser" value="<?php echo $_COOKIE['pandorauser']; ?>" size="10" /> 
        <span class="style3">(Find out via the &quot;Your Profile&quot; page).  May make Options tab take longer to load.</span></td>
    </tr>
    <tr>
<!--      <td colspan="2" align="center" class="textsize"><span class="textsize"><strong>*The following options are not yet available. Don't try them.* </strong></span></td>
    </tr>
    <tr>
      <td width="50%" align="right" class="textsize"><span class="style3">Auto-tagging enabled</span></td>
      <td class="textsize"><span class="style3">
        <select class="tagdropdown" name="autotagon" id="autotagon">
          <option value="Yes" <?php if ($_COOKIE['quicktagon'] == "yes") {echo 'selected="selected"';} ?>>Yes</option>
          <option value="0" <?php if ($_COOKIE['quicktagon'] == "0") {echo 'selected="selected"';} ?>>No</option>
        </select>
      *</span></td>
    </tr>
    <tr>
      <td align="right" class="textsize"><span class="style3">Autotag as </span></td>
      <td class="textsize"><span class="style3">
        <select class="tagdropdown" name="autotag" id="autotag">
          <?php taglist(); ?>
        </select>
      </span> * </td>
    </tr>
    <tr>
    	<td align="right" class="textsize"><span class="style3">Timeout until a Pandora track is auto-tagged</span></td>
	<td class="textsize"><select name="timeouttag" class="tagdropdown textsize  style3" id="timeouttag">
      <option value="10">10</option>
      <option value="30">30</option>
      <option value="90">90</option>
      <option value="120">120</option>
    </select>
	  *</td>
--></tr>
    <tr>
      <td align="right" class="textsize"><span class="textsize">Are songs no longer submitting?</span></td>
      <td colspan="2" class="textsize"><button class="textsize" onClick="refreshPane()">Reload PandoraFM</button>
        <span class="textsize">Won't stop Pandora</span></td>
    </tr>
    <tr>
      <td colspan="3" align="center" class="textsize">Some options, such as disabling tooltips, may require a restart of PandoraFM. </td>
    </tr>
    <tr>
      <td width="48%" align="right" class="textsize"><span class="textsize"></span></td>
      <td colspan="2" class="textsize"><input name="Save" type="button" class="tagdropdown" onClick="saveSettings()" value="Save" /></td>
    </tr>
  </table> 
</form>
