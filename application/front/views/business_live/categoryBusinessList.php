<!DOCTYPE html>
<html lang="en" ng-app="businessListApp" ng-controller="businessListController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">
        <!-- SET BLANK VALUE IF VAR. NOT SET FROM CONTROLLER -->
        <?php $location_id = (isset($location_id)) ? $location_id : ''; ?>
        <?php $category_id = (isset($category_id)) ? $category_id : ''; ?>

        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <?php if($business_profile_set == 0 && $business_profile_set == '0'){ echo $search_banner; } ?>
            <div class="container pt20">
                <div class="left-part">
                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="search-listing custom-scroll">
                            <li ng-repeat="category in businessCategory">
                                <label class="">
                                    <p class="pull-left" style="width: 45px;">
                                        <input class="categorycheckbox" type="checkbox" name="{{category.industry_name}}" value="{{category.industry_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
                                    </p>
                                    <p class="pull-left">{{category.industry_name | capitalize}}</p>
                                    <p class="pull-right">({{category.count}})</p>
                                </label>
                            </li>
                        </ul>
                        <p class="text-right p10"><a href="<?php echo base_url('business-by-categories') ?>">More Categories</a></p>
                    </div>
                    <!-- TOP Location -->
                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Location</h3>
                        </div>
                        <ul class="search-listing custom-scroll">
                            <li ng-repeat="location in businessLocation">
                                <label class="">
                                    <p class="pull-left" style="width: 45px;">
                                        <input class="locationcheckbox" type="checkbox" name="{{location.city_name}}" value="{{location.city_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
                                    </p>
                                    <p class="pull-left">
                                        {{location.city_name | capitalize}}
                                    </p>
                                    <p class="pull-right">({{location.count}})</p>
                                </label>
                            </li>
                        </ul>
                        <p class="text-right p10"><a href="<?php echo base_url('business-by-location') ?>">More Location</a></p>
                    </div>

                    <div class="custom_footer_left fw">
                        <div class="">
                            <ul>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> About Us 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Blogs 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Privacy Policy 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Send Us Feedback
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="middle-part">
                    <div class="page-title">
                        <h3>Search Result</h3>
                    </div>
                    <div class="all-job-box search-business" ng-repeat="business in businessList">
                        <div class="search-business-top">
                            <div class="bus-cover no-cover-upload">
                                <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.profile_background"><img ng-src="<?php echo BUS_BG_MAIN_UPLOAD_URL ?>{{business.profile_background}}"></a>
                                <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.profile_background"><img ng-src="<?php echo BASEURL . WHITEIMAGE ?>"></a>
                            </div>
                            <div class="all-job-top">
                                <div class="post-img">
                                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.business_user_image"><img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}"></a>
                                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.business_user_image"><img ng-src="<?php echo BASEURL . NOBUSIMAGE ?>"></a>
                                </div>
                                <div class="job-top-detail">
                                    <h5><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.company_name"></a></h5>
                                    <h5 ng-if="business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.industry_name"></a></h5>
                                    <h5 ng-if="!business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.other_industrial"></a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <ul class="search-detail">
                                <li ng-if="business.contact_website"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/website.png') ?>"></span> <p class="detail-content"><a ng-href="{{business.contact_website}}" target="_self" ng-bind="business.contact_website"></a></p></li>
                                <li><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/location.png') ?>"></span> <p class="detail-content"><span ng-bind="business.city"></span><span ng-if="business.city">,(</span><span ng-bind="business.country">India</span><span ng-if="business.city">)</span></p></li>
                                <li ng-if="business.details"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/exp.png') ?>"></span><p class="detail-content">{{business.details| limitTo:110}}...<a href="<?php echo BASEURL ?>company/{{business.business_slug}}"> Read more</a></p></li>
                            </ul>
                        </div>
                    </div>
                    <!-- NO RESULT FOUND DIV -->
                    <div class="job-contact-frnd" ng-if="businessList.length <= 0">
                        <!-- AJAX DATA... -->
                        <div class="text-center rio">
                            <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                            <p style="text-transform:none !important;border:0px;margin-left:4%;">We couldn't find what you were looking for.</p>
                        </div>
                    </div>
                    <div id="loader" class="hidden">
                        <p style="text-align:center;">
                            <img alt="loader" class="loader" src="<?php echo base_url('assets/images/loading.gif') ?>">
                        </p>
                    </div>
                </div>
                <div class="right-part">
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/n-images/add.jpg') ?>">
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var category_id = '<?php echo $category_id; ?>';
            var location_id = '<?php echo $location_id; ?>';
            var q = '';
            var l = '';
            var app = angular.module('businessListApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/categoryBusinessList.js?ver=' . time()) ?>"></script>
    </body>
</html>