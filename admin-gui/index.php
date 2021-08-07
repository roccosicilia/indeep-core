<?php

include("./config.inc.php");
include("./functions.inc.php");

session_check();

// session check
if (!isset($session["username"]))
{
    header("location: ./login.php");
}

tmpl_head($config_title);

echo "INDEX";



?>
