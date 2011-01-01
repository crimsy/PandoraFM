<?php
# 20060702 GEK Statistics and links for social networking purposes.
include("inc/errors.inc");
include("inc/db.inc");
$search = $_GET[search];
$searchlink = urlencode($search);
$searchname = utf8_decode($search);
?>
<style type="text/css">
<!--
.disclaimer {
	font-size: 12px;
}
.textsize {
	font-size: 14px;
}
-->
</style>


<table width="100%" border="0" cellpadding="1" cellspacing="5" class="">
  <tr align="center" bordercolor="#000000" class="line1">
    <th>Videos</th>
    <th>Photos</th>
  </tr>
  <tr>
    <td width="50%" align="left" class="line2"><?php include("youtube.php"); ?></td>
    <td align="left" valign="top" class="line2"><?php include("flickrsearch.php"); ?></td>
  </tr>
  <tr>
    <td align="left" class="line2"><a href="http://www.last.fm/group/PandoraFM%2BUsers/forum/33812" target="_blank">Join other people who, like you, enjoy using their music how  they want with the help of PandoraFM. Join the PandoraFM users group at Last.FM.</a></td>
    <td align="left" class="line2"><a href="http://pandorastations.crispynews.com/about#feedspage" target="_blank">Share your station with Pandora Stations, vote and find other Pandora stations to listen to. </a></td>
  </tr>
  <tr>
    <td align="left"class="line2"><a href="#" onClick=go('last','<?php echo $search;?>')>Listen to what other music fans of <?php echo $searchname; ?> also enjoy on Last.FM radio.</a></td>
    <td align="left" class="line2"><a target=_blank href="http://www.last.fm/users/groups/?s_bio=<?php echo $searchlink; ?>&submit.x=0&submit.y=0">Join a group with connections to <?php echo $searchname; ?>. Meet more fans!</a></td>
  </tr>
</table>
<p><?php $init = mysql_connect($dbserver,$dbuser,$dbpass);
mysql_select_db($dbname);

$result = mysql_query("SELECT counter FROM counter");
$counter = mysql_result($result,0);
$counter = number_format(round($counter,-3));
echo "Over $counter other tracks have been submitted to Last.FM profiles through PandoraFM. *  Thanks for being a part of it!";
?>
<p class="disclaimer"> * As of July 1st, 2006.  Does not count cached resubmitted tracks.</p></p>
