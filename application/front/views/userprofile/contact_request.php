<!DOCTYPE html>
<html lang="en" ng-app="contactRequestApp" ng-controller="mainDefaultController">
    <head>
        <base href="/" >
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/jquery-3.2.1.min.js') ?>"></script> -->
        <style type="text/css">
            .popover.cus-tooltip{background: transparent;}
        </style>
    	<?php $this->load->view('adsense'); ?>
    </head>
    <body class="contact-request body-loader two-hd new-listing">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php echo $header_profile; ?>
            <div class="sub-header list-page">
                <div class="container">
                    <nav class="search-tab">
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <ul class="sub-menu">
                                <li><a ng-class="active_pg == 1 ? 'active' : ''" href="<?php echo base_url('contact-request'); ?>">Peoples</a></li>
                                <li><a ng-class="active_pg == 2 ? 'active' : ''" href="<?php echo base_url('contact-business'); ?>">Businesses</a></li>
                                <li><a ng-class="active_pg == 3 ? 'active' : ''" href="<?php echo base_url('hashtags'); ?>">Hashtags</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="main-section">
                <div class="container pt20 mobp0">
					<div ng-view></div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js'); ?>"></script>

        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-sanitize-1.6.4.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_slug = '<?php echo $this->uri->segment(2); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var item = '<?php echo $this->uri->segment(1); ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';

            var app = angular.module("contactRequestApp", ['ngRoute', 'ui.bootstrap', 'ngSanitize']);
        </script>
        <script>
        
            $(function () {
                $('a[href="#search"]').on('click', function (event) {
                    event.preventDefault();
                    $('#search').addClass('open');
                    $('#search > form > input[type="search"]').focus();
                });
                $('#search, #search button.close-new').on('click keyup', function (event) {
                    if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                        $(this).removeClass('open');
                    }
                });
            });
            $(document).ready(function () {
                if (screen.width <= 991) {
                    $("#request-noti-move").appendTo($(".request-noti-move"));
                }
            });

        </script>
        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>

        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/contact_request.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    </body>
</html>