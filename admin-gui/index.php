<?php

include("./functions.inc.php");
include("./config.inc.php");

// session check
if (!isset($session["username"]))
{
    header("location: ./login.php");
}

tmpl_head($config_title);



?>
