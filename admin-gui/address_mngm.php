<?php

include("./config.inc.php");
include("./functions.inc.php");

session_check();

// session check
if (!isset($_SESSION["username"]))
{
    header("location: ./login.php");
}

tmpl_head($config_title);
tmpl_nav($_SESSION["username"], "Address Management");
tmpl_sidebar();
tmpl_body();

// check action
if (isset($_GET["action"]))
{
    $action = addslashes(stripslashes($_GET["action"]));
}

if ($action == 'add')
{
    // Add new IP FORM
    echo "<div class=\"col-12 grid-margin stretch-card\">\n";
    echo "<div class=\"card\">\n";
    echo "<div class=\"card-body\">\n";
    echo "<h4 class=\"card-title\">Add new IP address</h4>\n";
    echo "<form class=\"forms-sample\" action=\"./address_mngm.php?action=newip\" method=\"POST\">\n";

    echo "<div class=\"form-group\">\n";
    echo "<label for=\"ipaddress\">IP Address</label>\n";
    echo "<input type=\"text\" class=\"form-control\" id=\"ipaddress\" placeholder=\"AAA.BBB.CCC.DDD\">\n";
    echo "</div>\n";

    echo "<div class=\"form-group\">\n";
    echo "<label for=\"ipreputation\">Reputation</label>\n";
    echo "<select class=\"form-control\" id=\"ipreputation\">\n";
    echo "<option>bad</option>\n";
    echo "<option>neutral</option>\n";
    echo "<option>good</option>\n";
    echo "</select>\n";
    echo "</div>\n";

    echo "<button type=\"submit\" class=\"btn btn-light me-2\">Submit</button>\n";
    echo "<button class=\"btn btn-light\">Cancel</button>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
}

if ($action == 'newip')
{
    $newip = addslashes(stripslashes($_POST["ipaddress"]));
    $reputation = addslashes(stripslashes($_POST["ipreputation"]));
    $creation_date = date("Y-m-d");
    $lastcheck = $creation_date;

    $sql = "INSERT INTO `ipreputation` (`ipaddress`, `reputation`, `creation_date`, `lastcheck`) VALUES ('" . $newip . "', '" . $reputation . "', '" . $creation_date . "', '" . $lastcheck . "')";
    $res = mysqli_query($dbconn, $sql);

    // debug
    print_r($_POST);

}



// IP reputation list
echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";
echo "<h4 class=\"card-title\">IP reputation list (last 50) </h4>\n";
echo "<div class=\"table-responsive\">\n";
echo "<table class=\"table table-striped\">\n";

echo "<thead>\n";
echo "<tr>\n";
echo "<th> Address </th>\n";
echo "<th> Creation date </th>\n";
echo "<th> Last check </th>\n";
echo "<th> Reputation </th>\n";
echo "<th> Info </th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

$sql = "SELECT * FROM `ipreputation` ORDER BY `id` DESC LIMIT 50";
$res = mysqli_query($dbconn, $sql);

while ($arr = mysqli_fetch_assoc($res))
{
    // define CVSS color
    if ($arr["reputation"] == 'bad') { $color = 'red';}
    if ($arr["reputation"] == 'good') { $color = 'green';}
    if ($arr["reputation"] == 'neutral') { $color = 'orange';}

    echo "<tr>\n";
    echo "<td style=\"width: 20%\"> <a href=\"./cve_detail.php?mode=view&id=" . $arr["id"] . "\">" . $arr["ipaddress"] . "</a> </td>\n";
    echo "<td style=\"width: 20%\"> " . $arr["creation_date"] . " </td>\n"; 
    echo "<td style=\"width: 20%\"> " . $arr["lastcheck"] . " </td>\n";
    echo "<td style=\"width: 10%; color: $color\"> <b>" . $arr["reputation"] . "</b> </td>\n";
    echo "<td> null </td>\n";
    echo "</tr>\n";
}

echo "<tr>\n";
echo "<td colspan=\"5\"><button type=\"button\" class=\"btn btn-light btn-rounded btn-fw\"><a href=\"./address_mngm.php?action=add\"> Add </<a></button></td>\n";
echo "</tr>\n";
echo "</tbody>\n";
echo "</table>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

tmpl_footer();

?>
