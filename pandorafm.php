<?php

	if (!$pleaselogin) {
		$mode = $_GET[mode];
		$station = $_GET[station];
		#if ($mode == '') { $topframeurl = "playerchoice.php?initmode=pandora"; }
		switch ($mode) {
			case "pandora":
				$topframeurl = "playerchoice.php?initmode=pandora";
			break;
			
			case "last":
				$topframeurl = "playerchoice.php?initmode=last";
			break;
			
			default:
				$topframeurl = "playerchoice.php?initmode=pandora";
			break;

		}
		#if (strpos($station, 'sh')) {$topframeurl = "playerchoice.php?initmode=pandora&station=$station"; break 2;}
		#if (strpos($station, 'lastfm://')) {$topframeurl = "playerchoice.php?initmode=last&station=$station"; break 2;}

$panel = $_COOKIE['panelmode'];
if ($panel != 'advpanel' && $panel != 'simplepanel') {$panel = 'simplepanel';}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="alternate" type="application/rss+xml" title="PandoraFM Journals" href="http://ws.audioscrobbler.com/1.0/group/PandoraFM Users/journals.rss">
<link rel="alternate" type="application/rss+xml" title="PandoraFM Forum" href="http://ws.audioscrobbler.com/1.0/forum/33812/posts.rss">
<title>PandoraFM</title>
</head>

<frameset rows="20,*,150" frameborder="0" border="0" framespacing="0">
  <frame src="<?php echo $topframeurl; ?>" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" title="tabs" frameborder=0 marginheight=0 marginwidth=0 />
    <frame name="mainFrame" id="mainFrame" title="main" frameborder=0 marginheight=0 marginwidth=0 />
      <frame src="panel.php?panelmode=<?php echo $panel;?>" name="bottomFrame" scrolling="no" noresize="noresize" id="bottomFrame" title="panel" frameborder=0 marginheight=0 marginwidth=0 />
      </frameset>
      <noframes><body>
      </body>
      </noframes></html>
<?php } else { ?>
You must log in
<?php } ?>
