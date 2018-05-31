<!DOCTYPE html>
<html lang="en" ng-app="businessApp" ng-controller="businessController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
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
    <body class="profile-main-page without-reg bus-main">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()) ?>"></script>
        <?php 
            if($ismainregister == false){
                // $this->load->view('business_live/login_header');
            }else if($isbusiness_register == true && $isbusiness_deactive){
                echo $business_header2;
            }else{
                echo $header_profile; 
            }
        ?>
        <?php
           if($ismainregister == false){
        ?>
            <div class="middle-section middle-section-banner new-ld-page">
        <?php //echo $search_banner; 
            } else if(!$isbusiness_deactive && $isbusiness_register == true) { ?>
            <div class="middle-section">
        <?php } else { ?>
            <div class="middle-section middle-section-banner">
        <?php //echo $search_banner;  
        } ?>

        <!-- <div class="middle-section middle-section-banner new-ld-page"> -->
            <!-- SEARCH BANNER for BUSINESS -->
            <?php if(!$isbusinessactivate){ ?>
                <?php if(!$business_profile_set){ echo $search_banner; } ?>
            <?php } else { ?>
                <div class="sub-fix-head">
                    <div class="container">
                        <p><span>Do you want to reactive ? </span><a class="pull-right btn-1" href="<?php echo base_url('business/reactivateacc'); ?>">Reactivate </a></p>
                    </div>
                </div>
            <?php } ?>

            <!-- TOP CATEGORY LIST -->
            <div class="job-cat-lp">
                <div class="container" >
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Business by Category</h2>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box" ng-repeat="category in businessCategory">
                            <div class="all-cat-box">
                                <a ng-href="<?php echo base_url ?>{{category.industry_slug}}-business">
                                    <div class="cus-cat-middle">
                                        <img ng-src="<?php echo base_url('assets/n-images/cat-1.png?ver='.time()) ?>" alt="{{category.industry_name}}">
                                        <p ng-bind="category.industry_name"></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p20 fw" data-aos="fade-up" data-aos-duration="1000">
                        <p class="p20 text-center"><a class="btn-1" ng-href="<?php echo base_url('business-by-categories') ?>">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- TOP LOCATION LIST -->
            <div class="job-cat-lp">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Business by Location</h2>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box " ng-repeat="location in businessLocation">
                            <div class="all-cat-box">
                                <a ng-href="<?php echo base_url ?>business-in-{{location.slug}}">
                                    <div class="cus-cat-middle">
                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver='.time()) ?>">
                                        <p ng-bind="location.city_name"></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p20 fw" data-aos="fade-up" data-aos-duration="1000">
                        <p class="p20 text-center"><a ng-href="<?php echo base_url('business-by-location') ?>" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- HOW ABOUT PROFILE -->
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How Can Aileensoul Business Profile Help You in Growing Network?</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                       
                        <div class="col-md-8 col-sm-10 col-md-push-2 col-sm-push-1 text-center ">
                            <p>In the emerging phase of start-ups and entrepreneurship more and more people are getting inclined towards having his/her own business venture. </p>
                            <p>Aileensoul recognises the need of time and offers a discreetly designed Business profile which allows the users to increase their business contacts as well as smoothly promote their new established business. </p>
                            <p>Digital marketing is on spur and hence Aileensoul through its business profile helps the users by freely providing a platform to enrich their business through various means. One can upload images, audios, pdf files and videos in this profile. The notification bar of business profile keeps the users aware of all the ongoing trends and details of his/her arena. Hence, keeping people connected to each other.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CREATE BUSINESS OR REACTIVE -->
            <div class="content-bnr bus-bnr-prlx">
                <div class="bnr-box">
                    <div class="content-bnt-text" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Grow Business Network Plus Be Found at Any Time by Listing Your Business Online</h2>
                        <p>
                            <?php if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
                                <a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
                            <?php }else{ ?>
                                <a class="btn5" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
                            <?php } ?>   
                        </p>
                    </div>
                </div>
            </div>

            <!-- HOW IT WORKS -->
            <div class="how-it-work">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How it Works</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/reg.png?ver='.time()) ?>">
                                <p>Register</p>
                                <span>List your business for free and fill your business detail to get found online.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/connect.png?ver='.time()) ?>">
                                <p>Grow Network</p>
                                <span>Build and grow your business network by connecting with other business.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url('assets/n-images/stay-update.png?ver='.time()) ?>">
                                <p>Stay Updated</p>
                                <span>Get all the daily news about the business you follow.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RELATED ARTICLE -->
            <div class="related-article">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h3>Related Article</h3>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3 col-sm-6">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg?ver='.time()) ?>">
                                <div class="rel-art-name">
                                    <a href="#">See the world in your language with Google Translate</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg?ver='.time()) ?>">
                                <div class="rel-art-name">
                                    <a href="#">See the world in your language with Google Translate</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg?ver='.time()) ?>">
                                <div class="rel-art-name">
                                    <a href="#">See the world in your language with Google Translate</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg?ver='.time()) ?>">
                                <div class="rel-art-name">
                                    <a href="#">See the world in your language with Google Translate</a>
                                </div>
                            </div>
                        </div>                           
                    </div>
                </div>
            </div>


            <!-- TOP CATEGORY LIST -->
            <div class="container pt20 hidden">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="cat-box">
                            <ul>
                                <li ng-repeat="category in businessCategory">
                                    <a ng-href="<?php echo base_url('business-profile/category/') ?>{{category.industry_slug}}">
                                        <img ng-src="<?php echo base_url('assets/n-images/car.png?ver='.time()) ?>" alt="{{category.industry_name}}">
                                        <p><span ng-bind="category.industry_name"></span><span ng-bind="'(' + category.count + ')'"></span></p>
                                    </a>
                                </li>
                                <li>
                                    <a ng-href="<?php echo base_url('business-profile/category/other') ?>">
                                        <img ng-src="<?php echo base_url('assets/n-images/car.png?ver='.time()) ?>" alt="Other">
                                        <p>Other<span ng-bind="'(' + otherCategoryCount + ')'"></span></p>
                                    </a>
                                </li>
                            </ul>
                            <p class="text-center"><a ng-href="<?php echo base_url('business-by-categories') ?>" title="View More" class="btn-1">View More</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container pt20 hidden">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>What is Business </h3>

                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-bnr hidden">
                <div class="bnr-box">
                    <img src="<?php echo base_url('assets/n-images/img2.jpg') ?>">
                    <div class="content-bnt-text">
                        <h1>Lorem Ipsum is a dummy text</h1>
                        <p>
                            <?php// if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
                                <!-- <a class="btn5" href="<?php //echo $business_profile_link ?>">Create Business Profile</a> -->
                            <?php //} else{ ?>
                                <!-- <a class="btn5" href="<?php //echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a> -->
                            <?php //} ?>      

                            <?php 
                                if (($ismainregister == true && $isbusiness_register == false) || ($ismainregister == false)) { 
                            ?>
                                <a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
                            <?php } ?>                      
                        </p>
                    </div>
                </div>
            </div>
            <div class="container pt20 hidden">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>How it works </h3>
                            <p>Lorem ipsum is dummy text</p>
                        </div>
                    </div>
                    <div class="it-works-img pt20 pb20">
                        <img src="<?php echo base_url('assets/n-images/img3.jpg') ?>">
                    </div>

                    <div class="related-article pt20">
                        <div class="center-title">
                            <h3>Related Article</h3>

                        </div>
                        <div class="row pt10">
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
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
            var app = angular.module('businessApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/index.js?ver=' . time()) ?>"></script>            
    </body>
</html>