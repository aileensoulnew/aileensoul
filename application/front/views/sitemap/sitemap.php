<!DOCTYPE html>
<?php
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
		header("HTTP/1.1 304 Not Modified");
		exit();
	}
	$format = 'D, d M Y H:i:s \G\M\T';
	$now = time();
	$date = gmdate($format, $now);
	header('Date: ' . $date);
	header('Last-Modified: ' . $date);
	$date = gmdate($format, $now + 30);
	header('Expires: ' . $date);
	header('Cache-Control: public, max-age=30');
?>
<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

		<link rel="canonical" href="<?php echo $actual_link ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">  
		<meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>" />
	<?php $this->load->view('adsense'); ?>
</head>
	<body class="sitemap old-no-login">
		<div class="">
			<header>
				<div class="">
					<div class="container">
						<div class="row">
                            <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
								<?php $this->load->view('main_logo'); ?>
                            </div>
                            <div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                                <div class="btn-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
									<ul class="nav navbar-nav navbar-right test-cus drop-down">
										<?php $this->load->view('profile-dropdown'); ?>
										<li><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
										<li class="mob-bar-li">
											<span class="mob-right-bar">
												<?php $this->load->view('mobile_right_bar'); ?>
											</span>
										</li>
									
									</ul>
                                <?php }?>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</header>
		</div>	
		<div class="middle-section">
			<div class="container mobp0">
				<div class="sitemap">
					<h1>
						<a href="<?php echo base_url().'sitemap'; ?>">Sitemap</a>
					</h1>
					<div class="site-box">
						<div class="">
							<div class="dir-box">
								<h3>Directories</h3>
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/people' ?>">	Members 
												</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/artist' ?>">Artist</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/companies' ?>">Companies</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/jobs' ?>">Jobs</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/freelance-jobs' ?>">Freelance Jobs</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/blogs' ?>">Blog</a>
											</li>
										</ul>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6">
								<div class="site-pr-box">
									<h3>Job Profile</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_job; ?>">Login  </a></li>
										<li><a href="<?php echo base_url().'job-profile/create-account' ?>">Create Account </a></li>
										<li><a href="<?php echo base_url().'job-search' ?>">Job Search </a></li>
										<li><a href="<?php echo base_url().'jobs-by-location' ?>">View Jobs by Location </a></li>
										<li><a href="<?php echo base_url().'jobs-by-skills' ?>">View Jobs by Skills</a></li>
										<li><a href="<?php echo base_url().'jobs-by-designations' ?>">View Jobs by Designation </a></li>
										<li><a href="<?php echo base_url().'jobs-by-companies' ?>">View Jobs by Company </a></li>
										<li><a href="<?php echo base_url().'jobs-by-categories' ?>">View Jobs by Category</a></li>
										<li><a href="<?php echo base_url().'jobs' ?>">View Other Jobs </a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="site-pr-box">
									<h3>
										<a href="<?php echo base_url().'recruiter' ?>">
											Recruiter Profile
										</a>										
									</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_rec; ?>">Login </a></li>
										<li><a href="<?php echo base_url().'recruiter/create-account' ?>">Create Recruiter Account </a></li>
									</ul>
								</div>
								<div class="site-pr-box">
									<h3>Business Profile</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_bus; ?>">Login</a></li>
										<li><a href="<?php echo base_url().'business-profile/create-account' ?>">Create Business Account</a></li>
										<li><a href="<?php echo base_url().'business-search' ?>">Business Search</a></li>
										<li><a href="<?php echo base_url().'business-by-categories' ?>">View Business by Category</a></li>
										<li><a href="<?php echo base_url().'business-by-location' ?>">View Business by Location</a></li>
										<li><a href="<?php echo base_url().'business' ?>">View Other Business</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="site-pr-box">
									<h3>
										<a href="<?php echo base_url().'freelance-employer' ?>">
											Freelance Employer Profile
										</a>
									</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_free_emp; ?>">Login</a></li>
										<li><a href="<?php echo base_url().'freelance-employer/create-account' ?>">Create Freelance Employer Account</a></li>
										<!-- <li><a href="<?php //echo base_url().'post-freelance-project' ?>">Post Projects</a></li> -->
									</ul>
								</div>
								<div class="site-pr-box">
									<h3>Freelancer Profile</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_free_pro; ?>">Login  </a></li>
										<li><a href="<?php echo base_url().'freelancer/create-account' ?>">Create Freelance Account</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs' ?>">Freelance Jobs</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs-by-fields' ?>">View Freelance Jobs by Fields</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs-by-categories' ?>">View Freelance Jobs by Categories</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="site-pr-box">
									<h3>Artistic Profile</h3>
									<ul>
										<li><a href="<?php echo $sitemap_with_login_art; ?>">Login</a></li>
										<li><a href="<?php echo base_url().'artist-profile/create-account' ?>">Create Account</a></li>
										<li><a href="<?php echo base_url().'find-artist' ?>">Find Artist</a></li>
										<li><a href="<?php echo base_url().'artist/category' ?>">View Artist by Category</a></li>
										<li><a href="<?php echo base_url().'artist/location' ?>">View Artist by Location</a></li>
										<li><a href="<?php echo base_url().'artist' ?>">View Other Artist</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="">
							<div class="dir-box">
								<h3>General Information</h3>
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url() ?>">Home </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'about-us' ?>">About Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'privacy-policy' ?>">Privacy Policy </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'disclaimer-policy' ?>">Disclaimer Policy </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'terms-and-condition' ?>">Terms & Conditions</a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'feedback' ?>">FeedBack </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'contact-us' ?>">Contact Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'advertise-with-us' ?>">Advertise With Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'report-abuse' ?>"> Report Spam </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-6">
										<ul>
											<li><a href="<?php echo base_url().'faq' ?>"> FAQ </a></li>
										</ul>
									</div>
								</div>							
							</div>
						</div>
					</div>
					<div class="">
						<img src="<?php echo base_url('assets/n-images/sitemap.jpg') ?>" style="width:100%;">
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('mobile_side_slide'); ?>
		<?php echo $login_footer ?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
		<script>			
			// mcustom scroll bar
			(function($){
				$(window).on("load",function(){
					$(".custom-scroll").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"minimal"
					});
				});
			})(jQuery);
		</script>
		<script>
			$(function(){
				$(".dropdown").hover(            
					function() {
						$('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
						$(this).toggleClass('open');
						$('b', this).toggleClass("caret caret-up");                
					},
					function() {
						$('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
						$(this).toggleClass('open');
						$('b', this).toggleClass("caret caret-up");                
					});
			});
		</script>
	</body>
</html>