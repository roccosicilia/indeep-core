<?php

include("./config.inc.php");
include("./functions.inc.php");

session_check();

// session check
if (!isset($_SESSION["username"]))
{
    tmpl_login($config_title);
}
else
{
    echo "Session active for user " . $_SESSION["username"] . "\n";
}

?>