<?php

$mustloginfirst = $_GET[mustloginfirst];
$notvalid = $_GET[notvalid];
$expired = $_GET[expired];
$artist = $_GET[artist];
$sc = $_GET[sc];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="shortcut icon" href="images/favicon.ico" />
<title>PandoraFM</title>
</head>

<frameset rows="*" frameborder="no" border="0" framespacing="0">
<frame src="login.php<?php if ($sc) { echo "?sc=$sc";} if ($mustloginfirst) {echo "?mustloginfirst=1";} if ($notvalid) {echo "?notvalid=1";} if ($expired) { echo "?expired=1";} if ($artist) {echo "?artist=$artist";}?>" name="indexframe" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
Submit the songs you're listening to with Pandora to your Last.FM profile.
</body>
</noframes></html>
