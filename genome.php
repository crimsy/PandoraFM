    <?php 
    #20061101 GEK Pandora Music Genome scraping via backstage URL
    # lynx is used just because it's so much faster.  There's already too much slowness going on by using curl libraries.  I'm not proud of this.
	$url = $_GET['backstage'];
	#$url = 'http://www.pandora.com/music/song/a8efd046f8b1fa14';
	$output = strip_tags(`lynx --source $url`,'<br>');
if (!strstr($output,"Lynx") || $output != "") {
	if (strstr($output, "Features Of This Song")) {
		echo "This song has ";
		$start = strpos($output, "Features Of This Song") + 22;
		$end = strpos($output, "These are just a few") - $start - 15;

		$output = trim(substr($output,$start,$end));
		$output = str_replace("<br>", ", ", $output);
		$output = substr($output,0,-2) . ".  ";

		echo $output;
		echo "View more about this song by <a target=_blank href=$url class=underline>going backstage at Pandora.com</a><br>";
	}
}
?>
