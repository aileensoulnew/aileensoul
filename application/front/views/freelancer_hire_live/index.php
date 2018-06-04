<!DOCTYPE html>
<html lang="en" ng-app="artistApp" ng-controller="artistController">
    <head>
        <title>Freelance Register | Aileensoul</title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    </head>
    <body class="profile-main-page recruiter-main">
       <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <!-- If not Register then Registration form display else reactivate div display -->
            <?php if(!$isfreelancerhireactivate){ ?>
                <?php echo $search_banner; ?>
            <div class="sub-fix-head hidden">
                <div class="container">
                    <p><span>Lorem ipzum is a dummy text.</span><a class="pull-right btn-1" href="#">Post a Project</a></p>
                </div>
            </div>
            <?php } else{ ?>
                <div class="sub-fix-head">
                    <div class="container">
                        <p><span>Do you want to reactivare ? </span><a class="pull-right btn-1" href="<?php echo base_url('freelance-hire/reactivateacc'); ?>">Reactivate</a></p>
                    </div>
                </div>
            <?php } ?>            
            <!-- NEW DESIGN -->
            <!-- POST PROJECT -->
            <div class="sub-fix-head hide">
                <div class="container">
                    <h2>
                        <span>Get the Job Done</span>
                        <a class="pull-right btn-1" href="#">Post a Project</a>
                    </h2>
                </div>
            </div>
            <!-- HOW ABOUT PROFILE -->
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How Can Aileensoul Freelance Profile Help in Hiring Remote Talent?</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                       
                        <div class="col-md-8 col-sm-8 col-md-push-2 col-sm-push-2 text-center">
                            <p>Freelancing is no longer an uncommon word, with a vast number of population involved. Penetration of technology and easy access to internet has made freelancing a more preferred choice. </p>
                            <p>A distinct Freelance profile is offered by Aileensoulfor free which allows the users to both hire and get freelance work from the web portal. </p>
                            <p>Freelance Hire profile is especially for freelance recruiters looking out for hiring talented candidates with a hassle-free process. </p>
                            <p>Furthermore, the freelance recruiter can easily put in the skills he/she is requiring for the work and get options as per one’s requirement.The profile also gives the client an option to communicate freely with the candidates.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CREATE OR REACTIVATE -->
            <div class="content-bnr free-hire-bnr-prlx">
                <div class="bnr-box">                    
                    <div class="content-bnt-text" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Grow Your Business with a Remote Team</h2>
                        <p>
                            <a href="#" class="btn5">Create Freelance Employer Profile</a>
                            <?php /*if(!$isfreelancerhireactivate){ ?>
                                <a href="#" class="btn5 hide">Create Freelance Employer Profile</a>
                            <?php } else{ ?>
                                <a href="<?php echo base_url('freelance-hire/reactivateacc'); ?>" class="btn5">Reactive Freelance Employer Profile</a>
                            <?php }*/ ?>
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
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/reg.png') ?>">
                                <p>Register</p>
                                <span>Sign up for freelance hire profile for free and connect with great talent from all over the world.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/post-project.png') ?>">
                                <p>Post Project</p>
                                <span>Post freelance projects details, budget, and skills required for the job. </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url('assets/n-images/short-list.png') ?>">
                                <p>Hire Freelancer</p>
                                <span>Search or select from the recommended candidates provided by us or shortlist from applied freelancers.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url('assets/n-images/pay.png') ?>">
                                <p>Pay</p>
                                <span>Pay as per your convenient.</span>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- RELATED ARTICLE -->
            <div class="related-article">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h3>Related Articles</h3>
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
            <div class="container pt20 hidden">
                <div class="pt20 pb20">
                    <div class="center-title">
                        <h3>What is freelance hire </h3>
                        <p>Lorem ipsum is dummy text</p>
                    </div>
                </div>
                <div class="row pt20 pb20">
                    <div class="col-md-6 col-sm-6 pull-right">
                        <div class="content-img text-center">
                            <img src="<?php echo base_url(); ?>assets/n-images/img1.jpg">
                            
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
                            <img src="<?php echo base_url(); ?>assets/n-images/img1.jpg">
                            
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
                            <img src="<?php echo base_url(); ?>assets/n-images/img1.jpg">
                            
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
            <div class="content-bnr hidden">
                <div class="bnr-box">
                    <img src="<?php echo base_url(); ?>assets/n-images/img2.jpg">
                    <?php if(!$isfreelancerhireactivate){ ?>
                    <div class="content-bnt-text">
                        <h1>Lorem Ipsum is a dummy text</h1>
                        <p><a href="#" class="btn5">Create Recruiter Profile</a></p>
                    </div>
                    <?php } else{ ?>
                    <div class="content-bnt-text">
                        <h1>Lorem Ipsum is a dummy text</h1>
                        <p><a href="<?php echo base_url('freelance-hire/reactivateacc'); ?>" class="btn5">Reactive Recruiter Profile</a></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="container pt20 hidden">
                <div class="pt20 pb20">
                    <div class="center-title">
                        <h3>How it works </h3>
                        <p>Lorem ipsum is dummy text</p>
                    </div>
                </div>
                <div class="it-works-img pt20 pb20">
                    <img src="<?php echo base_url(); ?>assets/n-images/img3.jpg">
                </div>                
                <div class="related-article pt20">
                    <div class="center-title">
                        <h3>Related Article</h3>                            
                    </div>
                    <div class="row pt10">
                        <div class="col-md-4">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                <div class="rel-art-name">
                                    <a href="#">Article Name</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                <div class="rel-art-name">
                                    <a href="#">Article Name</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rel-art-box">
                                <img src="<?php echo base_url('assets/img/art-post.jpg') ?>">
                                <div class="rel-art-name">
                                    <a href="#">Article Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  poup modal  -->
        <div style="display:none;" class="modal fade" id="post-popup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="<?php echo base_url(); ?>assets/img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>
                            <div class="post-box-bottom">
                                <ul>
                                    <li>
                                        <a href="" data-target="#post-popup" data-toggle="modal">
                                            <img src="<?php echo base_url(); ?>assets/img/post-op.png"><span>Post Opportunity</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="article.html">
                                            <img src="<?php echo base_url(); ?>assets/img/article.png"><span>Post Article</span>
                                        </a>
                                    </li>
                                    <li class="pl15">
                                        <a href="" data-target="#ask-question" data-toggle="modal">
                                            <img src="<?php echo base_url(); ?>assets/img/ask-qustion.png"><span>Ask Quastion</span>
                                        </a>
                                    </li>
                                </ul>
                                <p class="pull-right">
                                    <button type="submit" class="btn1" value="Submit">Post</button>
                                </p>
                            </div>
                        </div>
                        
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="<?php echo base_url(); ?>assets/img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                </label>
                            </div>
                        </div>
                        <div class="post-field">
                            
                                <div id="content" class="form-group">
                                    <label>FOR WHOM THIS OPPORTUNITY ?<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, PHP Developer, HR, BDE, CA, Doctor, Freelancer.." cols="10" style="resize:none"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>WHICH LOCATION?<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <textarea type="text" class="" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai, Moscow, Paris, Tokyo.. "></textarea>
                                </div>
                                <div class="form-group">
                                    <label>What is your field?<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>
                            
                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <button type="submit" class="btn1"  value="Submit">Post</button> 
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                    <form>
                        <div class="post-box">
                            <div class="post-img">
                                <img src="<?php echo base_url(); ?>assets/img/user-pic.jpg">
                            </div>
                            <div class="post-text">
                                <textarea class="title-text-area" placeholder="Ask Quastion"></textarea>
                            </div>
                            <div class="all-upload">
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Add Screenshot </span></i>
                                    <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                                    
                                </label>
                            </div>
                        </div>
                        <div class="post-field">
                            
                                <div class="form-group">
                                    <label>Add Description<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Add Description" cols="10" style="resize:none"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Related Categories<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <input type="text" class="" placeholder="Related Categories">
                                </div>
                                <div class="form-group">
                                    <label>From which field the Question asked?<span class="pull-right"><img src="<?php echo base_url(); ?>assets/img/tooltip.png"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>
                        </div>
                        <div class="text-right fw pt10 pb20 pr15">
                            <button type="submit" class="btn1"  value="Submit">Post</button> 
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/hire_registration.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('artistApp', ['ui.bootstrap']); 
            var site = '<?php echo base_url(); ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
            AOS.init({
                easing: 'ease-in-out-sine'
            });
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/index.js?ver=' . time()) ?>"></script>
    </body>
</html>