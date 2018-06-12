<!DOCTYPE html>
<?php $user_id = $this->session->userdata('aileenuser'); 
//echo $user_id."-------".$job_deactive."----------".$this->job_profile_set;exit;?>
<html lang="en" ng-app="viewMoreFreelanceApplyApp" ng-controller="viewMoreFreelanceApplyController">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title ng-bind="title"></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
          .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 100px;
          }
          </style>
    </head>
    <body class="profile-main-page">    
        <?php
        if($user_id != ""  && $this->freelance_apply_profile_set == 1){
            echo $header_inner_profile;
            echo $freelancer_post_header2;
        }
        else if($user_id != "" && $this->freelance_apply_profile_set == 0)
        {
             echo $header_inner_profile;
        }

        if($user_id == "" || $this->freelance_apply_profile_set == 0)
        {
            $headercls = "";
            if($user_id == "")
            {
                $headercls = " new-ld-page";
            }
            ?>
            <div class="middle-section middle-section-banner <?php echo $headercls; ?>">
            <?php
            echo $search_banner;
        }
        else
        { ?>
            <div class="middle-section">
            <?php 
        } ?>
            <div class="container pt20 mobp0 mobmt15">
                <div ng-view></div>
            </div>
        </div>
        <?php if($user_id != "" && $this->freelance_apply_profile_set == 0)
        { ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var w = '';
            var app = angular.module('viewMoreFreelanceApplyApp', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);

            $(document).ready(function($) {
                /*$("li.user-id label").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });*/
                $("li.user-id a").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });
                /*$(".right-header ul li.dropdown a").click(function(e){
                    $('.right-header ul.dropdown-menu').hide();
                });*/
            });
            $(document).click(function(){
                $('.right-header ul.dropdown-menu').hide();
            });
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>        
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply/view_more_freelance_apply.js?ver=' . time()) ?>"></script>        
    </body>
</html>