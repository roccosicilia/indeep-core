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
tmpl_nav($_SESSION["username"]);
tmpl_sidebar();
tmpl_body();


// CVE list CVSS >= 9 (last 15, table format)

echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";
echo "<h4 class=\"card-title\">Striped Table</h4>\n";
echo "<p class=\"card-description\">Add class <code>.table-striped</code></p>\n";
echo "<div class=\"table-responsive\">\n";
echo "<table class=\"table table-striped\">\n";

echo "<thead>\n";
echo "<tr>\n";
echo "<th> CVE </th>\n";
echo "<th> Publishing Date </th>\n";
echo "<th> Last Update </th>\n";
echo "<th> Score </th>\n";
echo "<th> Vendor </th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

$sql = "SELECT * FROM `cve` WHERE `cvss` >= 7 ORDER BY `id`,`cvss` DESC LIMIT 15";
$res = mysqli_query($dbconn, $sql);

while ($arr = mysqli_fetch_assoc($res))
{
    if ($arr["cvss"] >= 7) { $color = 'purple';}
    if ($arr["cvss"] >= 8) { $color = 'orange';}
    if ($arr["cvss"] >= 9) { $color = 'orangered';}
    if ($arr["cvss"] >= 9.5) { $color = 'red';}

    echo "<tr>\n";
    echo "<td> " . $arr["cve_id"] . " </td>\n";
    echo "<td> " . $arr["date_published"] . " </td>\n"; 
    echo "<td> " . $arr["date_modified"] . " </td>\n";
    echo "<td style=\"color: $color\"> <b>" . $arr["cvss"] . "</b> </td>\n";
    echo "<td> :: </td>\n";
    echo "</tr>\n";
}

echo "</tbody>\n";
echo "</table>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

tmpl_footer();

?>
