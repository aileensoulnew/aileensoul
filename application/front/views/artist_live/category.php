<!DOCTYPE html>
<html lang="en" ng-app="artistCategoryApp" ng-controller="artistCategoryController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">
        <?php $page = (isset($page)) ? $page : ''; ?>
        <?php $session_user_id = $this->session->userdata('aileenuser'); ?>
        <?php
            if ($ismainregister == false) {
                $this->load->view('artist_live/login_header');
            }else if($isartistactivate == true && $artist_isregister){
                echo $artistic_header2;
            }else{
                echo $header_profile;
            }
        ?>
        <div class="middle-section middle-section-banner">
                <?php if($isartistactivate == false || $artist_isregister == false || !$session_user_id){    echo $search_banner; 
                }

            ?>

            <div class="container pt20">
                <div class="custom-user-list">
                    <div class="list-box-custom border-none">
                        <div class="">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="<?php if($page == '' || !$page) echo 'active'; ?>"><a href="#artist-categories" data-toggle="tab"><span class="hidden-xs">Artist by</span> Categories</a></li>
                                    <li class="<?php if($page == 'location') echo 'active'; ?>"><a href="#artist-location" data-toggle="tab"><span class="hidden-xs">Artist by</span> Location</a></li>
                                </ul>
                            </div>
                            <div class="all-detail-box">
                                <div class="tab-content">
                                    <div class="tab-pane fade in <?php if($page == '' || !$page) echo 'active'; ?>" id="artist-categories">
                                        <div class="cat-box">
                                            <ul data-aos="fade-up" data-aos-duration="1000">
                                                <li ng-repeat="category in artistAllCategory">
                                                    <a href="<?php echo artist_category ?>{{category.category_slug}}">
                                                        <div class="cus-cat-middle">
                                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                                            <p ng-bind="category.art_category | capitalize"></p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo artist_other_category; ?>">
                                                        <div class="cus-cat-middle">
                                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                                            <p>Other</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in <?php if($page == 'location') echo 'active'; ?>" id="artist-location">
                                        <div class="location-box">
                                            <ul data-aos="fade-up" data-aos-duration="1000">
                                                <li ng-repeat="location in artistAllLocation">
                                                    <a href="<?php echo artist_location ?>{{location.location_slug}}">
                                                        <div class="cus-cat-middle">
                                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                                            <p ng-bind="location.art_location | capitalize"></p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    
                    </div>
                </div>
                <div class="right-part">
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/img/add.jpg') ?>">
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('artistCategoryApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/category.js?ver=' . time()) ?>"></script>
    </body>
</html>