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


// CVE list CVSS >= 9 (last 5, table format)

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

$sql = "SELECT * FROM `cve` WHERE `cvss` >= 9 ORDER BY `id` DESC LIMIT 10";
$res = mysqli_query($dbconn, $sql);

while ($arr = mysqli_fetch_assoc($res))
{
    $cvss_score = $arr["cvss"]*10;
    echo "<tr>\n";
    echo "<td> " . $arr["cve_id"] . " </td>\n";
    echo "<td> " . $arr["date_published"] . " </td>\n"; 
    echo "<td> " . $arr["date_modified"] . " </td>\n";
    echo "<td> <div class=\"progress\"><div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width: 25%\" aria-valuenow=\"" . $cvss_score . "\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div></div> </td>\n";
    echo "<td> " . $arr["cvss"] . " </td>\n";
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
