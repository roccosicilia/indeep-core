<?php

include("./config.inc.php");
include("./functions.inc.php");

// session check
if (!isset($session["username"]) AND isset($_POST["login_email"]) AND isset($_POST["login_password"]))
{
    $username = addslashes(stripslashes($_POST["login_email"]));
    $password = addslashes(stripslashes(password_hash($_POST["login_password"], PASSWORD_BCRYPT)));
    $sql = "SELECT * FROM users WHERE `username` = '" . $username . "' AND `token` = '" . $password . "' ORDER BY id";
    $res = mysqli_query($dbconn, $sql);
    $arr = mysqli_fetch_assoc($res);

    if ($arr["id"] != Null)
    {
        echo "Welcome, " . $arr["username"];
    }
    else
    {
        echo "Access Denied.";
    }

}
else
{
    echo "Session active for user " . $session["username"] . "\n";
}

?>