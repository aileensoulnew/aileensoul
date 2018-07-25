<!DOCTYPE html>
<html lang="en">
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
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
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
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page without-reg free-hire-cus ftr-page">

        <div class="middle-section middle-section-banner new-ld-page">
            
            
            <?php echo $search_banner; ?>
            <div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title">
                        <h3>Fields</h3>
                    </div>
                    <div class="row pt20">
                        <?php
                        if(isset($FAFields) && !empty($FAFields)):
                            foreach($FAFields as $_FAFields): ?>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url().'freelance-jobs/'.$_FAFields['category_slug']; ?>">
                                    <div class="cus-cat-middle">
                                    <img src="<?php echo FA_CATEGORY_IMG_PATH."/".$_FAFields['category_image'];?>">
                                    <p class=""><?php echo $_FAFields['category_name']; ?></p>
                                    <!-- <span><?php //echo $_FAFields['count']; ?> jobs</span> -->
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                    <div class="p20 fw">
                        <p class="p20 text-center"><a href="<?php echo base_url(); ?>freelance-jobs-by-fields" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>
            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title">
                        <h3>Categories</h3>
                    </div>
                    <div class="row pt20">
                        <?php
                        if(isset($FASkills) && !empty($FASkills)):
                            foreach($FASkills as $_FASkills):?>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url().'freelance-jobs/'.$_FASkills['skill_slug']; ?>">
                                    <div class="cus-cat-middle">
                                    <img src="<?php echo SKILLS_IMG_PATH."/".$_FASkills['skill_image'];?>">
                                    <p class=""><?php echo $_FASkills['skill']; ?></p>
                                    <!-- <span><?php //echo $_FASkills['count']; ?> jobs</span> -->
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                    <div class="p20 fw">
                        <p class="p20 text-center"><a href="<?php echo base_url(); ?>freelance-jobs-by-categories" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>
            <div class="content-bnr free-apply-bnr-prlx">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text">
                        <h2>Start Your Freelance Career with Aileensoul</h2>
                        <p><a href="<?php echo base_url('freelancer/create-account'); ?>" class="btn5">Create Freelancer Profile</a></p>
                    </div>
                </div>
            </div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
            <div class="how-it-work">
                <div class="container">
                    <div class="center-title">
                        <h3>How it works</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/reg.png">
                                <p>Register</p>
                                <span>Sign up for free, fill up your details and showcase your work portfolio.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box">
                                <img src="<?php echo base_url(); ?>assets/n-images/find-work.png">
                                <p>Find work</p>
                                <span>Get notified when someone selects you for a project or search for work or even apply for the recommended projects we provide.</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url(); ?>assets/n-images/bid-earn.png">
                                <p>Bid and Earn</p>
                                <span>Communicate and send your bid and earn a little extra income.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="related-article">
                <div class="container">
                        <div class="center-title">
                            <h3>Related Articles</h3>

                        </div>
                        <div class="row pt20">
                            <?php
                            if(isset($free_job_related_list) && !empty($free_job_related_list)):
                                foreach($free_job_related_list as $_free_job_related_list): ?>
                                <div class="col-md-4 col-sm-4">
                                    <div class="also-like-box">
    									<div class="rec-img">
    										<a href="<?php echo base_url().'blog/'.$_free_job_related_list['blog_slug']; ?>">
    										<img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_free_job_related_list['image']; ?>">
    										</a>
    									</div>
                                        <div class="also-like-bottom">
                                            <p><a href="<?php echo base_url().'blog/'.$_free_job_related_list['blog_slug']; ?>"><?php echo $_free_job_related_list['title']; ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            endif;?>
                        </div>
                    </div>
                </div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
            <?php echo $login_footer; ?>
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
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
            // var app = angular.module('', ['ui.bootstrap']);            
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
        <!-- <script type="text/javascript" src="<?php //echo base_url('assets/js/webpage/freelancer-apply-live/freelancer_apply_without_main_regi.js'); ?>"></script> -->
    </body>
</html>