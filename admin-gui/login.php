<?php

include("./functions.inc.php");
include("./config.inc.php");

// session check
if (!isset($session["username"]))
{
    tmpl_login($title);
}
else
{
    echo "reg.";
}

?>