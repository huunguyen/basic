<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Quảng cáo đồng nai | Mẫu đăng nhập</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?= $this->assetsBase ?>/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?= $this->assetsBase ?>/global/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $this->assetsBase ?>/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?= $this->assetsBase ?>/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="menu-toggler sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="<?= $this->assetsBase ?>/admin/layout/img/logo-big.png" alt=""/>
            </a>
        </div>
        <!-- END LOGO -->
        <!-- Include content pages -->
        <?php echo $content; ?>
        <div class="copyright">
            2014 © QCDN. Trang quản trị hệ thống.
        </div>

        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="<?= $this->assetsBase ?>/global/plugins/respond.min.js"></script>
        <script src="<?= $this->assetsBase ?>/global/plugins/excanvas.min.js"></script> 
        <![endif]-->
        <script src="<?= $this->assetsBase ?>/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?= $this->assetsBase ?>/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?= $this->assetsBase ?>/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?= $this->assetsBase ?>/admin/pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Login.init();
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>