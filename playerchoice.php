<?php
	$mode = $_GET[mode];
	$initmode = $_GET[initmode];
	$station = $_GET[station];
	$artist = $_GET[artist];
	$initmode = $_GET[initmode];
	$mode = $_GET[mode];
	
	if (!$_COOKIE['panelmode']) { $panelmode = 'simplepanel'; } else { $panelmode = $_COOKIE['panelmode'];}
	
	
?>
<script src="inc/prototype.js"></script>

<script>
mode = "<?php echo $_GET['mode']; ?>";
initmode = "<?php echo $_GET['initmode']; ?>";
switchtab = '';
<?php echo "panelmode = '$panelmode';"; ?>

if (initmode) {
	switch_mode(initmode);
}

<?php
if ($_GET['switchtab']) {echo "switchtab = '$_GET[switchtab]';"; }
if ($panelmode != '') {
	#echo "panelmode = '$panelmode';";
} else {
	#echo "panelmode = 'simplepanel';";
}
?>

<?php if ($artist) { echo 'artist = "'.$artist.'";';}
?>
function getBanner() {
	// For announcements update from notice.txt with a random number to bypass the ajax cache
	randnum = Math.floor ( Math.random () * 100 + 1 );
	var myAjax = new Ajax.Updater('notice',"notice.txt?"+randnum, {method: 'get', asynchronous: true, evalScripts: false});
	
}
function check_init() {

	if (switchtab && !initmode && !mode) {
		mode = switchtab;
		<?php if (!$_GET['mode']) { $_GET['mode'] = $_GET[switchtab]; }?>
	}
	
}

function switch_mode(mode) {
	self.location.href="playerchoice.php?mode="+mode;
	window.mode = mode;
	switch(mode) {
			case "pandora":
			main = "http://www.pandora.com";
			parent.mainFrame.location.href=main;
			parent.bottomFrame.location.href="panel.php?mode=pandora&panelmode="+window.panelmode;
			//top.frames['mainFrame'].document.all.['content'].style.visibility = 'hidden';
			//parent.frames['mainFrame'].document.getElementsByID("content").style.visibility="hidden"
			break;
		
		case "last":
			main = "lastplayer.php";
			parent.mainFrame.location.href=main;
			parent.bottomFrame.location.href="panel.php?mode=last&panelmode="+window.panelmode;
			break;
			
		default:
			main = "http://www.pandora.com";
		break;
	}
}
function panelChange() {
	panel = $F('panelselect');
	window.panelmode = panel;
	//save preference
	theDate = new Date();
	//Set the panelmode cookie for one year
	theDate.setTime(theDate.getTime()+30758400);
	expires = theDate.toGMTString;
	//document.cookie = "panelmode=" + panel + "; expires=" + expires + "; path=/";
	var myAjax = new Ajax.Updater( 'output',"savesetting.php?panelmode="+panel, {method: 'get', asynchronous: true, evalScripts: true} );
	
	switch(panel) {
		case "simplepanel":
			parent.bottomFrame.location.href="panel.php?mode="+window.mode+"&panelmode="+panel;
			break;
		case "advpanel":
			parent.bottomFrame.location.href="panel.php?mode="+window.mode+"&panelmode="+panel;;
			break;
	}
}

function readSetting(name) {
	var settings = document.cookie;
	var prefix = name + "=";
	var begin = settings.indexOf("; "+ prefix);
	if (begin == -1) {
		begin = settings.indexOf(prefix);
		if (begin !=0) return null;
	} else
		begin += 2;
	var end = document.cookie.indexOf(";", begin);
	if (end == -1)
		end = settings.length;
	return unescape(settings.substring(begin + prefix.length, end));
}
</script>

<style>
#panelchoice {
	position: absolute;
	float:right;
	top: 0px;
	clip: rect(auto,auto,auto,auto);
	width: auto;
	color: #000000;
	visibility: visible;
	right: 2px;
	font-size: 12px;
}
#header {
	FONT-SIZE: 93%;
	background-color:#EBEBCC;
	FLOAT: left;
	WIDTH: 100%;
	LINE-HEIGHT: normal;
	background-image: url(images/bgcolorblock.jpg);
	background-repeat: repeat-y;
	top: 0px;
	margin: 0px;
	padding: 0px;
	border-bottom-style: solid;
	border-bottom-width: 1px;
}
.smallfont {
	font-size: 9px;
}
#header UL {
        PADDING-RIGHT: 0px; PADDING-LEFT: 55px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px; LIST-STYLE-TYPE: none
}
#header LI {
        PADDING-RIGHT: 0px; PADDING-LEFT: 5px; BACKGROUND: url(images/left.gif) no-repeat left top; FLOAT: left; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px}
#header A {
        PADDING-RIGHT: 15px; DISPLAY: block; PADDING-LEFT: 6px; BACKGROUND: url(images/right.gif) no-repeat right top; FLOAT: left; PADDING-BOTTOM: 0px; COLOR: #765; PADDING-TOP: 3px; TEXT-DECORATION: none
}

#header A {
        FLOAT: none
}
#header A:hover {
        COLOR: #333
}
#header #current {
        BACKGROUND-IMAGE: url(images/left_on.gif)
}
#header #current A {
        BACKGROUND-IMAGE: url(images/right_on.gif); PADDING-BOTTOM: 0px; COLOR: #333
}

body {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; background-color: #EBEBCC; PADDING-TOP: 0px
}

#header #noticebanner A {
	COLOR: #5D5043;
	font-size: 14px;
	letter-spacing: 1px;
	margin-top: 2px;
	BACKGROUND-IMAGE: none;
	FLOAT: none;
	DISPLAY: inline;
	margin-left: 0px;	
}

#hader #noticebanner A:hover {
	text-decoration: underline;	
}

#header #noticebanner {
	COLOR: #765;
	font-size: small;
	letter-spacing: 1px;
	margin-top: 2px;
	margin-left: 80px;
	BACKGROUND-IMAGE: none;
	vertical-align: top;
	horizontal-align: right;
}

</style>
<body onLoad="check_init()">
		<!-- CSS Tabs -->
<div id="header"><ul><li <?php if ($_GET['mode'] == "pandora" || !$_GET['mode']) { echo "id=current";}?>><a href="#" onClick=switch_mode("pandora") class="tab">Pandora</a></li>
	  <li <?php if ($_GET['mode'] == "last") { echo "id=current";}?>><a href="#" class="tab" onClick=switch_mode("last")>Last.FM Radio</a></li>
	  <li class="tab"><select name="panelselect" class="smallfont" id="panelselect" onChange="panelChange()">
    <option value="simplepanel" <?php if ($_COOKIE['panelmode'] == 'simplepanel' || !$_COOKIE['panelmode']) {echo ' selected = "selected"';} ?>>Simple</option>
    <option value="advpanel" <?php if ($_COOKIE['panelmode'] == 'advpanel') {echo ' selected = "selected"';} ?>>More Options</option>
  </select></li>
	<li id="noticebanner"><div id="notice"></div></li>
	</ul>
</div>
</body>
