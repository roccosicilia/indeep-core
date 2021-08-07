<?php

include("./config.inc.php");
include("./functions.inc.php");

// session check
if (!isset($session["username"]) AND isset($_POST["login_email"]) AND isset($_POST["login_password"]))
{
    $username = addslashes(stripslashes($_POST["login_email"]));
    $res = pg_query($dbconn, "SELECT * FROM users WHERE username = '" . $username . "' ORDER BY id");
    $arr = pg_fetch_assoc($res);

    print_r($arr);

}
else
{
    echo "Session active for user " . $session["username"] . "\n";
}

?>