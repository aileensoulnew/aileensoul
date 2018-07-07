<!DOCTYPE html>
<html lang="en" ng-app="recruiterApp" ng-controller="recruiterController">
    <head>
        <!-- <title ng-bind="title"></title> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page ftr-page">

        <div class="middle-section middle-section-banner new-ld-page">
            
            <div class="search-banner cus-search-bnr free-hire-bnr" >
                <header>
                    <div class="">
                        <div class="container">
							<div class="row">
								<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
									<?php $this->load->view('main_logo'); ?>
								</div>
								<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
									<div class="btn-right other-hdr">
										<?php if (!$this->session->userdata('aileenuser')) { ?>
										<ul class="nav navbar-nav navbar-right test-cus drop-down">
											<?php $this->load->view('profile-dropdown'); ?>
											<li class="hidden-991"><a href="<?php echo base_url('freelance-employer/create-account'); ?>">Post Project</a></li>
											<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
											<li class="hidden-991"><a href="<?php echo base_url('freelance-employer/create-account'); ?>" class="btn9">Create Account</a></li>
											<li class="mob-bar-li">
												<span class="mob-right-bar">
													<?php $this->load->view('mobile_right_bar'); ?>
												</span>
											</li>
															
										</ul>
										<?php } ?>
									</div>
								</div>
							   
							</div>
                            
                        </div>
                    </div>
                </header>
				<div class="ld-sub-header only-rec-cus">
					<div class="container">
						
						<div class="mob-ld-sub">
							<ul class="">
								<li class="tab-first-li">
									<a href="<?php echo base_url('freelance-employer/create-account'); ?>">Post Project</a>
								</li>
								<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
								<li><a href="<?php echo base_url('business-profile/create-account'); ?>"><span class="hidden-479">Create Freelance Employer Profile</span><span class="visible-479">Sign Up</span></a></li>
							</ul>
						</div>
					</div>
				</div>
                <div class="container">
					
                    <div class="row banner-main-div">
                        <div class="col-md-6 col-sm-12 banner-left">
                            <h1 class="pb15">Smart People Are Secret Behind Successful Business</h1>
                            <p class="">Find and get the work done by skilled freelancer from across the world through collaborative platform</p>
                        
                        
                            <!--img class="pt20" src="<?php echo base_url(); ?>assets/n-images/free-hire-bnr.png"-->
                        </div>
                        <div class="col-md-6 right-bnr hidden-xs">
                            <img src="<?php echo base_url(); ?>assets/n-images/free-hire.png">

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="sub-fix-head hide">
                <div class="container">
                    <h2><span>Get the Job Done</span><a class="pull-right btn-1" href="#">Post a Project</a></h2>
                </div>
            </div>
            
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title" >
                        <h2>How Can Aileensoul Freelance Profile Help in Hiring Remote Talent?</h2>
                    </div>
                    <div class="row" >
                        
                        <div class="col-md-8 col-sm-10 col-md-push-2 col-sm-push-1 text-center">
                            <p>Freelancing is no longer an uncommon word, with a vast number of population involved. Penetration of technology and easy access to internet has made freelancing a more preferred choice. </p>
                            <p>A distinct Freelance profile is offered by Aileensoul for free which allows the users to both hire and get freelance work from the web portal. </p>
                            <p>Freelance Hire profile is especially for freelance recruiters looking out for hiring talented candidates with a hassle-free process. </p>
                            <p>Furthermore, the freelance recruiter can easily put in the skills he/she is requiring for the work and get options as per one’s requirement.The profile also gives the client an option to communicate freely with the candidates.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-bnr free-hire-bnr-prlx">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text" >
                        <h2>Grow Your Business with a Remote Team</h2>
                        <p><a href="<?php echo base_url('freelance-employer/create-account'); ?>" class="btn5">Create Freelance Employer Account</a></p>
                    </div>
                </div>
            </div>
            <div class="how-it-work">
                <div class="container">
                    <div class="center-title" >
                        <h2>How it Works</h2>
                    </div>
                    <div class="row" >
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/reg.png">
                                <p>Register</p>
                                <span>Sign up for freelance hire profile for free and connect with great talent from all over the world.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/post-project.png">
                                <p>Post Project</p>
                                <span>Post freelance projects details, budget, and skills required for the job. </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/short-list.png">
                                <p>Hire Freelancer</p>
                                <span>Search or select from the recommended candidates provided by us or shortlist from applied freelancers.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url(); ?>assets/n-images/pay.png">
                                <p>Pay</p>
                                <span>Pay as per your convenient.</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="related-article">
                <div class="container">
                        <div class="center-title" >
                            <h3>Related Articles</h3>
                        </div>
                        <div class="row pt20" >
                            <?php
                            if(isset($free_hire_related_list) && !empty($free_hire_related_list)):
                                foreach($free_hire_related_list as $_free_hire_related_list): ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="also-like-box">
									<div class="rec-img">
										<a href="<?php echo base_url().'blog/'.$_free_hire_related_list['blog_slug']; ?>">
										<img ng-src="<?php echo base_url($this->config->item('blog_main_upload_path').$_free_hire_related_list['image']); ?>">
										</a>
									</div>
                                    <div class="also-like-bottom">
                                        <p><a href="<?php echo base_url().'blog/'.$_free_hire_related_list['blog_slug']; ?>"><?php echo $_free_hire_related_list['title']; ?></a></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
			<?php $this->load->view('mobile_side_slide'); ?>
            <?php echo $login_footer; ?>
        </div>

        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';            
            var title = '<?php echo $title; ?>';            
            var q = '';
            var l = '';
            var app = angular.module('recruiterApp', ['ui.bootstrap']);            
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire-live/freelancer_hire_without_main_register.js'); ?>"></script>
    </body>
</html>