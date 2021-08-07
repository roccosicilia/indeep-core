<?php

include("./config.inc.php");
include("./functions.inc.php");

// session check
if (!isset($session["username"]) AND isset($_POST["login_email"]) AND isset($_POST["login_password"]))
{
    $username = addslashes(stripslashes($_POST["login_email"]));
    $password = addslashes(stripslashes($_POST["login_email"]));
    $sql = "SELECT * FROM users WHERE `username` = '" . $username . "' ORDER BY id";
    $res = mysqli_query($dbconn, $sql);
    $arr = mysqli_fetch_assoc($res);

    $verify_token = password_verify($password, $arr["token"]);

    if ($verify_token)
    {
        echo "Welcome, " . $arr["username"];
    }
    else
    {
        echo "Access Denied.<br />\n";
        echo $username . "<br />\n";
        echo $password . "<br />\n";
    }

}
else
{
    echo "Session active for user " . $session["username"] . "\n";
}

?>