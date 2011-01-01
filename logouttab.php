<?php

setcookie("logincookie[username]","",time() - 3600);
setcookie("logincookie[password]","",time() - 3600);

header("LOCATION: http://pandorafm.real-ity.com/");

?>
