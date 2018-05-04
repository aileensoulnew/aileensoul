<!DOCTYPE html>
<html lang="en" ng-app="artistApp" ng-controller="artistController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="echo base_url('assets/n-css/css/aos.css?ver=' . time())">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">
        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <?php echo $search_banner; ?>
            <div class="container pt20 hidden">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="cat-box">
                            <ul>
                                <li ng-repeat="category in artistCategory">
                                    <a href="<?php echo base_url('artist/') ?>{{category.category_slug}}">
                                        <img src="<?php echo base_url('assets/n-images/car.png') ?>" alt="category.art_category">
                                        <p><span ng-bind="category.art_category | capitalize"></span><span ng-bind="'(' + (category.count) + ')'"></span></p>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist/other') ?>">
                                        <img src="<?php echo base_url('assets/n-images/car.png') ?>" alt="Other">
                                        <p>Other<span ng-bind="'(' + otherCategoryCount + ')'"></span></p>
                                    </a>
                                </li>
                            </ul>
                            <p class="text-center"><a href="<?php echo base_url('artist/category') ?>" class="btn-1">View More</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pt20 hidden">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>What is Artist</h3>
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
                            <?php if(!$isartistactivate){ ?>
                            <a href="<?php echo base_url('artist/registration') ?>" class="btn5">Create Artist Profile</a>
                            <?php } else{ ?>
                            <a href="<?php echo base_url('artist/reactivateacc'); ?>" class="btn5">Reactivate Artist Profile</a>
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

            <!-- TOP CATEGORIES LIST -->
            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Artist by Category</h2>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3" ng-repeat="category in artistCategory">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url('artist/') ?>{{category.category_slug}}"">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p ng-bind="category.art_category | capitalize">Actor</p>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p20 fw" data-aos="fade-up" data-aos-duration="1000">
                        <p class="p20 text-center"><a href="<?php echo base_url('artist/category') ?>" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- TOP ARTIST LOCATION LIST -->
            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Artist by Location</h2>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Ahmedabad</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Delhi</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Mumbai</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Bangalore</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Mohali</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Punjab</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Rajkot</p>
                                    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="all-cat-box">
                                <a href="#">
                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                    <p class="">Surat</p>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p20 fw" data-aos="fade-up" data-aos-duration="1000">
                        <p class="p20 text-center"><a href="#" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <!-- STATIC TEXT OF HOW ABOUT PROFILE -->
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How Aileensoul Artistic Profile Can Help Artist Reach Their Career Goals?</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <img src="<?php echo base_url('assets/n-images/img4.jpg') ?>">
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Artistic Profile is one of the unique feature that Aileensoul offers to its users. The profile is created solely to provide a magnificent platform for the artists as well as for the art lovers.</p>
                            <p>This profile is an effort to build a bridge between the artists and the layman. Any person with artistic skills can make a profile here for free and showcase their abilities to the viewers. </p>
                            <p>The most Interesting thing about the profile is that, it is not constrained to a particular field but is open to every field.</p>
                            <p>The profile also lets artists around the globe to connect and team up with its growing community of other fellow artists and individuals having varied skills, interests, educational and professional backgrounds. </p>
                            <p>It allows the artists to exhibit their talent and work to the audience spanning across all the continents in the form of photo, video, audio and PDF uploads. </p>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- STATIC TEXT OF HOW ABOUT PROFILE -->
            <div class="content-bnr">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Mark Impression on This World Through Your Creativity</h2>
                        <p>
                            <?php if(!$isartistactivate){ ?>
                            <a href="<?php echo base_url('artist/registration') ?>" class="btn5">Create Artist Profile</a>
                            <?php } else{ ?>
                            <a href="<?php echo base_url('artist/reactivateacc'); ?>" class="btn5">Reactivate Artist Profile</a>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- STATIC TEXT OF HOW IT WORKS -->
            <div class="how-it-work">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How it Works</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/reg.png') ?>">
                                <p>Register</p>
                                <span>Sign up in artistic profile for free and illustrate your talent.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/connect.png') ?>">
                                <p>Connect</p>
                                <span>Grow your artist network by connecting with another artist from all over the world.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url('assets/n-images/telent.png') ?>">
                                <p>Show your Talent</p>
                                <span>Upload pdf, photos, videos and audios to showcase your artistic side to the world.</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- STATIC TEXT OF RELATED ARTICAL -->
            <div class="related-article">
                <div class="container">
                        <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                            <h3>Related Article</h3>

                        </div>
                        <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
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
            var app = angular.module('artistApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/index.js?ver=' . time()) ?>"></script>
    </body>
</html>