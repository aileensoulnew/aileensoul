<!DOCTYPE html>
<html lang="en" ng-app="artistSearchListApp" ng-controller="artistSearchListController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <?php if(($is_artist_profile_set == 1 || $is_artist_profile_set == '1') || $isartistactivate == 0){ 
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <?php } ?>
    </head>
    <body class="profile-main-page">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <?php //if($ismainregister == true){ ?>
            <?php //if(($is_artist_profile_set == 0 || $is_artist_profile_set == '0') || $isartistactivate == 1){
            //     echo $header_profile; 
            // } else{
            //     echo $artistic_header2;
            // }
            ?>
        <?php

            echo $ismainregister;
            echo $isartistactivate;
            echo $artist_isregister;
       ?>

        <?php if ($ismainregister == false) {
                $this->load->view('artist_live/login_header');
            }else if($isartistactivate == true && $artist_isregister){
                echo $artistic_header2;
            }else{
                echo $header_profile;
            }
         ?>

            <?php if(($is_artist_profile_set == 0 || $is_artist_profile_set == '0') || $isartistactivate == 1){ 
            ?>
            <div class="middle-section middle-section-banner">
            <?php
                echo $search_banner; 
            } else{
            ?>
                <div class="middle-section">
            <?php } ?>
            <div class="container pt20">
                <div class="left-part">
                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="search-listing">
                            <li ng-repeat="category in artistCategory">
                                <label class="">
                                     <p class="pull-left" style="width: 45px;">
                                        <input class="categorycheckbox" type="checkbox" name="{{category.art_category}}" value="{{category.category_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
                                    </p>
                                    <p class="pull-left">{{category.art_category | capitalize}}</p>
                                    <p class="pull-right">({{category.count}})</p>
                                </label>
                            </li>
                        </ul>
                        <p class="text-right p10"><a href="<?php echo artist_category_list ?>">More Categories</a></p>
                    </div>

                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Locations</h3>
                        </div>                        
                        <ul class="search-listing" style="list-style: none;">
                            <li ng-repeat="location in artistLocation">
                                <label class="pointer">
                                    <p class="pull-left" style="width: 45px;">
                                        <input class="locationcheckbox" type="checkbox" name="{{location.art_location}}" value="{{location.location_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
                                    </p>
                                    <p class="pull-left">
                                        {{location.art_location | capitalize}}
                                    </p>
                                    <p class="pull-right">({{location.total}})</p>
                                </label>
                            </li>
                        </ul>
                        <p class="text-right p10"><a href="<?php echo artist_location_list ?>">More Locations</a></p>
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
                        <h3>Search Result {{ searchtitle }} </h3>
                    </div>
                    <div class="all-job-box search-business" ng-repeat="artist in artistList">
                        <div class="search-business-top">
                            <div class="bus-cover no-cover-upload">
                                <a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-if="artist.profile_background">
                                    <img ng-src="<?php echo ART_BG_MAIN_UPLOAD_URL ?>{{artist.profile_background}}">
                                </a>
                                <a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-if="!artist.profile_background">
                                    <img ng-src="<?php echo BASEURL . WHITEIMAGE ?>">
                                </a>
                            </div>
                            <div class="all-job-top">
                                <div class="post-img">
                                    <a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-if="artist.art_user_image"><img ng-src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL ?>{{artist.art_user_image}}"></a>
                                    <a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-if="!artist.art_user_image"><img ng-src="<?php echo BASEURL . NOARTIMAGE ?>"></a>
                                </div>
                                <div class="job-top-detail">
                                    <h5><a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-bind="artist.fullname | capitalize"></a></h5>
                                    <h5 ng-if="artist.art_category"><a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-bind="artist.art_category | capitalize"></a></h5>
                                    <h5 ng-if="!artist.art_category"><a href="<?php echo artist_dashboard ?>{{artist.slug}}" ng-bind="artist.other_skill | capitalize"></a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <ul class="search-detail">
                                <li><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/location.png') ?>"></span> <p class="detail-content"><span ng-bind="artist.city"></span><span ng-if="artist.city">,(</span><span ng-bind="artist.country"></span><span ng-if="artist.city">)</span></p></li>
                                <li ng-if="artist.art_desc_art"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/exp.png') ?>"></span><p class="detail-content">{{artist.art_desc_art| limitTo:110}}...<a href="<?php artist_dashboard ?>{{artist.slug}}"> Read more</a></p></li>
                            </ul>
                        </div>
                    </div>
                    <!-- NO RESULT FOUND DIV -->
                    <div class="art-img-nn" ng-if="artistList.length <= 0">
                        <div class="art_no_post_img">
                            <img alt="No Saved freelancer" src="<?php echo base_url('assets/img/free-no1.png') ?>">
                        </div>
                        <div class="art_no_post_text">No Result Found..</div>
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
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <?php if(($is_artist_profile_set == 1 || $is_artist_profile_set == '1') || $isartistactivate == 0){ 
            ?>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var category_id = '<?php echo $category_id; ?>';
            var location_id = '<?php echo $location_id; ?>';
            var q = '<?php echo $q; ?>';
            var l = '<?php echo $l; ?>';         
            var app = angular.module('artistSearchListApp', ['ui.bootstrap']);
            var a = '<?php  echo $ismainregister; ?>';
        </script>   
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/search.js?ver=' . time()) ?>"></script>
         
    </body>
</html>