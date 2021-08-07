<?php

function tmpl_head($title)
{
    echo "<!DOCTYPE html>\n";
    echo "<html lang=\"en\">\n";
    echo "<head>\n";
    echo "<!-- Required meta tags -->\n";
    echo "<meta charset=\"utf-8\">\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n";
    echo "<title>$title</title>\n";
    echo "<!-- plugins:css -->\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/feather/feather.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/mdi/css/materialdesignicons.min.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/ti-icons/css/themify-icons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/typicons/typicons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/simple-line-icons/css/simple-line-icons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/css/vendor.bundle.base.css\">\n";
    echo "<!-- endinject -->\n";
    echo "<!-- Plugin css for this page -->\n";
    echo "<link rel=\"stylesheet\" href=\"vendors/datatables.net-bs4/dataTables.bootstrap4.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"js/select.dataTables.min.css\">\n";
    echo "<!-- End plugin css for this page -->\n";
    echo "<!-- inject:css -->\n";
    echo "<link rel=\"stylesheet\" href=\"css/vertical-layout-light/style.css\">\n";
    echo "<!-- endinject -->\n";
    echo "<link rel=\"shortcut icon\" href=\"images/favicon.png\" />\n";
    echo "</head>\n";
}

?>