<?php
#20060924 GEK The way cookies were saved before sucks.  Rewriting it here.
$expire = time()+3600;
array_walk($_GET, 'saveSetting');

function saveSetting ($value,$setting) {
	setcookie($setting,$value,time()+30758400);
	$status = $status . ", $setting";
}

echo "$status Saved.";

#print_r($_COOKIE);
?>
