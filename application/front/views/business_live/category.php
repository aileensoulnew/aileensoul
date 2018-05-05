<!DOCTYPE html>
<html lang="en" ng-app="businessCategoryApp" ng-controller="businessCategoryController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">
        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <?php if($business_profile_set == 0 && $business_profile_set == '0'){ echo $search_banner; } ?>
            <!-- NEW HTML -->
            <div class="container pt20">
                <div class="custom-user-list">
                    <div class="list-box-custom border-none">
                        <div class="">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#business-categories" data-toggle="tab"><span class="hidden-xs">Business by</span> Categories</a></li>

                                    <li><a href="#business-location" data-toggle="tab"><span class="hidden-xs">Business by</span> Location</a></li>
                                </ul>
                            </div>
                            <div class="all-detail-box">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="business-categories">
                                        <div class="cat-box">
                                            <ul data-aos="fade-up" data-aos-duration="1000">
                                                <li ng-repeat="category in businessAllCategory">
                                                    <a ng-href="<?php echo base_url('business-profile/category/') ?>{{category.industry_slug}}">
                                                        <div class="cus-cat-middle">
                                                            <img ng-src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>" alt="{{category.industry_name}}">
                                                            <p ng-bind="category.industry_name"></p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a ng-href="<?php echo base_url('business-profile/category/other') ?>">
                                                        <div class="cus-cat-middle">
                                                            <img ng-src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>" alt="Other">
                                                            <p>Other<span ng-bind="'(' + otherCategoryCount + ')'"></span></p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in " id="business-location">
                                        <div class="location-box">
                                            <ul data-aos="fade-up" data-aos-duration="1000">
                                                <li>
                                                    <a href="">
                                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                                        <p>Ahmedabad</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                                        <p>Indore</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                                        <p>Mumbai</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                                        <p>Bangalore</p>
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
                        <img src="<?php echo base_url('assets/img/add.jpg?ver=' . time()) ?>" alt="{{category.industry_name}}">
                    </div>
                </div>
            </div>

            <!-- OLD HTML -->
            <div class="container hidden">
                <div class="custom-user-list">
                    <div class="list-box-custom">
                        <h3>All Categories</h3>
                        <div class="cat-box">
                            <ul>
                                <li ng-repeat="category in businessAllCategory">
                                    <a ng-href="<?php echo base_url('business-profile/category/') ?>{{category.industry_slug}}">
                                        <img ng-src="<?php echo base_url('assets/n-images/car.png?ver=' . time()) ?>" alt="{{category.industry_name}}">
                                        <p><span ng-bind="category.industry_name"></span><span ng-bind="'(' + category.count + ')'"></span></p>
                                    </a>
                                </li>
                                <li>
                                    <a ng-href="<?php echo base_url('business-profile/category/other') ?>">
                                        <img ng-src="<?php echo base_url('assets/n-images/car.png?ver=' . time()) ?>" alt="Other">
                                        <p>Other<span ng-bind="'(' + otherCategoryCount + ')'"></span></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="right-part">
                    <div class="add-box">
                        <img ng-src="<?php echo base_url('assets/n-images/add.jpg?ver='.time()) ?>" alt="Advertise">
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>

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
                                            var app = angular.module('businessCategoryApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/category.js?ver=' . time()) ?>"></script>
    </body>
</html>