<?php

// DB connection
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

function session_check()
{
    session_start();
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
    echo "<form action=\"./signin.php\" method=\"POST\">\n";
    echo "<div class=\"form-group\">\n";
    echo "<input type=\"text\" class=\"form-control form-control-lg\" id=\"login_email\" name=\"login_email\" placeholder=\"Username\">\n";
    echo "</div>\n";
    echo "<div class=\"form-group\">\n";
    echo "<input type=\"password\" class=\"form-control form-control-lg\" id=\"login_password\" name=\"login_password\" placeholder=\"Password\">\n";
    echo "</div>\n";
    echo "<div class=\"mt-3\">\n";
    // echo "<a class=\"btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn\" href=\"./index.html\">SIGN IN</a>\n";
    echo "<input type=\"submit\" value=\"Sign In\" class=\"btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn\">\n";
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
    echo "<link rel=\"shortcut icon\" href=\"images/sheliak_favicon.jpg\" />\n";
    echo "</head>\n";
}

function tmpl_nav($username, $page)
{
    echo "<body>\n";
    echo "<div class=\"container-scroller\">\n";
    echo "<!-- partial:partials/_navbar.html -->\n";
    echo "<nav class=\"navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row\">\n";
    echo "<div class=\"text-center navbar-brand-wrapper d-flex align-items-center justify-content-start\">\n";
    echo "<div class=\"me-3\">\n";
    echo "<button class=\"navbar-toggler navbar-toggler align-self-center\" type=\"button\" data-bs-toggle=\"minimize\">\n";
    echo "<span class=\"icon-menu\"></span>\n";
    echo "</button>\n";
    echo "</div>\n";
    echo "<div>\n";
    echo "<a class=\"navbar-brand brand-logo\" href=\"./index.php\">\n";
    // echo "<img src=\"images/logo.svg\" alt=\"logo\" />\n";
    echo "</a>\n";
    echo "<a class=\"navbar-brand brand-logo-mini\" href=\"./index.php\">\n";
    // echo "<img src=\"images/logo-mini.svg\" alt=\"logo\" />\n";
    echo "</a>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<div class=\"navbar-menu-wrapper d-flex align-items-top\">\n";
    echo "<ul class=\"navbar-nav\">\n";
    echo "<li class=\"nav-item font-weight-semibold d-none d-lg-block ms-0\">\n";
    echo "<h1 class=\"welcome-text\">Hi, <span class=\"text-black fw-bold\">$username</span></h1>\n";
    echo "<h3 class=\"welcome-sub-text\">You are now in $page</h3>\n";
    echo "</li>\n";
    echo "</ul>\n";

    echo "<ul class=\"navbar-nav ms-auto\">\n";
    // menu element removed
    echo "</ul>\n";
    
    echo "<button class=\"navbar-toggler navbar-toggler-right d-lg-none align-self-center\" type=\"button\" data-bs-toggle=\"offcanvas\">\n";
    echo "<span class=\"mdi mdi-menu\"></span>\n";
    echo "</button>\n";
    echo "</div>\n";
    echo "</nav>\n";
}

function tmpl_sidebar()
{
    echo "<!-- partial -->\n";
    echo "<div class=\"container-fluid page-body-wrapper\">\n";
    echo "<!-- partial:partials/_sidebar.html -->\n";
    echo "<nav class=\"sidebar sidebar-offcanvas\" id=\"sidebar\">\n";
    echo "<ul class=\"nav\">\n";
    echo "<li class=\"nav-item\">\n";
    echo "<a class=\"nav-link\" href=\"./index.php\">\n";
    echo "<i class=\"mdi mdi-grid-large menu-icon\"></i>\n";
    echo "<span class=\"menu-title\">Dashboard</span>\n";
    echo "</a>\n";
    echo "</li>\n";
    echo "<li class=\"nav-item nav-category\">Cyber Security</li>\n";

    echo "<li class=\"nav-item\">\n";
    echo "<a class=\"nav-link\" data-bs-toggle=\"collapse\" href=\"./cve_mngm.php\" aria-expanded=\"false\" aria-controls=\"ui-basic\">\n";
    echo "<i class=\"menu-icon mdi mdi-floor-plan\"></i>\n";
    echo "<span class=\"menu-title\">CVE management</span>\n";
    echo "</a>\n";
    echo "</li>\n";

    echo "<li class=\"nav-item\">\n";
    echo "<a class=\"nav-link\" data-bs-toggle=\"collapse\" href=\"./shodan.php\" aria-expanded=\"false\" aria-controls=\"ui-basic\">\n";
    echo "<i class=\"menu-icon mdi mdi-floor-plan\"></i>\n";
    echo "<span class=\"menu-title\">Shodan</span>\n";
    echo "</a>\n";
    echo "</li>\n";

    echo "</nav>\n";
}

function tmpl_body()
{
    echo "<!-- partial -->\n";
    echo "<div class=\"main-panel\">\n";
    echo "<div class=\"content-wrapper\">\n";
    echo "<div class=\"row\">\n";
    echo "<div class=\"col-sm-12\">\n";
    echo "<div class=\"home-tab\">\n";
    echo "<div class=\"tab-content tab-content-basic\">\n";
    echo "<div class=\"tab-pane fade show active\" id=\"overview\" role=\"tabpanel\" aria-labelledby=\"overview\">\n";
    // start content
    echo "<!-- CONTENT -->";
}

function tmpl_footer()
{
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<!-- content-wrapper ends -->\n";
    echo "<!-- partial:partials/_footer.html -->\n";
    echo "<footer class=\"footer\">\n";
    echo "<div class=\"d-sm-flex justify-content-center justify-content-sm-between\">\n";
    echo "<span class=\"float-none float-sm-right d-block mt-1 mt-sm-0 text-center\">Copyright © 2021. All rights reserved.</span>\n";
    echo "</div>\n";
    echo "</footer>\n";
    echo "<!-- partial -->\n";
    echo "</div>\n";
    echo "<!-- main-panel ends -->\n";
    echo "</div>\n";
    echo "<!-- page-body-wrapper ends -->\n";
    echo "</div>\n";
    echo "<!-- container-scroller -->\n";
}

?>