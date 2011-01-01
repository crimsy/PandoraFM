<?php

#20060708 GEK JavaScript Functions called in the PandoraFM Last.FM radio player.
?>
username = "<?php echo $username; ?>";
password = "<?php echo $password; ?>";

setTimeout(refresh_status,2000);

var trackprogress = 0;
var artistold = "";


function refresh_timer() {
	refresh_status();
	
}

function clearstationbox() {
	newstation.stations.value="";
}

function skip() {
	getAjaxURL("http://ws.audioscrobbler.com/radio/control.php?session=<?php echo $sessionname; ?>&command=skip");
	refresh_status();
}


function changestation(station) {
	document.getElementById('newstation').value = station;
	station = encodeURIComponent(station);
	if (station != 0) {
		getAjaxURL("http://ws.audioscrobbler.com/radio/adjust.php?session=<?php echo $sessionname; ?>&url="+station);
		close_popup_stations()
	}
}

function getAjaxURL(lasturl) {
	lasturl = encodeURIComponent(lasturl);
	//http( "GET" , "accessurl.php?url="+lasturl,ajaxresponse);
	//var myAjax = new Ajax.Request( "accessurl.php?url="+lasturl, {method: 'get', onComplete: ajaxresp} );
	var myAjax = new Ajax.Updater( 'output',"accessurl.php?url="+lasturl, {method: 'get', asynchronous: true, evalScripts: true} );
	refresh_status();
}

var ajaxresp = function ajaxresponse(request) {
	alert(request.responseText);
}
function popup_stations() {
	document.getElementById('morestations').style.visibility = "visible";
	perouter.style.visibility="hidden";
}

function close_popup_stations() {
	document.getElementById('morestations').style.visibility = "hidden";
	perouter.style.visibility="visible";
}

function show_popup_field() {
	document.getElementById('popupfield').innerHTML = '<input name="popupfield" class="tagdropdown" type="text" size="10" id="popupfield" /><input name="Send" class="tagdropdown" type="button" id="Send" onclick="recommend_track(document.voteform.popupfield.value)" value="Submit" />';
}

//function recommend_track(usertorecommend) {
//	var myAjax = new Ajax.Updater( 'output',"lastxmlrpc.php?command=recommendTrack&username=<?php echo $username;?>&pass=<?php echo $password;?>&artist="+artist+"&track="+track+"&recipient="+usertorecommend, {method: 'get', asynchronous: true, evalScripts: true} );
//}

function popup_artist() {
	perouter.style.visibility="hidden";
	var myAjax = new Ajax.Updater( 'popup',"artistpopup.php?artist="+artist, {method: 'get'} );
	//Rico.Corner.round('popup', {color:"transparent"});
	//setTimeout(document.getElementById('popup').style.visibility = "visible",2000);
	//Rico.Corner.round('popup',{corners:'all',color:'fromElement',bgColor:'fromParent',blend:true,border:,compact:});
	document.getElementById('popup').style.visibility = "visible";
	perouter.style.visibility="hidden";
}

function popup_artist_close() {
	document.getElementById('popup').style.visibility = "hidden";
	perouter.style.visibility="visible";
}

function showerror(errormsg) {
	document.getElementById('errorbox').style.visibility = "visible";
	errormsg = errormsg + "<br>Is this maybe a radio feature that only subscribers have access to, and <a href=http://www.last.fm/subscribe/>you haven't subscribed yet?</a>";
	document.getElementById('errormessage').innerHTML = errormsg;
}

function hideerror() {
	document.getElementById('errorbox').style.visibility = "hidden";
}

function updateInfo() {
	refreshtimer = setTimeout(refresh_status,10000);
	if (streaming == "false") {
		perouter.style.visibility="hidden"
		document.getElementById('artistdiv').innerHTML = "Press Play to";
		document.getElementById('trackdiv').innerHTML = "Listen to Last.FM";
		document.getElementById('albumdiv').innerHTML = "  ";
		document.getElementById('coverartdiv').innerHTML = '<img height="120" width="120" src="images/pandorafmlogo.jpg" />';
		document.getElementById('stationname').innerHTML = "PandoraFM Player";
		return;
	}
	
	window.artist = artist;
	window.track = track;
		
	//New song.  Do things.
	if (window.track != window.originaltrack && typeof window.track != 'undefined') {
		parent.bottomFrame.refresh(artist,track);
		//parent.bottomFrame.changeTab(parent.bottomFrame.activetab);
		var myAjax = new Ajax.Updater('output', "/submit.php?nosubmit=1&username="+username+"&artist="+artist+"&song="+track, {method: 'get', asynchronous: true});
		window.originaltrack = window.track;
		if (artist) {top.document.title = artist+" - "+track+" - PandoraFM";}
		
		if (albumcover_medium == 'http://static.last.fm/depth/catalogue/no_album_large.gif') {
			albumcover_medium = 'images/pandorafmlogo.jpg';
		}
		
		document.getElementById('artistdiv').innerHTML = "<a href=# onClick=popup_artist()>"+artist+"</a>";
		document.getElementById('stationname').innerHTML = station;
		document.getElementById('trackdiv').innerHTML = track;
		document.getElementById('albumdiv').innerHTML = album;
		document.getElementById('coverartdiv').innerHTML = "<img width=120 height=120 onmouseover=vote_popup() src="+albumcover_medium+">";
		perouter.style.visibility="visible";
		trackduration = parseInt(trackduration);
		window.tracktime = trackduration * 1000;
		thedate = new Date();
		window.starttime = thedate.getTime();
		window.endtime = window.starttime + window.tracktime;
		
	}
		
	//Magic to try and make the progress bar work.
	var currenttime = new Date();
	nowseconds = currenttime.getTime();
	trackremaining = Math.round(Math.round(window.endtime - nowseconds) / 1000) - 7;
	percentremaining = (trackremaining / trackduration) * 100;
	setCount(percentremaining);
	//alert(trackremaining);
	//trackprogress = trackprogress + 10;
	
	if (station.substr(0,5) == "Group") {
		//station = station + " via " + stationfeed;
	}
	
	if (station.substr(8,9) == "Neighbour") {
		//station = station + " via " + stationfeed;
	
	}
	
	
}

function refresh_status() {
	if (window.playartist && !window.noplayartist) {
		window.playartist = encodeURIComponent(window.playartist);
		document.getElementById('newstation').value = "lastfm://artist/"+decodeURIComponent(window.playartist)+"/similarartists";
		window.noplayartist = '0';
		changestation("lastfm://artist/"+decodeURIComponent(window.playartist)+"/similarartists");
	}
	
	randnumini = Math.floor ( Math.random () * 100 + 1 );
	var myAjax = new Ajax.Updater('output',"/parseini.php?"+randnumini, {method: 'get', asynchronous: true, evalScripts: true, onComplete: updateInfo});
}

function goPandora(search) {
	//var artist = encodeURIComponent(artist);
	//var track = encodeURIComponent(track);
	
	if (search == "artist") {
		self.location.href="http://pandorafm.real-ity.com/pandorafm.php?artist="+artist;
		alert("Going to pandora");
	}
	
	if (search == 'track') {
		self.location.href="http://pandorafm.real-ity.com/pandorafm.php?track="+track;
	}
}

function vote_popup() {
	var myAjax = new Ajax.Updater('votepopup',"votepopup.php?username=<?php echo $username; ?>"+"&artist="+artist+"&track="+track, {method: 'get', asynchronous: true, evalScripts: true});
	document.getElementById('votepopup').style.visibility = "visible";
	closevote = setTimeout(popup_vote_close,10000);
	//Rico.Corner.round('votepopup',{corners:"top"});
	perouter.style.visibility="hidden"
}

function popup_vote_close() {
	//if (closevote) { clearTimeout(closevote); }
	//closevote = setTimeout(popup_vote_close,5000);
	document.getElementById('votepopup').style.visibility = "hidden";
	perouter.style.visibility="visible"
}

//function settag(valuemethod) {
//	if (valuemethod == "dropdown") {
//		tagname = document.voteform.tag.value;
//	}
//	
//	if (valuemethod == "newtag") {
//		tagname = document.voteform.newtag.value;
//	}
//	
//	if (tagname != 0 || tagname !== -1 || tagname !== "") {
//		var myAjax = new Ajax.Updater('output',"tag.php?artist="+artist+"&track="+track+"&tag="+tagname+"&username="+username+"&password="+password, {method: 'get', asynchronous: true});
//	}
//}

var wimpySwf = "http://pandorafm.real-ity.com/laststream/wimpy.swf";
function writeWimpyButton(theFile, wimpyWidth, wimpyHeight, wimpyConfigs){
	var myid = Math.round((Math.random()*1000)+1);
	var flashCode = "";
	var newlineChar = "\n";
	flashCode += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,47,0" width="'+wimpyWidth+'" height="'+wimpyHeight+'" id="wimpybutton'+myid+'">'+newlineChar;
	flashCode += '<param name="movie" value="'+wimpySwf+'" />'+newlineChar;
	flashCode += '<param name="loop" value="" />'+newlineChar;
	flashCode += '<param name="menu" value="" />'+newlineChar;
	flashCode += '<param name="quality" value="high" />'+newlineChar;
	flashCode += '<param name="wmode" value="transparent" />'+newlineChar;
	flashCode += '<param name="flashvars" value="theFile='+theFile+wimpyConfigs+'" />'+newlineChar;
	flashCode += '<embed src="'+wimpySwf+'" width="'+wimpyWidth+'" height="'+wimpyHeight+'" flashvars="theFile='+theFile+wimpyConfigs+'" wmode="transparent" loop="" menu="" quality="high" name="wimpybutton'+myid+' align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>'+newlineChar;
	//document.write('<br><textarea name="textarea" cols="40" rows="10">'+flashCode+'</textarea><br>')+newlineChar;
	document.write(flashCode);
}

function checkForStation() {
	if (artist) {
		
	}
}

