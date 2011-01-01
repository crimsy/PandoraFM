<?php
$username = $_POST[username];
$password = $_POST[password];
$hashpassword = md5($password);
$servername = $_SERVER['SERVER_NAME'];
setcookie("logincookie[username]",$username,time()+30758400);
setcookie("logincookie[password]",$hashpassword,time()+30758400);

$artist = $_POST[artist];
$sc = $_POST[sc];

if ($artist) {
	$addtourl = "&artist=$artist";
}

if ($sc) {
	$addtourl = "&sc=$sc";
}

	if ($username) {
		#include("inc/writeconfig.inc");
		header("LOCATION:http://$servername/pandorafm.php?id=$id&username=$username".$addtourl);
	} else {
		header("LOCATION:http://$servername/index.php?mustloginfirst=1");
	}
?>
