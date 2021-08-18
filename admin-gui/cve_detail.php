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
        $sql = "SELECT * FROM `cve` WHERE `cve_id` = '" . $cveid . "' ORDER BY `id` DESC";
        $res = mysqli_query($dbconn, $sql);
        $arr = mysqli_fetch_assoc($res);

        $json = $arr["info"];
        $info = json_decode($json);

        // debug
        echo "<!-- get VCE data: $sql -->\n";

        // CVE datail table
        echo "<div class=\"col-lg-12 grid-margin stretch-card\">\n";
        echo "<div class=\"card\">\n";
        echo "<div class=\"card-body\">\n";
        echo "<h4 class=\"card-title\">View " . $arr["cve_id"] . " details</h4>\n";
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
        if (($arr["cvss"] >= 7)   AND ($arr["cvss"] != 'None')) { $color = 'purple';}
        if (($arr["cvss"] >= 8)   AND ($arr["cvss"] != 'None')) { $color = 'orange';}
        if (($arr["cvss"] >= 9)   AND ($arr["cvss"] != 'None')) { $color = 'orangered';}
        if (($arr["cvss"] >= 9.5) AND ($arr["cvss"] != 'None')) { $color = 'red';}

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
        echo "<td style=\"width: 20%\"> Publishing Date </td>\n";
        echo "<td> " . $arr["date_published"] . " </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> CPE(s) </td>\n";
        echo "<td><select class=\"form-control form-control-lg\" id=\"cpe_list\">\n";
        for ($i=0; $i<count($cpe_list); $i++)
        {
            echo "<option>" . $cpe_list[$i] . "</option>\n";
        }
        echo "</select></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Description </td>\n";
        echo "<td> " . $arr["description"] . " </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> References </td>\n";
        echo "<td> " . $arr["cve_references"] . " </td>\n";
        echo "</tr>\n";

        echo "<form action=\"\" method=\"POST\">\n";
        echo "<input type=\"hidden\" name=\"cve_id\" value=\"$cveid\" />\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Analysis </td>\n";
        echo "<td> <textarea name=\"cve_analysis\" style=\"width: 100%; border: 1px solid #dee2e6; font-weight: 400; font-size: 0.875rem; border-radius: 4px; height: 5rem;\"></textarea> </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\">  </td>\n";
        echo "<td><input type=\"submit\" value=\"Ack and Save\" class=\"btn btn-light me-2\" /></td>\n";
        echo "</tr>\n";
        echo "</form>\n";

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
