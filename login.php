<?php
$notvalid = $_GET[notvalid];
$mustloginfirst = $_GET[mustloginfirst];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pandora.FM by Real-ity</title>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=700,height=500');");
}
// End -->
</script>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/pandorafm-login_18.gif);
	background-color: #BCBCB7;
}
.b0x {
	border: 1px solid #DCDCDC;
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	height: 20px;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style3 {
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
a.diddy:link {
	color: #FFFFFF;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
	font-style: normal;
	font-variant: normal;
	text-decoration:none
}
a.diddy:visited {
	color: #FFFFFF;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
	font-style: normal;
	font-variant: normal;
	text-decoration:none
}
a.bwlink:link {
	font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
	font-style: normal;
	line-height: 18px;
	color: #000000;
}
a.bwlink:visited {
	font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
	font-style: normal;
	line-height: 18px;
	color: #000000;
}
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #7BBBFF;
	font-weight: bold;
}
.style5 {
	font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
	font-style: normal;
	line-height: 18px;
}
.style8 {
	font-size: 12px;
	font-weight: normal;
	line-height: 18px;
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
}
#pcworld {
	position:absolute;
	width:518px;
	height:165px;
	z-index:1;
	left: 286px;
	top: 532px;
	border-right-style: solid;
	border-bottom-style: solid;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	background-color: #FFFFFF;
	visibility: hidden;
}
#errors {
	position:absolute;
	width:490px;
	height:79px;
	z-index:2;
	left: 305px;
	top: 177px;
	background-color: #FFFF99;
	font-family: Arial, Helvetica, sans-serif;
	border-right-style: solid;
	border-bottom-style: solid;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
}
-->
</style>
</head>

<body>
            <?php 
			
			if ($mustloginfirst || $notvalid) { echo '<div id="errors">'; }
			if ($mustloginfirst) { echo "Sorry, but you have to log into Last.FM here first."; } if ($notvalid) { echo "Sorry, after checking, that is not a valid Last.FM username and/or password.  Make sure you're using the same username and password that you do to login to Last.FM.  Please try again."; } if ($expired) { echo "Sorry, your session file expired.  Log back in again and you will be good to go.  Sorry for that."; }
			if ($mustloginfirst || $notvalid) { echo '</div>'; } ?>


<div id="pcworld"><img src="/images/pfmpcworld.jpg" /></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="94" background="images/pandorafm-login_02.jpg"><img src="images/pandorafm-login_01.jpg" width="316" height="94" alt="Pandora.FM" /></td>
  </tr>
  <tr>
    <td height="29" align="left" valign="middle" background="images/barbg_02.gif"><table width="640" height="29" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="197"><img src="images/up_02.gif" alt="^" width="194" height="29" /></td>
        <td width="443"><span class="style3"> <a href="http://www.last.fm/" class="diddy">Last.fm</a> &lt;-&gt; </span><a href="http://www.pandora.com" class="diddy">Pandora.com</a>  <span class="style1">| The best of both worlds</span></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="807" border="0">
  <tr>
    <td width="200" align="left" valign="top"><table width="190" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="29" colspan="3"><img src="images/loginbox_02.gif" alt="Login to Last.fm" width="190" height="29" /></td>
        </tr>
      <tr>
        <td width="13" background="images/loginbox_04.gif"><img src="images/loginbox_04.gif" width="13" height="160" /></td>
        <td width="165" align="left" valign="top" bgcolor="#FAFAFA"><form id="form1" name="form1" method="post" action="setup.php"><table width="100%" height="35%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="28"><img src="images/loginbox_07.gif" alt="Username:" width="91" height="21" /></td>
          </tr>
          <tr>
            <td>
              <label>
              <img src="images/clearpixel.gif" width="25" height="1" />
              <input name="username" type="text" class="b0x" id="username" />
              <input type="hidden" name="id" id="uid" value="1082063108" /><input type="hidden" name="sc" value="" />
                </label>            </td>
          </tr>
          <tr>
            <td height="20"><img src="images/loginbox_10.gif" alt="Password:" width="91" height="10" /></td>
          </tr>
          <tr>
            <td><label>
              <img src="images/clearpixel.gif" width="25" height="1" />
              <input name="password" type="password" class="b0x" id="password" />
            </label></td>
          </tr>
          <tr>
            <td height="50" align="left" valign="bottom"><a href="https://www.last.fm/join"><img src="images/loginbox_12.gif" alt="Need an account?  Visit www.last.fm" width="169" height="16" border="0" /></a><br />
                <img src="images/loginbox_14.jpg" alt="----" width="167" height="20" /></td>
          </tr>
          <tr>
            <td align="right"><label></label>
              <INPUT TYPE="image" src="images/loginbox_16.gif" alt="Submit" width="87" height="27" /></td>
          </tr>
        </table></form>          </td>
        <td width="8" background="images/loginbox_06.gif"><img src="images/loginbox_06.gif" width="8" height="160" /></td>
      </tr>
      <tr>
        <td height="13" colspan="3"><img src="images/loginbox_17.jpg" width="190" height="13" /></td>
        </tr>
    </table>
    <!--<p><a href="http://www.dreamhost.com/donate.cgi?id=6399"><img src="images/donate.gif" alt="Donate" width="136" height="32" border="0" /></a></p>-->
	</td>
    <td width="63%"><table width="504" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3"><img src="images/maintab_06.gif" alt="Welcome" width="504" height="43" /></td>
        </tr>
      <tr>
        <td width="12" background="images/maintab_08.gif"><img src="images/maintab_08.gif" width="12" height="336" /></td>
        <td width="475" align="left" valign="top" bgcolor="#FAFAFA"><table width="90%" border="0">
          <tr>
            <td class="style4">What is it? </td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%">&nbsp;</td>
                <td width="94%" align="left" valign="top" class="style5">PandoraFM  is simple. As you listen to music via the excellent 
                  Pandora music service each song gets submitted to your profile 
                  on Last.FM. You're listening to music, so why shouldn't you be 
                  able to account for it?  Some call it a mash-up, others call it a
hack.  I call it Pandora.FM </td>
              </tr>
            </table></td>
          </tr>
        </table>  
          <br />        
          <table width="90%" border="0">
            <tr>
              <td class="style4">Questions and Suggestions.,. </td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="6%">&nbsp;</td>
                    <td width="94%" align="left" valign="top" class="style5">Questions? <A HREF="javascript:popUp('http://pandorafm.real-ity.com/helptab.php')" class="bwlink">Read up</a>, or join and discuss on the <a href="http://www.last.fm/group/PandoraFM+Users/forum/33812" class="bwlink">Last.FM</a> forums!</td>
                  </tr>
              </table></td>
            </tr>
          </table>          <p><img src="images/reviews.gif" alt="The Reviews" width="463" height="25" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%">&nbsp;</td>
              <td width="94%" align="left" valign="top"><span class="style8">It truly give the best of two great worlds of music. THANKYOU - chezc@last.fm.
                  </span>
                <p class="style8">his  PandoraFM mashup is one of the best things to ever happen to Pandora  and last.fm. Check it out. You won't be sorry. -  thevillageidiot@last.fm.</p>
                <p class="style8">Pandora.com loves PandoraFM - Tom Conrad, CTO of Pandora.com.</p>
                <p class="style8">PandoraFM has become invaluable to me. And, by association, you as well. - Tony2Nice@last.fm.</p>
                <p class="style8">what would I do without it... - wrongladder@last.fm. </p>
                <p class="style8">great hair - GnarlyCranium</p><p><p><p><p><p><p><p><p></p></p></p></p></p></p></p></p><br />
                <p class="style8"><a href="links.html"><img src="images/related.gif" alt="Related Links" width="103" height="24" border="0" /></a></p></td>
            </tr>
          </table></td>
        <td width="17" background="images/maintab_10.gif"><img src="images/maintab_10.gif" width="17" height="336" /></td>
      </tr>
      <tr>
        <td colspan="3"><img src="images/maintab_11.gif" width="504" height="38" /></td>
        </tr>
    </table></td>
  </tr>
</table>
<p class="style1">(C) 2007 Gabe Kangas</p>
</body>
</html>
