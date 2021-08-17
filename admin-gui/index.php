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

// include script
echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js\"></script>\n";

// CVE stats :: graph generation
echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";

echo "<canvas id=\"line-chart\" height=\"50px\"></canvas>\n";

echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

echo "<script>\n";
echo "new Chart(document.getElementById(\"line-chart\"), {\n";
echo "type: 'line',\n";

echo "data: {\n";
echo "labels:\n";

// [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
echo "[";
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "'$day',";
}
echo "],\n";

echo "datasets: [{\n";
echo "data: \n";

// [86,114,106,106,107,111,133,221,783,2478],
echo "[";
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "$a_value,";
}
echo "],\n";

echo "label: \"All CVE\",\n";
echo "borderColor: \"#3e95cd\",\n";
echo "fill: false\n";
echo "}, {\n";
echo "data:\n";

// [282,350,411,502,635,809,947,1402,3700,5267],
echo "[";
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "$b_value,";
}
echo "],\n";

echo "label: \"CVSS > 9\",\n";
echo "borderColor: \"#8e5ea2\",\n";
echo "fill: false\n";
echo "}\n";
echo "]\n";
echo "},\n";
echo "options: {\n";
echo "title: {\n";
echo "display: true,\n";
echo "text: 'CVE stats'\n";
echo "}\n";
echo "}\n";
echo "});\n";
echo "</script>\n";
  





// CVE stats: graph visualization


tmpl_footer();

?>
