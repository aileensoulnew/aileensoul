<!DOCTYPE html>
<?php $user_id = $this->session->userdata('aileenuser'); ?>
<html lang="en" ng-app="viewMoreJob" ng-controller="viewMoreJobController">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">    
        <?php if($user_id != "")
        {
            echo $header_profile;
        } ?>    
        <div class="middle-section middle-section-banner new-ld-page">
            
            <div class="search-banner" >
                <?php if($user_id == "")
                { ?>
                <header>
                    <div class="header">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 left-header">
                                    <h2 class="logo"><a href="#">Aileensoul</a></h2>
                                </div>
                                <div class="col-md-6 col-sm-6 no-login-right fw-479">
                                    <a href="#" class="btn8">Login</a>
                                    <a href="#" class="btn9">Create account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <?php } ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                            <div class="search-bnr-text">
                                <h1>Find the Right Job Opportunities</h1>
                                <p>Because Dream Matters </p>
                            </div>
                            <div class="search-box">
                                <form>
                                    <div class="pb20 search-input">
                                        <input type="text" placeholder="Job Title, Keywords, or Company ">
                                        <input class="city-input" type="text" placeholder="City, State or Country">
                                        
                                    </div>
                                    <div class="pt5 fw pb20">
                                        <ul class="work-timing fw">
                                            <li>
                                                <label class="control control--checkbox">Full-Time
                                                  <input type="checkbox"/>
                                                  <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">Part-Time
                                                  <input type="checkbox"/>
                                                  <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">Internship
                                                  <input type="checkbox"/>
                                                  <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fw pt20">
                                        <a href="#" class="btn1">View More Jobs</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 right-bnr">
                            <img src="<?php echo base_url('assets/n-images/job-bnr.png?ver=' . time()) ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container pt20">
                <div ng-view></div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
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
            var app = angular.module('viewMoreJob', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/view_more_jobs.js?ver=' . time()) ?>"></script>        
    </body>
</html>