//20060730 GEK JavaScript functions for PandoraFM Pandora tuner window and control panel
//20060920 GEK Additional functions to support Pandora Events API v2

var artist;
var song;
var seconds = 90;

//Pandora song is played
function pandoraSongPlayed(song, artist, backstageurl) {
	window.paused = 0;
	window.artist = artist;
	window.song = song;
	window.track = song;
	window.backstageurl = backstageurl;
	if (readSetting('timeoutsub') == null) {seconds = 90;} else { window.seconds = readSetting('timeoutsub'); }
	document.getElementById('artistname').innerHTML = "Artist: <a href=# onClick=editTrack('artist')>"+artist+"</a>";
	
	document.getElementById('trackname').innerHTML = "Track: <a href=# onClick=editTrack('track')>"+song+"</a>";
	if (window.submitted != 1) {
		document.getElementById('statustext').innerHTML = "Will be soon submitted to Last.FM.";
	} else {
		document.getElementById('statustext').innerHTML = "";
	}
	document.getElementById('output').innerHTML = "";
	
	if (window.submitted != 1) {countdown();} //Make sure it hasn't already submitted previous to a pause.
	
	if (!window.activetab) {window.activetab='nowplayingtab';}
	if (window.activetab != 'optionstab') { changeTab(window.activetab); }
	top.document.title = artist+" - "+song+" - " + window.pandorastation + " - PandoraFM";
}

function backstageLink() {
	document.getElementById('backstage').innerHTML = '<a class=underline target=_blank href=' + window.backstageurl + '>Instead, click here to go backstage with Pandora for more!</a>';
}

//Tuner is paused.  Take note of the time and keep it for when it's restarted.
function pandoraSongPaused() {
	window.pausedtime = seconds;
	window.ispaused = true;
    clearTimeout(thecountdown);
	document.getElementById('statustext').innerHTML = "The song is paused.";
}

//Song is over.  This could mean it's skipped or it ended on it's own.  Stop the timeout just in case and start over.
function pandoraSongEnded(song, artist) {
	clearTimeout(thecountdown);
	window.paused = 0;
	window.submitted = 0;
}

function pandoraEventsError(errormsg) {
	document.getElementByID('statustext').innerHTML = "Error talking to Pandora: "+ errormsg;
}

function noSubmit() {
	clearTimeout(thecountdown);
	document.getElementById('statustext').innerHTML = "This song will not be submitted to your Last.FM profile.";
}

//Countdown to Last.FM track submission
function countdown() {
	
	if (window.ispaused == true) {
		seconds = window.pausedtime;
		window.ispaused = false;
		document.getElementById('countdownseconds').innerHTML = seconds;
	}
	
	if ( seconds != 0 ) {
		thecountdown = setTimeout(countdown,1000);
		document.getElementById('countdownseconds').innerHTML = seconds;
		seconds = seconds - 1;
	} else {
		document.getElementById('countdownseconds').innerHTML = "00";
		window.paused=0;
		submittrack();
		window.submitted = 1;
	}
}

//Submits track for approval to Last.FM
function submittrack() {
	if (window.submitted != 1) {
		encodedartist = encodeURIComponent(artist);
		encodedsong = encodeURIComponent(song);
		document.getElementById('statustext').innerHTML = "<blink>Submitting...</blink>";
		var myAjax = new Ajax.Updater('statustext',"/submit.php?&artist="+encodedartist+"&song="+encodedsong, {method: 'get', asynchronous: true, evalScripts: true, onComplete: close_waiting});
		window.submitted = "1";
	}
}

// Obfuscated pandora handlers
//eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[(function(e){return d[e]})];e=(function(){return'\\w+'});c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1 q(){3.2("o",1(0){n(0.m,0.9,0.k)});3.2("j",1(0){e()});3.2("f",1(0){g()});3.2("h",1(4){i.c=4.5;7.a.8.d=4.5});3.2("b",1(6){l(6.p)})}',27,27,'songData|function|setEventHandler|Pandora|stationData|stationName|errorData|document|stationtag|artistName|status|EventsError|pandorastation|value|pandoraSongPaused|SongEnded|pandoraSongEnded|StationPlayed|window|SongPaused|songURL|pandoraEventsError|songName|pandoraSongPlayed|SongPlayed|message|pandoraInit'.split('|'),0,{}))

// Init APIv2 handlers
function pandoraInit() {
	//Pandora APIv2 functions
	Pandora.setEventHandler("SongPlayed", function(songData) {
		pandoraSongPlayed(songData.songName,songData.artistName,songData.songURL);
		});
	Pandora.setEventHandler("SongPaused", function(songData) {
		pandoraSongPaused();
		});
	Pandora.setEventHandler("SongEnded", function(songData) {
		pandoraSongEnded();
		});
	Pandora.setEventHandler("StationPlayed", function(stationData) {
		//New station
		window.pandorastation = stationData.stationName;
		document.status.stationtag.value = stationData.stationName;
		});
	Pandora.setEventHandler("EventsError", function(errorData) {
		pandoraEventsError(errorData.message);
		});
}
