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

// CVE stats: graph visualization
echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";

echo "<div><canvas id=\"cve_stats_chart\" style=\"height:30vh; width:90vw\"></canvas></div>\n";

echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

// CVE stats :: graph generation
echo "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>\n";

echo "<script>\n";

// setup start
echo "const labels = [\n";
// 'January', 'February', 'March', 'April', 'May', 'June',
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "'$day', ";
}

echo "];\n";

echo "const data = {\n";
echo "labels: labels,\n";
echo "datasets: [\n";

// dataset_1
echo "{\n";
echo "label: 'All CVE',\n";
echo "backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),\n";
echo "borderColor: Utils.CHART_COLORS.blue,\n";
echo "data: [\n";
// 0, 10, 5, 2, 20, 30, 45
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "'$a_value', ";
}

echo "],\n";
echo "}]\n";

// dataset_2
echo "{\n";
echo "label: 'cvssOver9',\n";
echo "backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),\n";
echo "borderColor: Utils.CHART_COLORS.red,\n";
echo "data: [\n";
// 0, 10, 5, 2, 20, 30, 45
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve_overnine);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = $arr_cve["b_value"];
    echo "'$b_value', ";
}

echo "],\n";
echo "}]\n";

echo "};\n";
// end const data


// echo "const config = {\n";
// echo "type: 'line',\n";
// echo "data,\n";
// echo "options: {}\n";
// echo "};\n";

// start const config
echo "const config = {\n";
echo "type: 'line',\n";
echo "data: data,\n";
echo "options: {\n";
echo "responsive: true,\n";
echo "plugins: {\n";
echo "legend: {\n";
echo "position: 'top',\n";
echo "},\n";
echo "title: {\n";
echo "display: true,\n";
echo "text: 'CVE stats'\n";
echo "}\n";
echo "}\n";
echo "},\n";
echo "};\n";
// end const config

echo "var cve_stats_chart = new Chart(\n";
echo "document.getElementById('cve_stats_chart'),\n";
echo "config\n";
echo ");\n";
echo "</script>\n";

tmpl_footer();

?>
