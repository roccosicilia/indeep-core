<?php

// DB connection
$dbconn = pg_connect("host=$dbhost port=5432 dbname=$dbname user=$dbuser password=$dbpass");

function session_check($pagename)
{
    session_start();
    
    if ($_SESSION["username"] != null)
    {
        $username = $_SESSION["username"];
    }
    else
    {
        $username = "guest";
    }

    $visited_page = $pagename;
    $visited_time = now();
}

function tmpl_login($title)
{
    echo "<!DOCTYPE html>\n";
    echo "<html lang=\"en\">\n";
    echo "<head>\n";
    echo "<!-- Required meta tags -->\n";
    echo "<meta charset=\"utf-8\">\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n";
    echo "<title>$title</title>\n";
    echo "<!-- plugins:css -->\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/feather/feather.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/mdi/css/materialdesignicons.min.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/ti-icons/css/themify-icons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/typicons/typicons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/simple-line-icons/css/simple-line-icons.css\">\n";
    echo "<link rel=\"stylesheet\" href=\"./vendors/css/vendor.bundle.base.css\">\n";
    echo "<!-- endinject -->\n";
    echo "<!-- Plugin css for this page -->\n";
    echo "<!-- End plugin css for this page -->\n";
    echo "<!-- inject:css -->\n";
    echo "<link rel=\"stylesheet\" href=\"./css/vertical-layout-light/style.css\">\n";
    echo "<!-- endinject -->\n";
    echo "<link rel=\"shortcut icon\" href=\"./images/sheliak_favicon.jpg\" />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<div class=\"container-scroller\">\n";
    echo "<div class=\"container-fluid page-body-wrapper full-page-wrapper\">\n";
    echo "<div class=\"content-wrapper d-flex align-items-center auth px-0\">\n";
    echo "<div class=\"row w-100 mx-0\">\n";
    echo "<div class=\"col-lg-4 mx-auto\">\n";
    echo "<div class=\"auth-form-light text-left py-5 px-4 px-sm-5\">\n";
    echo "<div class=\"brand-logo\">\n";
    // echo "<img src=\"./images/logo.svg\" alt=\"logo\">\n";
    echo "</div>\n";
    echo "<h4>Login Page</h4>\n";
    echo "<h6 class=\"fw-light\">Sign in to continue.</h6>\n";
    echo "<form action=\"./signin.php\" method=\"POST\" class=\"pt-3\">\n";
    echo "<div class=\"form-group\">\n";
    echo "<input type=\"email\" class=\"form-control form-control-lg\" id=\"login_email\" placeholder=\"Username\">\n";
    echo "</div>\n";
    echo "<div class=\"form-group\">\n";
    echo "<input type=\"password\" class=\"form-control form-control-lg\" id=\"login_password\" placeholder=\"Password\">\n";
    echo "</div>\n";
    echo "<div class=\"mt-3\">\n";
    // echo "<a class=\"btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn\" href=\"./index.html\">SIGN IN</a>\n";
    echo "<button type=\"button\" class=\"btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn\">\n";
    echo "<i class=\"text-primary\"></i>Sign In\n";
    echo "</button>\n";
    echo "</div>\n";
    echo "<div class=\"my-2 d-flex justify-content-between align-items-center\">\n";
    echo "<div class=\"form-check\">\n";
    // echo "<label class=\"form-check-label text-muted\">\n";
    // echo "<input type=\"checkbox\" class=\"form-check-input\">\n";
    // echo "Keep me signed in\n";
    // echo "</label>\n";
    echo "</div>\n";
    echo "<a href=\"./login.php?action=forgotpwd\" class=\"auth-link text-black\">Forgot password?</a>\n";
    echo "</div>\n";
    echo "<div class=\"mb-2\">\n";
    // echo "<button type=\"button\" class=\"btn btn-block btn-facebook auth-form-btn\">\n";
    // echo "<i class=\"ti-facebook me-2\"></i>Connect using facebook\n";
    // echo "</button>\n";
    echo "</div>\n";
    echo "<div class=\"text-center mt-4 fw-light\">\n";
    // echo "Don't have an account? <a href=\"register.html\" class=\"text-primary\">Create</a>\n";
    echo "</div>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<!-- content-wrapper ends -->\n";
    echo "</div>\n";
    echo "<!-- page-body-wrapper ends -->\n";
    echo "</div>\n";
    echo "<!-- container-scroller -->\n";
    echo "<!-- plugins:js -->\n";
    echo "<script src=\"./vendors/js/vendor.bundle.base.js\"></script>\n";
    echo "<!-- endinject -->\n";
    echo "<!-- Plugin js for this page -->\n";
    echo "<script src=\"./vendors/bootstrap-datepicker/bootstrap-datepicker.min.js\"></script>\n";
    echo "<!-- End plugin js for this page -->\n";
    echo "<!-- inject:js -->\n";
    echo "<script src=\"./js/off-canvas.js\"></script>\n";
    echo "<script src=\"./js/hoverable-collapse.js\"></script>\n";
    echo "<script src=\"./js/template.js\"></script>\n";
    echo "<script src=\"./js/settings.js\"></script>\n";
    echo "<script src=\"./js/todolist.js\"></script>\n";
    echo "<!-- endinject -->\n";
    echo "</body>\n";
    echo "</html>\n";
}

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