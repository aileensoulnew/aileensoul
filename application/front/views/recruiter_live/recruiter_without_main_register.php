<!DOCTYPE html>
<html lang="en" ng-app="recruiterApp" ng-controller="recruiterController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <title ng-bind="title"></title> -->
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
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
    <body class="profile-main-page without-reg ftr-page">

        <div class="middle-section middle-section-banner new-ld-page">
            
            <div class="search-banner cus-search-bnr" >
                <header>
                    <div class="header">
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
											<li class="hidden-991"><a href="<?php echo base_url('recruiter/create-account'); ?>">Post Job</a></li>
											<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
											<li class="hidden-991"><a href="<?php echo base_url('recruiter/create-account'); ?>" class="btn9">Create Recruiter Profile</a></li>
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
									<a href="<?php echo base_url('recruiter/create-account'); ?>">Post Job</a>
								</li>
								<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
								<li><a href="<?php echo base_url('recruiter/create-account'); ?>"><span class="hidden-479">Create Recruiter Profile</span><span class="visible-479">Sign Up</span></a></li>
							</ul>
						</div>
					</div>
				</div>
                <div class="container">
                    <div class="row banner-main-div">
                        <div class="col-md-6 col-sm-12 banner-left">
                            <h1 class="pb15">Hurdles Becomes Simple with a Right Person Besides You</h1>
                            <p>Easily reach, engage, and hire the job seekers through Aileensoul platform</p>
                        </div>
                        <div class="col-md-6 right-bnr hidden-xs">
                            <img src="<?php echo base_url(); ?>assets/n-images/rec-bnr-img.png">

                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="sub-fix-head hide">
                <div class="container">
                    <h2><span>Hire the Right Candidates</span><a class="pull-right btn-1" href="#">Post a Job</a></h2>
                </div>
            </div>
            
            <div class="how-about-profile">
                <div class="container">
                    <div class="center-title" >
                        <h2>How Can Aileensoul Recruiter Profile Help in Hiring Relevant Candidate?</h2>
                    </div>
                    <div class="row" >
                        
                        <div class="col-md-8 col-sm-10 col-md-push-2 col-sm-push-1 text-center ">
                            <p>With a lot of job portals popping up nowadays, it has given an edge to the job seeker’s by providing them with lot of opportunities. But the recruiters are often put on the disadvantageous side as the portals charge them for putting up their posts. </p>
                            <p>Here, at Aileensoul the Recruiter profile is free for all, letting the employer post as many job requirements as they need. Recruiters can hire from the large number of job seekers available in Aileensoul.</p>
                            <p>A good number of filters and options help recruiters find the exact kind of candidate he/she is seeking.Also, the chat option feature helps the employer directly connect with job seekers and ask questions before making any hiring decision.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-bnr recruiter-bnr-prlx">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text" >
                        <h2>Put a Full Stop at Your Employee Hunting Process</h2>
                        <p><a href="<?php echo base_url('recruiter/create-account'); ?>" class="btn5">Create Recruiter Account</a></p>
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
                                <span>Sign up for free and enter your details.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/post-project.png">
                                <p>Post Job</p>
                                <span>Post your requirement and the skills that you are looking for candidates. </span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/find-job.png">
                                <p>Find Job-Seeker</p>
                                <span>Search or shortlist candidates from the recommendation we provide for your requirement.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url(); ?>assets/n-images/hire.png">
                                <p>Hire</p>
                                <span>Select and Invite candidates for an interview.</span>
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
                            if(isset($recruiter_related_list) && !empty($recruiter_related_list)):
                                foreach($recruiter_related_list as $_recruiter_related_list): ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="also-like-box">
									<div class="rec-img">
										<a href="<?php echo base_url().'blog/'.$_recruiter_related_list['blog_slug']; ?>">
										<img ng-src="<?php echo base_url($this->config->item('blog_main_upload_path').$_recruiter_related_list['image']); ?>">
										</a>
									</div>
                                    <div class="also-like-bottom">
                                        <p><a href="<?php echo base_url().'blog/'.$_recruiter_related_list['blog_slug']; ?>"><?php echo $_recruiter_related_list['title']; ?></a></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;
                            endif;?>
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
              <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter-live/recruiter_without_main_register.js'); ?>"></script>
      <?php   /*if (IS_REC_JS_MINIFY == '0') {
            ?>
              <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_reg.js'); ?>"></script>
            <?php
        } else {
            ?>
              <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_reg.js'); ?>"></script>
        <?php }*/ ?>

       
    </body>
</html>