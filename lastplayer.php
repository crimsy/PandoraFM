<?php if ($_GET['artist']) { echo "<script>window.playartist = '$_GET[artist]';</script>";}
include("inc/errors.inc");
include("inc/checklogin.inc");
include("lastradio.php");
include("inc/utils.inc");

echo "<script>";
#include("inc/common.php");
include("playerfunctions.php");
echo "</script>";
#include("parseini.php");
$stream = urlencode($session[stream]);
$sessionname = $session[name];
$autoplay = $_GET['autoplay'];

#echo $stream;
?>
</script>
<?php  ?>
<script src="inc/prototype.js"></script>
<script src="inc/common.php"></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>PandoraFM Player</title>
<style type="text/css">
<!--
.border {
	border: 18px ridge #CCCCCC;
}
.pandoraform {
	color: #CCCCCC;
	border: thin inset #959595;
	background-color: #336799;
	font-size: 9px;
}

body {
	color: #FFFFFF;
	font-size: 14px;
	vertical-align: middle;
	letter-spacing: normal;
	word-spacing: normal;
	text-align: justify;
	background-color: #EBEBCC;
}
.cellborder {
	border-top-width: thin;
	border-right-width: thin;
	border-bottom-width: thin;
	border-left-width: thin;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
}
.output {
	color: #000000;
}

#popup {
color:#FFFFFF;
position:absolute;
left:353px;
top:73px;
width:478px;
height:259px;
border:1px solid #ccc;
border-left:1;
border-right:1;
background-color:#000000;
visibility:hidden;
overflow:auto;
}

#votepopup {
color:#FFFFFF;
position:absolute;
left:520px;
top:115px;
width:241px;
height:154px;
border:1px solid #ccc;
border-left:1;
border-right:1;
background-color:#000000;
visibility:hidden;
}

#errorbox {
color:#FFFFFF;
position:absolute;
left:335px;
top:96px;
width:288px;
height:152px;
border:1px solid #ccc;
border-left:1;
border-right:1;
background-color:#000000;
visibility:hidden;
}

#morestations {
color:#FFFFFF;
position:absolute;
left:324px;
top:75px;
width:382px;
height:152px;
border:1px solid #ccc;
border-left:1;
border-right:1;
background-color:#000000;
visibility:hidden;
}

.stationlist {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
	background-color: #336799;
	color: #CCCCCC;
	border: medium outset #333333;
	width: 100%;
}

.stationlist a {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
	background-color: #336799;
	color: #CCCCCC;
}

.text {
	letter-spacing: 2px;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
}

.text a {
	letter-spacing: 2px;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
}

a {
	text-decoration: none;
	filter: Light;
	font-size: 11px;
	color:#FFFFFF;
}

.tagdropdown {
	font-size: 8px;
	font-style: normal;
	text-transform: uppercase;
}
a:hover {
	text-decoration: none;
	filter: Light;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.style1 {font-size: 9px}
.style2 {font-size: 14px}
.style3 {font-size: 10px}

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

.popupheader {
	color:#336799;
	font-size: 10px;
	text-align: center;
	margin-left: 3px;
	background-color: #ebebcc;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	border: thin solid #336799;
	line-height: normal;
	vertical-align: top;
	font-weight: bold;
}
-->
</style>
</head>

<body onLoad="checkForStation()">
<div style="filter: alpha(opacity=85); -moz-opacity: 0.85; opacity: 0.85;" class="output" id="popup"></div>
<div style="filter: alpha(opacity=90); -moz-opacity: 0.9; opacity: 0.9;" class="output" id="votepopup"></div>
<div style="filter: alpha(opacity=85); -moz-opacity: 0.85; opacity: 0.85;" id="morestations">
   <form id="globaltags" name="globaltags">
     <table width="90%" border="0" align="center">
       <tr>
         <td colspan="2" align="center">Other Stations from Global Tags </td>
       </tr>
       <tr>
         <td width="84%" align="center">Your Tags </td>
         <td width="84%" align="center"><select name="globalusertags" class="tagdropdown" id="globalusertags" onChange="changestation(document.globaltags.globalusertags.value)">
           <option value="0">Global Tag Radio from your tags</option>
           <?php taglisturl();?>
         </select></td>
       </tr>
       <tr>
         <td align="center">Everyone's Tags </td>
         <td align="center"><select name="globaleveryonetags" class="tagdropdown" id="globaleveryonetags" onChange="changestation(document.globaltags.globaleveryonetags.value)">
           <option value="0">Gbloal Tag Radio from everyone's tags</option>
           <?php
			$lasttagurl = "http://ws.audioscrobbler.com/1.0/tag/toptags.xml";
			#lfmlog("Getting XML for $lasttagurl \n");
			$taginit = curl_init();
			curl_setopt($taginit, CURLOPT_URL, $lasttagurl);
			curl_setopt($taginit, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($taginit, CURLOPT_FRESH_CONNECT, TRUE);
			$toptags = curl_exec($taginit);
			
			$tags = simplexml_load_string($toptags);
			foreach ($tags->tag as $tag) {
				$tagname = $tag['name'];
				if (strlen($string) > 20) { $tagname = substr($tagname,0,20) . "..."; }
				$tagvalue = urlencode($tag[name]);
				echo "<option value='lastfm://globaltags/$tagvalue'>$tagname</option>";
			}
			curl_close($taginit);
		?>
         </select></td>
       </tr>
       <tr>
         <td align="center"><p>Type your own<br />
             <span class="style3">(electroclash, pop, latin, heard on pandora) </span></p>         </td>
         <td align="center"><input name="customtag" type="text" class="tagdropdown" id="customtag" />
         <input onClick="changestation('lastfm://globaltags/'+document.globaltags.customtag.value)" name="tunein" type="button" class="tagdropdown" value="Tune In" /></td>
       </tr>
       <tr>
         <td colspan="2" align="center">[<a href="#" class="style2" onClick="close_popup_stations()">close</a>]</td>
       </tr>
     </table>
     
  </form>
</div>
<div id="errorbox">
  <div align="center">
    <p>Error</p>
    <p><div id="errormessage"></div>
	<input type="button" class="text" onClick="hideerror()" value="OK" />
  </div>
</div>
<p>&nbsp;</p>
<table width="580" height="245" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="border">
  <tr class="cellborder">
    <td width="26%" align="center" bgcolor="#666666">PandoraFM Player</td>
    <td width="58%" align="center" valign="top" bgcolor="#666666"><div id="stationname"></div></td>
    <td width="16%" align="right" valign="top" bgcolor="#666666">
      <?php include("flashplayer.php"); ?>
      <a TITLE="header=[Skip] body=[Skip the current track] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" href="#" onClick="skip()"><img src="images/skip.jpg" width="20" height="20" border="0" /></a>&nbsp;
	  <a TITLE="header=[External Player] body=[Listen to Last.FM Radio with<br>your external player (iTunes, Winamp, Media player)] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" target="_blank" href=externalplayer.php?sessionname=<?php echo $sessionname;?>&streamurl=<?php echo $streamurl;?>><img src="images/external.jpg" alt="Listen with external player (iTunes, Winamp)" width="20" height="20" border=0 /></a>   
    </script></td>
  </tr>
  <tr>
    <td align="center" valign="top" bgcolor="#000000"><form id="stations" name="stations"> 
       Paste  a  radio url<br />
          <input name="newstation" type="text" class="pandoraform" id="newstation" value="lastfm:// link" size="18"/>
          <br />
          <input name="submitstation" onClick="changestation(document.stations.newstation.value)" type="button" class="tagdropdown" id="submitstation" value="Tune In" />
          <table width="90%" border="0" align="center">
            <tr>
              <td align="center" class="stationlist"><a href="#" onClick="changestation('lastfm://user/<?php echo $username; ?>/personal')">Personal Radio</a></span></td>
            </tr>
            <tr>
              <td align="center" class="stationlist"><a href="#" class="style1" onClick="changestation('lastfm://user/<?php echo $username; ?>/loved')">Loved Tracks </a></td>
            </tr>
            <tr>
              <td align="center" class="stationlist"><a href="#" class="style1" onClick="changestation('lastfm://user/<?php echo $username; ?>/neighbours')">Neighbour Radio </a></td>
            </tr>
            <tr>
				<?php if ($_COOKIE['radiopct']) {
					$radiopct = $_COOKIE['radiopct'];
				} ?>
			
              <td align="center" class="stationlist"><a href="#" class="style1" onClick="changestation('lastfm://user/<?php echo $username; ?>/recommended/<?php echo $radiopct; ?>')">Recommendation Radio </a></td>
            </tr>
            <tr>
              <td height="20" align="center" class="stationlist"><a href="#" class="style1" onClick="popup_stations()">Other Stations</a> </td>
            </tr>
        </table>
          
         <select name="tag" class="tagdropdown" id="tag" onChange="changestation(document.stations.tag.value)">
           <option value="0">Personal Tag Radio</option>
            
           <?php taglisturl();?>
         </select>
         
    </form>    </td>
    <td colspan="2" align="center" valign="middle" bgcolor="#336799"><div onClick="popup_vote_close()" id="mainbox">
      <table width="48%" border="2" bordercolor="#000000" bgcolor="#000000">
      <tr>
        <td><table width="178" border="0" align="center" cellpadding="0" cellspacing="0"  bgcolor="#CCCCCC">
          <tr>
            <td width="148" align="center" valign="top" class="text"><div id="artistdiv">Press Play to </div></td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="text"><div id="trackdiv">Listen to Last.FM </div></td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="text"><div id="albumdiv"></div></td>
          </tr>

          <tr>
            <td align="center" valign="middle" class="text"><div id="coverartdiv"><img height="120" width="120" src="images/pandorafmlogo.jpg" /></div></td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="text"><script src="inc/percent_bar.js"></script></td>
          </tr>
        </table></td>
      </tr>
  </table>  </tr>
</table>

<center>
  <div class="output" id="output">Ready to play! </div>
</center>
</p>
<div align="center"><a href=externalplayer.php?sessionname=<?php echo $sessionname;?>&streamurl=<?php echo $streamurl;?> TITLE="header=[External Player] body=[Listen to Last.FM Radio with<br>your external player (iTunes, Winamp, Media player)] delay=[1200] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" target="_blank" class="style2">Listen with your player of choice.  Click here to listen in iTunes, Winamp, Windows Media and more.</a></div>
</body>
</html>
