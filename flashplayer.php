<?php
#$stream = urlencode($stream); 
if (!autoplay) {$autoplay = "no";}
?>
<!-- START WIMPY BUTTON: Standard HTML -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,47,0" width="25" height="22" id="wimpybutton177">
<param name="movie" value="http://pandorafm.real-ity.com/wimpy.swf" />
<param name="loop" value="false" />
<param name="menu" value="false" />
<param name="quality" value="high" />
<param name="bgcolor" value="#666666" />
<param name="flashvars" value="theFile=<?php echo $stream; ?>&autoplay=<?php echo $autoplay;?>&loopMe=yes&playingColor=00479F&arrowColor=00C400&theBkgdColor=ADADAC&rollOverColor=BA0000&displayRewindButton=no&icecast=25&buttonStyle=square&bufferAudio=10" />
<embed src="http://pandorafm.real-ity.com/wimpy.swf" flashvars="theFile=<?php echo $stream; ?>&autoplay=<?php $autoplay;?>&loopMe=yes&playingColor=00479F&arrowColor=111000&theBkgdColor=ADADAC&rollOverColor=BA0000&displayRewindButton=no&icecast=25&buttonStyle=square&bufferAudio=10" width="25" height="22" bgcolor="#666666" loop="false" menu="false" quality="high" name="wimpybutton177" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
<!-- END WIMPY BUTTON: Standard HTML -->