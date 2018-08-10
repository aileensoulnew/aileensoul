<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- <title ng-bind="title"></title> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page without-reg find-art">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">
            <?php
                if ($ismainregister == false) {
                    // $this->load->view('artist_live/login_header');
                }else{
                    echo $header_profile;
                }
            ?>
            <?php
               if($ismainregister == false ){
            ?>
                <div class="middle-section middle-section-banner new-ld-page">
            <?php echo $search_banner; 
                } else if($isartistactivate == true && $artist_isregister == true) { ?>
                <div class="middle-section">
            <?php } else { ?>
                <div class="middle-section middle-section-banner">
            <?php echo $search_banner;  
            } ?>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
                <!-- TOP CATEGORIES LIST -->
                <div class="job-cat-lp" >
                    <div class="container" >
                        <div class="center-title">
                            <h2>Artist by Category</h2>
                        </div>
                        <div class="row pt20">
                            <?php
                            if(isset($artistCategory) && !empty($artistCategory)):
                                foreach($artistCategory as $_artistCategory): ?>
                            <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                                <div class="all-cat-box">
                                    <a href="<?php echo artist_category.$_artistCategory['category_slug']; ?>">
                                        <div class="cus-cat-middle">
                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                            <p><?php echo ucwords($_artistCategory['art_category']); ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
			
                        <div class="p20 fw">
                            <p class="p20 text-center">
                                <a href="<?php echo artist_category_list; ?>" class="btn-1">View More</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- TOP ARTIST LOCATION LIST -->
                <div class="job-cat-lp" >
                    <div class="container" >
                        <div class="center-title">
                            <h2>Artist by Location</h2>
                        </div>
                        <div class="row pt20">
                            <?php
                            if(isset($artistLocation) && !empty($artistLocation)):
                                foreach($artistLocation as $_artistLocation): ?>
                            <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                                <div class="all-cat-box">
                                    <a href="<?php echo artist_location.$_artistLocation['city_name']; ?>">
                                        <div class="cus-cat-middle">
                                            <img src="<?php echo CITY_IMG_PATH.'default_city.png'; ?>">
                                            <p><?php echo ucwords($_artistLocation['city_name']) ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
                        <div class="p20 fw">
                            <p class="p20 text-center"><a href="<?php echo artist_location_list ?>" class="btn-1">View More</a></p>
                        </div>
                    </div>
                </div>

                <!-- STATIC TEXT OF HOW ABOUT PROFILE -->
                <div class="how-about-profile">
                    <div class="container">
                        <div class="center-title">
                            <h2>How Aileensoul Artistic Profile Can Help Artist Reach Their Career Goals?</h2>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-8 col-sm-10 col-md-push-2 col-sm-push-1 text-center ">
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
                <div class="content-bnr art-bnr-prlx">
                    <div class="bnr-box">
                        
                        <div class="content-bnt-text">
                            <h2>Mark Impression on This World Through Your Creativity</h2>
                            <p>
                                <?php //if(!$isartistactivate){ ?>
                                <!-- <a href="<?php //echo artist_registration; ?>" class="btn5">Create Artist Profile</a> -->
                                <?php //} else{ ?>
                                <!-- <a href="<?php //echo artist_reactivateacc; ?>" class="btn5">Reactivate Artist Profile</a> -->
                                <?php //} ?>

                                <?php 
                                    if (($ismainregister == true && $artist_isregister == false) || ($ismainregister == false)) { 
                                ?>
                                    <?php 
                                        if ($ismainregister == true) { 
                                    ?>
                                        <a href="<?php echo base_url('artist-profile/signup'); ?>" class="btn5">Create Artist Profile</a>
                                    <?php }else { ?>
                                        <a href="<?php echo base_url().'artist-profile/create-account'; ?>" class="btn5 sda">Create Artist Profile</a>
                                    <?php } ?>
                                <?php } ?>

                            </p>
                        </div>
                    </div>
                </div>
				<div class="container">
					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
				</div>
                <!-- STATIC TEXT OF HOW IT WORKS -->
                <div class="how-it-work">
                    <div class="container">
                        <div class="center-title">
                            <h2>How it Works</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="hiw-box">
                                    <img src="<?php echo base_url('assets/n-images/reg.png') ?>">
                                    <p>Register</p>
                                    <span>Sign up in artistic profile for free and illustrate your talent.</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="hiw-box">
                                    <img src="<?php echo base_url('assets/n-images/connect.png') ?>">
                                    <p>Connect</p>
                                    <span>Grow your artist network by connecting with another artist from all over the world.</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
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
                            <div class="center-title">
                                <h3>Related Article</h3>
                            </div>
                            <div class="row pt20">
                                <?php 
                                if(isset($art_related_list) && !empty($art_related_list)):
                                    foreach($art_related_list as $_art_related_list): ?>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="also-like-box">
    										<div class="rec-img">
    											<a href="<?php echo base_url().'blog/'.$_art_related_list['blog_slug'] ?>">
    											<img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_art_related_list['image']; ?>">
    											</a>
    										</div>
                                            <div class="also-like-bottom">
                                                <p><a href="<?php echo base_url().'blog/'.$_art_related_list['blog_slug']; ?>"><?php echo $_art_related_list['title']; ?></a></p>
                                            </div>
    										<div class="clearfix"></div>
                                        </div>
    									
                                    </div>
                                <?php
                                    endforeach;
                                endif; ?>
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
        </div>
        <?php //$this->load->view('mobile_side_slide'); ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/artist-live/index.js?ver=' . time()) ?>"></script> -->
    </body>
</html>