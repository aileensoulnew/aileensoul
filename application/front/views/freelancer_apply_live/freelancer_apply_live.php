<!DOCTYPE html>
<html lang="en" ng-app="freeapplypostApp" ng-controller="freeapplypostController">
    <head>
        <title>Freelancer Jobs</title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">
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
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: none;">
        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <?php if($freelance_apply_profile_set == 0 || $freelance_apply_profile_set == '0'){ echo $search_banner; } ?>
            
            <div class="container pt20">
                <!-- LEFT SIDE FILTER -->
                <div class="left-part">
                    <?php echo $fa_leftbar; ?>
                   <!--  <div class="custom_footer_left fw">
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
                    </div> -->
                    

                </div>

                <!-- MIDDLE PART FOR POST -->
                <div class="middle-part">   
                    <div class="page-title">
                        <h3>Recommended Projects</h3>
                    </div>
                    <div class="user_no_post_avl ng-scope" ng-if="freepostapply.length == 0">
                        <div class="user-img-nn">
                            <div class="user_no_post_img">
                                <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                            </div>
                            <div class="art_no_post_text">No Projects Available.</div>
                        </div>
                    </div>
                    <div class="all-job-box freelance-recommended-post" ng-repeat="applypost in freepostapply">
                            <div class="all-job-top">
                                <div class="job-top-detail">
                                    <h5><a href="<?php echo base_url(); ?>freelance-jobs/{{applypost.industry_name}}/{{applypost.post_slug}}-{{applypost.user_id}}-{{applypost.post_id}}">{{applypost.post_name}}
                                        <span ng-if="applypost.day_remain > 0">({{applypost.day_remain}} days left)</span>
                                        </a>
                                    </h5>
                                    <p><a href="<?php echo base_url(); ?>freelance-jobs/{{applypost.industry_name}}/{{applypost.post_slug}}-{{applypost.user_id}}-{{applypost.post_id}}">{{applypost.fullname | capitalize}}</a></p>
                                    <p ng-if="applypost.post_rate != ''">Budget : {{applypost.post_rate}} {{applypost.post_currency}} (hourly/fixed)</p>
                                </div>
                            </div>
                            <div class="all-job-middle">
                                <p class="pb5">
                                    <span class="location" ng-if="applypost.city || applypost.country">
                                        <!-- IF BOTH DATA AVAILABLE OF COUNTRY AND CITY -->
                                        <span ng-if="applypost.city && applypost.country">
                                            <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{ applypost.city }},({{ applypost.country }})
                                        </span>
                                        <!-- IF ONLY CITY AVAILABLE -->
                                        <span ng-if="applypost.city && !applypost.country">
                                            <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{ applypost.city }}
                                        </span>
                                        <!-- IF ONLY COUNTRY AVAILABLE -->
                                        <span ng-if="!applypost.city && applypost.country">
                                            <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{applypost.country}}
                                        </span>
                                    </span>
                                    <span class="exp">
                                        <span>
                                            <img class="pr5" src="<?php echo base_url('assets/img/exp.png?ver=' . time()) ?>">
                                            Skils: <span dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{applypost.post_skill}}" dd-text-collapse-cond="false">
                                            </span>
                                        </span>
                                    </span>
                                </p>                                
                                <p dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{applypost.post_description}}" dd-text-collapse-cond="false">
                                </p>
                                <p ng-if="applypost.industry_name != '' ">
                                    Categories : <span>{{applypost.industry_name}}</span>
                                </p>
                            </div>
                            <div class="all-job-bottom">
                                <span>Applied Persons: {{applypost.ShortListedCount}}</span>
                                <span class="pl20">Shortlisted Persons: {{applypost.AppliedCount}}</span>
                                <p class="pull-right">
                                    <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Save</a>
                                    <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Apply</a>
                                </p>
                            </div>
                        </div>
                    <div id="loader" style="display: none;">
                        <p style="text-align:center;">
                            <img src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="<?php echo 'loaderimage'; ?>"/>
                        </p>
                    </div>
                </div>

                <!-- RIGHT SIDE AD IMG -->
                <div class="right-part">
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/img/add.jpg?ver=' . time()) ?>">
                    </div>
					<?php echo $left_footer_list_view; ?>
                </div>
            </div>


            <div class="container hidden">
                <div class="left-part">
                    <!-- TOP CATEGORIES -->
                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="search-listing custom-scroll">                           
                            <li ng-repeat="category in freelancerCategory">
                                <label class="">
                                    <a href="<?php echo base_url('freelance-work/category/') ?>{{category.industry_slug}}">
                                        <span ng-bind="category.industry_name | capitalize"></span>
                                        <span class="pull-right" ng-bind="'(' + category.count + ')'"></span>
                                    </a>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!-- WORK TYPE -->
                    <div class="left-search-box work-type">
                        <div class="">
                            <h3>Work Type</h3>
                        </div>
                        <ul class="search-listing pb10 fw">
                            <li>
                                <label class="control control--checkbox">Hourly
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Fixed
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!-- POSTING PERIOD -->
                    <div class="left-search-box">
                        <div class="">
                            <h3>Posting Period</h3>
                        </div>
                        <ul class="search-listing">
                            <li>
                                <label class="control control--checkbox">Today
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 7 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 15 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 45 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">More than 45 days
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>


                        </ul>
                    </div>
                    <div class="left-search-box">
                        <div class="">
                            <h3>Required Experience</h3>
                        </div>
                        <ul class="search-listing">
                            <li>
                                <label class="control control--radio">0 to 1 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">1 to 2 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">2 to 3 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">3 to 4 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">4 to 5 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">More than 5 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>



                        </ul>
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
                        <h3>Recommended Projects</h3>
                    </div>
                    <div class="all-job-box freelance-recommended-post" ng-repeat="applypost in freepostapply">
                        <div class="all-job-top">
                            <div class="job-top-detail">
                                <h5><a href="#">{{applypost.post_name}}(project title) <span>(6 days left)</span></a></h5>
                                <p><a href="#">Vivek Panday</a></p>
                                <p>Budget : {{applypost.post_rate}} {{applypost.post_currency}} (hourly/fixed)</p>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <p class="pb5">
                                <span class="location">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/location.png?ver=' . time()) ?>">{{applypost.city}},({{applypost.country}})</span>
                                </span>
                                <span class="exp">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/exp.png?ver=' . time()) ?>">Skils: {{applypost.post_skill}} etc..</span>
                                </span>
                            </p>
                            <p>
                                {{applypost.post_description}} ...<a href="#">Read more</a>
                            </p>
                            <p>
                                Categories : <span>It software development</span>
                            </p>

                        </div>
                        <div class="all-job-bottom">
                            <span>Applied Persons:  {{applypost.ShortListedCount}}</span>
                            <span class="pl20">Shortlisted Persons:{{applypost.AppliedCount}}</span>
                            <p class="pull-right">
                                <a href="#" class="btn4">Save</a>
                                <a href="#" class="btn4">Apply</a>
                            </p>

                        </div>
                    </div>
                </div>

                <div class="right-part">
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/n-images/add.jpg?ver=' . time()) ?>">
                    </div>
                </div>
            </div>

        </div>
        </div>
        <!--  poup modal  -->
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>

        <script>
                                jQuery(document).ready(function ($) {
                                var owl = $('.owl-carousel');
                                owl.on('initialize.owl.carousel initialized.owl.carousel ' +
                                        'initialize.owl.carousel initialize.owl.carousel ' +
                                        'resize.owl.carousel resized.owl.carousel ' +
                                        'refresh.owl.carousel refreshed.owl.carousel ' +
                                        'update.owl.carousel updated.owl.carousel ' +
                                        'drag.owl.carousel dragged.owl.carousel ' +
                                        'translate.owl.carousel translated.owl.carousel ' +
                                        'to.owl.carousel changed.owl.carousel',
                                        function (e) {
                                        $('.' + e.type)
                                                .removeClass('secondary')
                                                .addClass('success');
                                        window.setTimeout(function () {
                                        $('.' + e.type)
                                                .removeClass('success')
                                                .addClass('secondary');
                                        }, 500);
                                        });
                                owl.owlCarousel({
                                loop: true,
                                        nav: true,
                                        lazyLoad: true,
                                        margin: 0,
                                        video: true,
                                        responsive: {
                                        0: {
                                        items: 1
                                        },
                                                600: {
                                                items: 2
                                                },
                                                960: {
                                                items: 2,
                                                },
                                                1200: {
                                                items: 2
                                                }
                                        }
                                });
                                });
                                // mcustom scroll bar
                                (function ($) {
                                $(window).on("load", function () {

                                $(".custom-scroll").mCustomScrollbar({
                                autoHideScrollbar: true,
                                        theme: "minimal"
                                });
                                });
                                })(jQuery);
                                $('#content').on('change keyup keydown paste cut', 'textarea', function () {
                                $(this).height(0).height(this.scrollHeight);
                                }).find('textarea').change();
                                var base_url = '<?php echo base_url(); ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var title = '<?php echo $title; ?>';
                                var header_all_profile = '<?php echo $header_all_profile; ?>';
                                var q = '';
                                var l = '';
                                var f = '';
                                var p = '';
                                var skill = '',search_location  = '';
                                var app = angular.module('freeapplypostApp', ['ui.bootstrap']);
        </script>

        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>  
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/searchfreelancerApply.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/index.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/freelancer-apply-live/post_apply.js?ver=' . time()) ?>"></script> -->
    </body>
</html>