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
echo "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>\n";

echo "<script>\n";
echo "const labels = [\n";

// 'January', 'February', 'March', 'April', 'May', 'June',
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = 0;
    echo "'$day', ";
}

echo "];\n";

echo "const data = {\n";
echo "labels: labels,\n";
echo "datasets: [{\n";
echo "label: 'My First dataset',\n";
echo "backgroundColor: 'rgb(255, 99, 132)',\n";
echo "borderColor: 'rgb(255, 99, 132)',\n";
echo "data: [\n";
    
// 0, 10, 5, 2, 20, 30, 45
$sql_cve = "SELECT * FROM `cve_stats` WHERE `name` = 'CVE per Day' ORDER BY id ASC LIMIT 0,28";
$res_cve = mysqli_query($dbconn, $sql_cve);
while($arr_cve = mysqli_fetch_assoc($res_cve))
{
    $day = $arr_cve["date"];
    $a_value = $arr_cve["a_value"];
    $b_value = 0;
    echo "'$a_value', ";
}

echo "],\n";
echo "}]\n";
echo "};\n";

echo "const config = {\n";
echo "type: 'line',\n";
echo "data,\n";
echo "options: {}\n";
echo "};\n";

echo "var myChart = new Chart(\n";
echo "document.getElementById('myChart'),\n";
echo "config\n";
echo ");\n";
echo "</script>\n";

// CVE stats: graph visualization
echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
echo "<div class=\"card\">\n";
echo "<div class=\"card-body\">\n";

echo "<div><canvas id=\"myChart\"></canvas></div>\n";

echo "</div>\n";
echo "</div>\n";
echo "</div>\n";

tmpl_footer();

?>
