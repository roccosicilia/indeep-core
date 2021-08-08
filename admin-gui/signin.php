<?php

include("./config.inc.php");
include("./functions.inc.php");

session_check();

// session check
if (!isset($_SESSION["username"]) AND isset($_POST["login_email"]) AND isset($_POST["login_password"]))
{
    $username = addslashes(stripslashes($_POST["login_email"]));
    $password = addslashes(stripslashes($_POST["login_password"]));
    $sql = "SELECT * FROM `users` WHERE `username` = '" . $username . "' ORDER BY `id`";
    $res = mysqli_query($dbconn, $sql);
    $arr = mysqli_fetch_assoc($res);

    $verify_token = password_verify($password, $arr["token"]);

    if ($verify_token)
    {
        echo "Welcome, " . $arr["username"];
        $_SESSION["username"] = $arr["username"];
        $sql = "UPDATE users SET `lastlogin` = '" . time() . "' WHERE `id` = '" . $arr['id'] . "'";
        $res = mysqli_query($dbconn, $sql);
        header("location: ./index.php");
    }
    else
    {
        echo "Access Denied.<br />\n";
        header("location: ./login.php");
    }

}
else
{
    echo "Session active for user " . $_SESSION["username"] . "\n";
}

?>