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
tmpl_nav($_SESSION["username"], "CVE detail");
tmpl_sidebar();
tmpl_body();

$mode = addslashes(stripslashes($_GET["mode"]));

switch ($mode)
{

    case "view":

        $cveid = addslashes(stripslashes($_GET["id"]));
        $sql = "SELECT * FROM `cve` WHERE `id` = '" . $cveid . "'";
        $res = mysqli_query($dbconn, $sql);
        $arr = mysqli_fetch_assoc($res);

        $json = $arr["info"];
        $info = json_decode($json);

        // CVE datail table
        echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
        echo "<div class=\"card\">\n";
        echo "<div class=\"card-body\">\n";
        echo "<h4 class=\"card-title\">CVE " . $arr["cve"] . "</h4>\n";
        echo "<div class=\"table-responsive\">\n";
        echo "<table class=\"table table-striped\">\n";

        echo "<thead>\n";
        echo "<tr>\n";
        echo "<th> Data </th>\n";
        echo "<th> Values </th>\n";
        echo "</tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";

        // define CVSS color
        if ($arr["cvss"] >= 7) { $color = 'purple';}
        if ($arr["cvss"] >= 8) { $color = 'orange';}
        if ($arr["cvss"] >= 9) { $color = 'orangered';}
        if ($arr["cvss"] >= 9.5) { $color = 'red';}

        // define CPE
        if ($arr["cpe_list"] != '')
        {
            $cpe_list = explode(",", $arr["cpe_list"]);
            $cpe = explode(":", $cpe_list[0]);
            $cpe_output = $cpe[3] . " :: " . $cpe[4];
        }
        else
        {
            $cpe_output = 'Null';
        }

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Publishing Data </td>\n";
        echo "<td> " . $arr["data_published"] . " </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Description </td>\n";
        echo "<td> " . $info->{'Description'} . " </td>\n";
        echo "</tr>\n";

        echo "</tbody>\n";
        echo "</table>\n";
        echo "</div>\n";
        echo "</div>\n";
        echo "</div>\n";
        echo "</div>\n";
        break;

}

tmpl_footer();

?>
