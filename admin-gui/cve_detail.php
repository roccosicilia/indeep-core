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
        echo "<h4 class=\"card-title\"> " . $arr["cve_id"] . " // Score " . $arr["cvss"] . "</h4>\n";
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
        echo "<td style=\"width: 20%\"> Date </td>\n";
        echo "<td> Publishing: " . $arr["date_published"] . " // Last update: " . $arr["date_modified"] . " </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> CPE </td>\n";
        echo "<td><select class=\"form-control form-control-lg\" id=\"cpe_list\">\n";
        for ($i=0; $i<count($cpe_list); $i++)
        {
            echo "<option>" . $cpe_list[$i] . "</option>\n";
        }
        echo "</select></td>\n";
        echo "</tr>\n";

        $summary = str_replace(". ", ".<br />", $arr["description"]);
        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Summary </td>\n";
        echo "<td> " . $summary . " </td>\n";
        echo "</tr>\n";

        $reference = str_replace("u'", "'", $arr["cve_references"]);
        $reference = str_replace("'", "", $reference);
        $reference = str_replace("[", "", $reference);
        $reference = str_replace("]", "", $reference);
        $reference = explode(",", $reference);
        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> References </td>\n";
        echo "<td>\n";
        for ($i=0; $i<count($reference); $i++)
        {
            echo ":: <a href=\"".$reference[$i]."\" target=\"_blank\">".$reference[$i]."</a><br />\n";
        }
        echo "</td>\n";
        echo "</tr>\n";

        $sql_capec = "SELECT * FROM `cve_capec` WHERE `cve_id` = '" . $cveid . "' ORDER BY `id`";
        $res_capec = mysqli_query($dbconn, $sql_capec);
        $num_capec = mysqli_num_rows($res_capec);

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> CAPEC ($num_capec) </td>\n";
        echo "<td>\n";

        if ($num_capec > 0)
        {
            while($arr_capec = mysqli_fetch_assoc($res_capec))
            {
                // $prerequisites = str_replace(". ", ".<br />", $arr_capec["prerequisites"]);
                // $summary = str_replace(". ", ".<br />", $arr_capec["summary"]);
                // $solutions = str_replace(". ", ".<br />", $arr_capec["solutions"]);

                echo ":: <a href=\"./capec_detail.php?id=" . $arr_capec["id"] . "\">" . $arr_capec["name"] . "</a><br />\n";
            }
        }
        else
        {
            echo "None\n";
        }
        
        echo "</td>\n";
        echo "</tr>\n";

        echo "<form action=\"./cve_detail.php?mode=save\" method=\"POST\">\n";
        echo "<input type=\"hidden\" name=\"id\" value=\"" . $arr["id"] . "\" />\n";
        echo "<input type=\"hidden\" name=\"cve_id\" value=\"" . $arr["cve_id"] . "\" />\n";

        if ($arr["analysis"] != null)
        {
            $analysis = str_replace("<br />", "\r\n", $arr["analysis"]);
        }

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"> Analysis </td>\n";
        echo "<td> <textarea name=\"cve_analysis\" style=\"width: 100%; border: 1px solid #dee2e6; font-weight: 400; font-size: 0.875rem; border-radius: 4px; height: 5rem;\">$analysis</textarea> </td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td style=\"width: 20%\"><button type=\"button\" class=\"btn btn-light btn-rounded btn-fw\"><a href=\"./cve_mngm.php\"> &lt;&lt; Back </<a></button></td>\n";
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

    case "save":

        // save analysis
        $id = addslashes(stripslashes($_POST["id"]));
        $cve_id = addslashes(stripslashes($_POST["cve_id"]));
        $ack_date = date("Y-m-d");
        $ack_user = $_SESSION["username"];
        $cve_analysis = addslashes(stripslashes($_POST["cve_analysis"]));
        $cve_analysis = str_replace("\r\n", "<br />", $cve_analysis);
        // debug print
        echo "$id<br />\n";
        echo "$ack_date<br />\n";
        echo "$cve_analysis<br />\n";
        // save query
        $sql_analysis = "UPDATE `cve` SET `analysis` = '$cve_analysis', `ack_date` = '$ack_date', `ack_user` = '$ack_user' WHERE `id` = '$id'";
        $res_analysis = mysqli_query($dbconn, $sql_analysis);
        header("location: ./cve_detail.php?mode=view&id=$cve_id");

        break;

}

tmpl_footer();

?>
