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
tmpl_nav($_SESSION["username"], "Dashboard");
tmpl_sidebar();
tmpl_body();

// CVE stats :: graph generation
echo "<script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>\n";
echo "<script type=\"text/javascript\">\n";
echo "google.charts.load('current', {'packages':['corechart']});\n";
echo "google.charts.setOnLoadCallback(drawChart);\n";

echo "function drawChart() {\n";
echo "var data = google.visualization.arrayToDataTable([\n";
echo "['Day', 'CVE', 'CVSS 9'],\n";

// ['2004',  1000,      400],
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "['$day', $a_value, $b_value],\n";
}

echo "]);\n";
echo "var options = {\n";
echo "title: 'CVE stats',\n";
echo "curveType: 'function',\n";
echo "legend: { position: 'bottom' }\n";
echo "};\n";
echo "var chart = new google.visualization.LineChart(document.getElementById('cve_stats_chart'));\n";
echo "chart.draw(data, options);\n";
echo "}\n";
echo "</script>\n";

// CVE stats: graph visualization
/// echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
// echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";

echo "<div id=\"cve_stats_chart\" style=\"width: 90vw; height: 30vh;\"></div>\n";

echo "</div>\n";
// echo "</div>\n";
// echo "</div>\n";

tmpl_footer();

?>
