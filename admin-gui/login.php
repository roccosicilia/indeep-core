<?php

include("./config.inc.php");
include("./functions.inc.php");

// session check
if (!isset($session["username"]))
{
    tmpl_login($config_title);
}
else
{
    echo "Session active for user " . $session["username"] . "\n";
}

?>