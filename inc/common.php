<?php

include("errors.inc");
include("checklogin.inc");
?>
var username = "<?php echo $username;?>";
var password = "<?php echo $password;?>";
songcount = 0;

function refresh(artist,track) {
	if (artist && track) {
		window.artist = artist;
		window.track = track;
		if (parent.bottomFrame.window.activetab != 'optionstab' || parent.bottomFrame.window.activetab != 'helptab' && parent.bottomFrame.window.activetab != '') { changeTab(); }
		document.getElementById('artistname').innerHTML = "Artist: "+artist;
		document.getElementById('trackname').innerHTML = "Track: "+track;
		document.getElementById('statustext').innerHTML = "Is currently playing on Last.FM Radio";
		document.getElementById('countdownseconds').innerHTML = "";
		document.getElementById('output').innerHTML = "";
		
		parent.topFrame.getBanner();
	}
}

function editTrack(what) {
	if (mode == 'pandora') {
		clearTimeout(thecountdown);
		if (what == 'artist') { document.getElementById('artistname').innerHTML = 'Artist: <input class="tagdropdown" type="text" id="newartist" name="newartist" value="' + artist + '"/><button onClick=saveEdit("artist",$F("newartist"))>Save</button>'; }
		if (what == 'track') { document.getElementById('trackname').innerHTML = 'Track: <input class="tagdropdown" type="text" id="newtrack" name="newtrack" value="'+ track + '" /><button onClick=saveEdit("song",$F("newtrack"))>Save</button>'; }
	}
}

function saveEdit(what,value) {
	window[what] = value;
	document.getElementById('artistname').innerHTML = "Artist: <a href=# onClick=editTrack('artist')>"+artist+"</a>";
	document.getElementById('trackname').innerHTML = "Track: <a href=# onClick=editTrack('track')>"+song+"</a>";
	document.getElementById('statustext').innerHTML = "<button onClick=submittrack()>Submit edited track</button>";
}

function panelInit() {
	//Turn on quicktag button if enabled
	if (readSetting('quicktagon') == 'Yes' && readSetting('quicktag') != "") {
	} else {
			document.getElementById('quicktagbutton').style.visibility = "hidden";
	}
	
	if (mode == "pandora") { pandoraInit(); }
}
//Change the active tab and load content into the dynamic (dyncontent div) content area
function changeTab(tabname) {
	if (!artist && tabname != 'helptab') { document.getElementById('output') = "I haven't seen a song start playing yet.  This tab may not work until one does." }
	if (!window.activetab && window.panelmode == 'advpanel') {window.activetab = "nowplayingtab";}
	if (!tabname && window.panelmode != 'simplepanel') {tabname = window.activetab;}
	if (window.panelmode == 'simplepanel') {tabname = 'tagtab';}
	randnum = Math.floor ( Math.random () * 100 + 1 );
	parent.topFrame.getBanner();
		document.getElementById('loading').style.visibility = "visible";
		window.activetab = tabname;
		window.oldtab = tabname;
		if (tabname == "recenttab" || tabname == "toptab" || tabname == "optionstab" || tabname == "helptab" || tabname == "stationstab") {
			var myAjax = new Ajax.Updater('dyncontent',tabname+".php", {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		}
		
		if (tabname == "socialtab") {
			var myAjax = new Ajax.Updater('dyncontent',"socialtab.php?search="+artist, {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		}

		if (tabname == "nowplayingtab") {
			var myAjax = new Ajax.Updater('dyncontent',"artistpopup.php?mode=pandora&artist="+encodeURIComponent(window.artist)+"&backstage="+window.backstageurl, {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		}
		
		if (tabname == "tagtab") {
			var myAjax = new Ajax.Updater('dyncontent',"votepopup.php?mode=pandora", {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		}

		if (tabname == "similartab") {
			var myAjax = new Ajax.Updater('dyncontent',"similartab.php?artist="+artist, {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		}
	
}

//Close the "loading" box
function close_waiting() {
	document.getElementById('loading').style.visibility = "hidden";
}

function recommend_track(usertorecommend) {
	var myAjax = new Ajax.Updater( 'output',"/lastxmlrpc.php?command=recommendTrack&username=<?php echo $username;?>&pass=<?php echo $password;?>&artist="+artist+"&track="+track+"&recipient="+usertorecommend+"&trackurl="+window.backstageurl+"&station="+window.pandorastation, {method: 'get', asynchronous: true, evalScripts: true} );
}

function show_popup_field() {
	document.getElementById('popupfield').innerHTML = '<input onClick="document.getElementById(\'popupfield\').value=\'\'" TITLE="header=[Recommend] body=[Type in a Last.FM user or an email address to recommend this song to.] delay=[800] fade=[off] fadespeed=[0.04] fixedrelx=[0] fixedrely=[0] cssheader=[popupheader] cssbody=[popupbody]" name="popupfield" class="tagdropdown" type="text" size="15" id="popupfield" value="user or email"/><input name="Send" class="tagdropdown" type="button" id="Send" onclick="recommend_track(document.voteform.popupfield.value)" value="Recommend" />';
}

function loveban(xmlrpccommand) {
	if (xmlrpccommand == 'loveTrack') {
		if (readSetting('lovetag') == "Yes") {
			//tagTrack('Loved',artist,track);
			settag('Loved','track');
		}
	}
	var getXMLRPC = new Ajax.Updater( 'output',"/lastxmlrpc.php?command="+xmlrpccommand+"&username=<?php echo $username;?>&pass=<?php echo $password;?>&artist="+artist+"&track="+track, {method: 'get', asynchronous: true, evalScripts: true} );
	document.getElementById('statustext').innerHTML = "You told Last.FM to " + xmlrpccommand + " " + artist + " - " + track;
}

function settag(valuemethod,tagoption) {
	
	
	if (valuemethod == "dropdown" && document.voteform.tag.value == "") { return;}
	if (valuemethod == "newtag" && document.voteform.tag.value != "") {return;}
	
	if (valuemethod == "dropdown") {
		tagname = document.voteform.tag.value;
		if (tagname == "-OTHER-") {
			tagname = document.voteform.newtag.value;
		}
	}
	
	if (valuemethod == "newtag") {
		tagname = document.voteform.newtag.value;
	}
	
	if (valuemethod == "quicktag") {
		tagname = readSetting('quicktag');
	}
	
	if (valuemethod == "stationtag") {
		tagname = window.pandoratation;
	}
	
	if (valuemethod == "Loved") {
		tagname = "Loved";
	}
		
	if (tagname != "0" || tagname != -1 || tagname != "" || tagname != "-OTHER-") { 
		
		//Tag track or just the artist?
		
		if (!tagoption) {
			tagoption = readSetting('tagoption');
		}
		
		if (tagoption == 'track') {
			tagsyntax = "artist="+encodeURIComponent(artist)+"&track="+encodeURIComponent(track)+"&command=tagTrack";
			tagged = artist + " - " + track;
		} else {

			tagsyntax = "artist="+encodeURIComponent(artist)+"&command=tagArtist";
			tagged = artist;
		}
		
		document.getElementById('statustext').innerHTML = tagged+" has been tagged as "+tagname.replace(/\+/g," ");
		var myAjax = new Ajax.Updater('output',"lastxmlrpc.php?"+tagsyntax+"&tag="+tagname, {method: 'get', asynchronous: true});
	}
}

function tagTrack(tagname,artist,track) {
	if (tagname != 0 || tagname !== -1 || tagname !== "" || tagname !== "-OTHER-") {
		var myAjax = new Ajax.Updater('output',"tag.php?artist="+artist+"&track="+track+"&tag="+tagname+"&username="+username+"&password="+password, {method: 'get', asynchronous: true});
	}
}

// Save a single option
function saveSetting(setting,value) {
	theDate = new Date();
	//Set the options cookie for one year
	//theDate.setTime(theDate.getTime()+(<?php echo strtotime("+1 year"); ?>));
	//expires = theDate.toGMTString;
	theDate.setTime(theDate.getTime()+ 365 * 24 * 60 * 60 * 1000);
	expires = theDate.toGMTString;
	document.cookie = setting+"=" + value + "; expires=" + expires + "; path=/";
}
// Saves cookies with user defined settings.
function saveSettings() {

	timeoutsub = $F('timeoutsub');
	//timeouttag = $F('timeouttag');
	//autotagon = $F('autotagon');
	quicktagon = $F('quicktagon');
	quicktag = $F('quicktag');
	//autotag = $F('autotag');
	lovetag = $F('lovetag');
	radiopct = $F('radiopct');
	tooltips = $F('tooltips');
	panelmode = $F('panelmode');
	pandorauser = $F('pandorauser');
	tagoption = $F('tagoption');
	sorttags = $F('sorttags');
	
	if (quicktagon == 'Yes' && quicktag == '') {alert('You must have a tag for quicktag.  Or turn it off.');}

	if (quicktagon == 'Yes') {
		document.getElementById('quicktagbutton').style.visibility = "visible";
		document.getElementById('qtbutton').value = quicktag;
	}
	
	if (quicktagon != 'Yes') {
		document.getElementById('quicktagbutton').style.visibility = "hidden";
	}
	
	theDate = new Date();
	savestring = "timeoutsub="+timeoutsub+"&quicktagon="+quicktagon+"&quicktag="+quicktag+"&lovetag="+lovetag+"&radiopct="+radiopct+"&tooltips="+tooltips+"&panelmode="+panelmode+"&pandorauser="+pandorauser+"&tagoption="+tagoption+"&sorttags="+sorttags;
	var myAjax = new Ajax.Updater( 'output',"savesetting.php?"+savestring, {method: 'get', asynchronous: true, evalScripts: true} );
	
}

// Parses document.cookie object for specific values.  Used for getting user defined settings.
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

function trackOptions(artist,track) {
	var myAjax = new Ajax.Updater( 'dyncontent','trackoptions.php?artist='+artist+"&track="+track, {method: 'get', asynchronous: true});
}

function refreshPane() {
	window.location.reload( false );
}

function go(player,artist) {
	document.cookie = "playerload=" + artist + "; path=/";
	parent.topFrame.location.href="playerchoice.php?switchtab="+player;
	if (player == 'pandora') { parent.mainFrame.location.href='http://www.pandora.com/?searchFilter=artist&search='+artist; }
	if (player == 'last') { parent.mainFrame.location.href='lastplayer.php?artist='+artist; }
	parent.bottomFrame.location.href='panel.php?mode='+player;
	
}
