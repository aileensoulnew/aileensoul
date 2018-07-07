        <!DOCTYPE html>
<?php $user_id = $this->session->userdata('aileenuser'); 
//echo $user_id."-------".$job_deactive."----------".$this->job_profile_set;exit;?>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <?php //echo $head; ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>"> -->
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
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
    <?php $this->load->view('adsense'); ?>
</head>
<body class="profile-main-page">
    <?php //$this->load->view('page_loader'); ?>
    <div id="main_page_load">
            <?php 
            if($job_deactive == 0  && $this->job_profile_set == 1)
                echo $job_header2;
            else if ($user_id != "" && ($job_deactive > 0 || $this->job_profile_set == 1)) {
                echo $header_profile;
            }
            else if($user_id != "" && $this->job_profile_set == 0)
            {
                 echo $header_profile;
            }
            $noLogin = "";
            if($user_id == "")
            {
                $noLogin = "new-ld-page";
            }
            if($this->job_profile_set == 0 || $job_deactive > 0)
            {?>
                <div class="middle-section middle-section-banner <?php echo $noLogin;?>">
            <?php
                echo $search_banner;
            }
            else{ ?>
                <div class="middle-section">
            <?php } ?>
                <div class="container pt20 mobp0 mobmt15">
                    <div class="custom-user-list">
                        <div class="list-box-custom border-none cus-job">
                            <div class="">
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Jobs by</span> Categories</a></li>
                                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Jobs by</span> Skills</a></li>
                                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Jobs by</span> Locations</a></li>
                                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Jobs by</span> Companies</a></li>
                                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Jobs by</span> Designations</a></li>
                                        <li class="active"><a href="#">Jobs</a></li>
                                    </ul>
                                </div>
                                <div class="all-jobs-list">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="job-category">
                                            <div class="location-box">
                                                <ul class="jobs-listing" >
                                                    <?php 
                                                    if(isset($all_link) && !empty($all_link)):
                                                        foreach($all_link as $key=>$allJobVal):?>
                                                    <li>
                                                        <h4><?php echo ucwords($key); ?></h4>
                                                        <ul class="jobs-listing-main">
                                                            <?php foreach($allJobVal as $inJobsKey=>$inJobsval): ?>
                                                            <li>
                                                                <h5><?php echo ucwords($inJobsKey); ?></h5>
                                                                <ul class="jobs-listing-sub">
                                                                    <?php foreach($inJobsval as $byJobKey=>$byJobVal): ?>
                                                                    <li>      
                                                                        <a href="<?php echo $byJobVal['slug']; ?>" target="_self"><?php echo $byJobVal['name']; ?></a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                                </ul>
                                                                <!-- <a href="<?php //echo base_url(); ?>{{alljobs.slug}}" target="_self"> {{alljobs.name}} </a> -->
                                                            </li>
                                                        <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </ul>
                                            </div>
                                        </div>                        
                                    </div>
                                </div>
                            </div>
                                        
                        </div>
                    </div>
                    <div class="right-part">
                        <!-- <div class="add-box">
                            <img src="<?php //echo base_url();?>assets/img/add.jpg">
                        </div> -->
                        <?php echo $right_profile_view; ?>
                        <?php echo $left_footer; ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
    <script>
        $(document).ready(function(){
             $('html,body').animate({scrollTop: 500}, 500);
        });
        var base_url = '<?php echo base_url(); ?>';
        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        var title = '<?php echo $title; ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var q = '';
        var l = '';
        var w = '';
        var app = angular.module('', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
    </script>
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
</body>