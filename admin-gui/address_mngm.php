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

// CVE list CVSS >= 9 (last 5, table format)
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
    echo "<td style=\"width: 20%\"> " . $arr["last_check"] . " </td>\n";
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
