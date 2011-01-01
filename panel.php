<?php include("inc/errors.inc"); ?>

<script src="inc/prototype.js"></script>
<script language="JavaScript" src="inc/common.php"></script>
<script src="inc/boxover.js"></script>
<?php if ($_GET['mode'] == "pandora") { echo '<script src="javascript.php"></script>'; } ?>
<script src="http://www.pandora.com/include/PandoraAPIv2.js"></script>

<?php

$mode = $_GET[mode];
$panelmode = $_GET[panelmode];
if (!$panelmode && !$_COOKIE['panelmode']) { $panelmode = 'simplepanel'; };
echo "<script>mode = '$mode';";
echo "window.panelmode = '$panelmode';</script>";

if ($mode == "pandora") { $dyncontent = 'Please wait.  Pandora is loading.';}
if ($mode == "last") { $dyncontent = 'Above is the PandoraFM Player.  Use it to listen to Last.FM radio stations you have created.';}



	#content sizes
	$height = 135;
	if ($panelmode == 'simplepanel') { $height = $height; } else { $height = $height - 15; }

?>
<link href="charts.css" rel="stylesheet" type="text/css" />

<style>
BODY {
        PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; FONT: small/1.5em Georgia,Serif; BACKGROUND-COLOR: #EBEBCC; COLOR: #000; PADDING-TOP: 0px; voice-family: inherit
}
.statustext {
	font-size: 12px;
}
#countdownseconds {
	border: thin solid #000000;
	width: 25px;
}
#header {
	FONT-SIZE: 93%;
	background-color:#EBEBCC;
	FLOAT: left;
	WIDTH: 100%;
	LINE-HEIGHT: normal;
	background-image: url(images/bgcolorblock.jpg);
	background-repeat: repeat-y;
	PADDING-TOP: 0px
	top: 0px;
	margin: 0px;
	padding: 0px;
}
#header UL {
        PADDING-RIGHT: 10px; PADDING-LEFT: 5px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; LIST-STYLE-TYPE: none; text-decoration: none;
}
#header LI {
        PADDING-RIGHT: 0px; PADDING-LEFT: 9px; BACKGROUND: url(images/left.gif) no-repeat left top; FLOAT: left; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px;
}
#header A {
	PADDING-RIGHT: 15px;
	DISPLAY: block;
	PADDING-LEFT: 6px;
	BACKGROUND: url(images/right.gif) no-repeat right top;
	FLOAT: left;
	PADDING-BOTTOM: 2px;
	PADDING-TOP: 2px;
	TEXT-DECORATION: none;
	font-size: 12px;
}

#header A:hover {
        COLOR: #333
}

.tab {
	COLOR: #765;
}


.tabblack {
		COLOR: #000000
}
#header #current {
        BACKGROUND-IMAGE: url(images/left_on.gif)
}


#header #current A {
        BACKGROUND-IMAGE: url(images/right_on.gif); PADDING-BOTTOM: 5px; COLOR: #333
}

.active {
	BACKGROUND-IMAGE: url(images/left_on.gif) no-repeat left top;
	BACKGROUND-IMAGE: url(images/right_on.gif) no-repeat right top; PADDING-BOTTOM: 2px; COLOR: #333;
}
.dyncontent {
	overflow:auto;
	width: 100%;
	height: <?php echo $height - 10; ?>;
	font-size: 14px;
}


.mainformat {
	background-color: #ECECEC;
	font-size: 14px;
	overflow: auto;
}

body {
	background-color: #ebebcc;
	background-image: url();
	font-size: 14px;
}
.panelmain {
	background-color: #EBEBCC;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	scrolling: auto;
}

.popupbody {
	color:#336799;
	font-size: 10px;
	text-align: center;
	margin-left: 3px;
	background-color: #ebebcc;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	border: thin solid #336799;
	line-height: normal;
	vertical-align: top;
}

.popupbodyold {
	font-size: 12px;
	background-image: url(images/tooltip.gif);
	text-align: center;
	width: 200px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-bottom-color: #8A9DC4;
	border-left-style: none;
	margin-left: 10px;
}
.popupheader {
	background-color: #336799;
	font-size: 14px;
	height: 15px;
	text-align: center;
	cursor: default;
	visibility: hidden;
	width: 0px;
}
#loading {
	color:#0066FF;
	position:absolute;
	left:243px;
	top:59px;
	width:157px;
	height:36px;
	visibility:hidden;
	background-color: #F2F2F2;
	font-size: 30px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.tagdropdown {
	background-color: #EBEBCC;
	font-size: 12px;
}

#popup {
	color:#000000;
	position:absolute;
	left:45px;
	top:38px;
	width:511px;
	height:72px;
	visibility:hidden;
	background-color: #EBEBCC;
}
.style1 {
	font-size: 24px;
	color: #FF0000;
}
.voteform {
	font-size: 14px;
}
.border {
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000000;
	background-color: #336799;
}
.panelmain1 {	background-color: #EBEBCC;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	scrolling: auto;
}
.style2 {color: #ECECEC}
ul {
	text-decoration: none;
}

#refreshicon {
	position:fixed;
	color:#0066FF;
	left:1250px;
	top:125px;
}
a {
	text-decoration:none;
	color: #000000;	
}

html {
	margin: 0px;
	padding: 0px;
}

.seconds {
	border-bottom-width: thin;
	border-bottom-style: outset;
	border-bottom-color: #000000;
	background-color: #3E7DBC;
	border-top-width: thin;
	border-top-style: outset;
	border-right-style: outset;
	border-left-style: outset;
	border-top-color: #000000;
}
form {
	margin: 0px;
	padding: 0px;
	display: inline;
}
</style>
</head>
<body onLoad="panelInit()">
<?php
if ($panelmode != 'simplepanel') { ?>
<div id="header">
	<ul>
							<!-- CSS Tabs -->
			<li id="nowplayingtab" TITLE="header=[Now Playing] body=[Read about the current artist.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("nowplayingtab")>Now Playing</a></li>
			<li id="recenttab" TITLE="header=[Recent Tracks] body=[Your recently played tracks as seen by Last.FM.] singleclickstop=[on] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("recenttab")>Recent</a></li>
			<li id="toptab" TITLE="header=[Top Artists] body=[Your top played artists as seen by Last.FM.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("toptab") >Top</a></li>
			<li id="tagtab" TITLE="header=[Tag, Love, Ban, Recommend] body=[Perform actions on the current track.<br>You can Love, Ban, Tag, Recommend<br>or start a new station.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("tagtab")>Rate &amp; Tag </a></li>
			<li id="socialtab" TITLE="header=[External Links] body=[Browse other links on the internet,<br>join Last.FM groups, view photos,<br>or watch videos on the current artist.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a class="tab" href="#" onClick=changeTab("socialtab")>Social</a></li>
			<li TITLE="header=[Stations] body=[Listen to top Pandora stations voted on by others.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab"  onClick=changeTab("stationstab")>Stations</a></li>
			<li id="optionstab" TITLE="header=[Options] body=[Change how PandoraFM operates<br>by setting your personal options.<br>Includes tagging, submitting and more.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("optionstab")>Options</a></li>
			<li id="helptab" TITLE="header=[Help & FAQ] body=[View the help document to<br>resolve frequently asked questions<br>and find where to get other answers.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]"><a href="#" class="tab" onClick=changeTab("helptab")>Help</a></li>

	</ul>
</div>
<?php } ?>
  </p>
<table width="100%" height="<?php echo $height; ?>" border="1" align="left" cellpadding="0" cellspacing="0" class="panelmain1">
  <tr>
    <td width="64%" height="67" valign="top" bgcolor="#ECECEC"><div id="dyncontent" class="dyncontent">
      <div align="center"><img src="images/pandorafmlogo.jpg"><br>
        <a href="http://www.real-ity.com/">Brought to you by Real-ity.com</a></div>
      <center>
        <?php echo $dyncontent; ?>
      </center>
    </div></td>
    <form name="status" class="style2" id="status">
	<td width="36%" align="center" valign="top" bgcolor="#ECECEC">
	     <table width="100%"center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
	  
        <tr align="center" class="border">
          <td width="4%" valign="middle" class="border">&nbsp;</td>
          <td width="40%" valign="middle" class="border"><div id="nosubmitbutton">
            
            <?php if ($mode != 'last') { ?><input TITLE="header=[Station Tag] body=[Tag this as your Pandora station name] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" name="stationtag" type="button" class="statustext" id="stationtag" onClick="settag('stationtag')" value="Station Tag"/>
            <?php } ?>
          </div></td>
          <td width "44%" valign="middle" class="border"><div id="quicktagbutton">
           <input TITLE="header=[Quick Tag] body=[Tag this track with your quick tag<br>you set under options.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" name="qtbutton" type="button" class="statustext" id="qtbutton"  onClick="settag('quicktag')" value="<?php echo substr($_COOKIE['quicktag'],0,25); ?>">
          </div></td>
          <td width="7%" class="border"><div class="seconds" id="countdownseconds" TITLE="header=[Countdown] body=[Click on the coundown timer to stop it.] singleclickstop=[on] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" onClick="noSubmit()"></div></td>
          <td width="14%" align="right" valign="bottom" class="border"><img src="images/refresh.png" width="15" height="15" class="refreshicon" title="header=[Refresh] cssheader=[popupheader] cssbody=[popupbody] body=[Refresh panel if songs are not updating.] singleclickstop=[on] delay=[1300] fade=[off] fadespeed=[0.04] fixedrelx=[-200] fixedrely=[-80]" onClick="refreshPane()"> &nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="mainformat"><div TITLE="header=[Edit] body=[Click on artist or track<br>to edit metadata.] singleclickstop=[on] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" id="artistname">Please wait, PandoraFM  is loading. Thanks!<br>  <?php
		  if ($mode == 'pandora') {echo "Pause and unpause Pandora to force a refresh."; } 
		  if ($mode == 'last') {echo "Press play, or use the external option to begin the PandoraFM Last.FM Radio Player."; }
		  ?>
          </div>
            <div TITLE="header=[Edit] body=[Click on artist or track<br>to edit metadata.] singleclickstop=[on] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" id="trackname"></div>
            <div class="statustext" id="statustext"></div>
            <div class="statustext" id="output"></div>
			<div class="statustext" id="notice"><?php if ($panelmode == "simplepanel") {
				echo '<br>Many more features available.  Turn them on with "More Options" in the menu above!';
			}
			?></div>			</td>
        </tr>
      </table>
    </form>
  </tr>
</table>
<div style="filter: alpha(opacity=60); -moz-opacity: 0.6; opacity: 0.6;" id="loading">
<div align="center">Loading<span class="style1"><img src="http://static.last.fm/tageditor/progress_active.gif" width="25" height="23"></span></div></div>
<div style="filter: alpha(opacity=60); -moz-opacity: 0.6; opacity: 0.6;" id="popup"></div>
</body>
</html>

