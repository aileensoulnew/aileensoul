<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html ng-app="freelancerhireReactivateApp">
    <head>
        <meta charset="utf-8">
        <title><?php echo $userdata[0]['first_name']." ".$userdata[0]['last_name'] . " | Reactivate | Employer Profile - Aileensoul" ?></title>
        <?php //echo $head; ?>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <!-- CSS START -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/media.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.css?ver='.time()) ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        
    <?php $this->load->view('adsense'); ?>
</head>
    <body>
        <?php echo $header_profile; ?>
        <div class="container" id="paddingtop_fixed">
            <div class="row">
                <center> 
                    <div class="reactivatebox">
                        <div class="reactivate_header">
                            <center><h2><?php echo $this->lang->line("reactive_massage"); ?></h2></center>
                        </div>
                        <div class="reactivate_btn_y">
                            <a title="yes" href="<?php echo base_url('freelance-hire/reactivate'); ?>"><?php echo $this->lang->line("yes"); ?></a>
                        </div>
                        <div class="reactivate_btn_n">
                            <a title="No" href="<?php echo base_url(''); ?>"><?php echo $this->lang->line("no"); ?></a>
                        </div>
                     
                    </div>
                </center>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
          var header_all_profile = '<?php echo $header_all_profile; ?>';
          var app = angular.module('freelancerhireReactivateApp', ['ui.bootstrap']);
          var base_url = '<?php echo base_url(); ?>';
          var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
          var title = '<?php echo $title; ?>';
          var q = '';
          var l = '';
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    </body>
</html>



